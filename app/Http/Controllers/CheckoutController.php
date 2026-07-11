<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Tampilkan form checkout
     */
    public function create(Event $event)
    {
        // Cek stok terlebih dahulu
        if ($event->stock <= 0) {
            return back()->with('error', 'Mohon maaf, tiket untuk acara ini sudah habis.');
        }

        $categories = Category::all();
        return view('checkout.create', compact('event', 'categories'));
    }

    /**
     * Proses penyimpanan transaksi dengan RESERVED STOCK SYSTEM
     * Menggunakan atomic transaction untuk mencegah race condition
     */
    public function store(Request $request, Event $event)
    {
        // 1. Validasi Input
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        // 2. ATOMIC TRANSACTION + ROW LOCKING (Mencegah Race Condition)
        try {
            $transaction = DB::transaction(function () use ($request, $event) {
                // Lock row event untuk mencegah concurrent update
                // Ini akan memblokir transaksi lain sampai transaksi ini selesai
                $lockedEvent = Event::where('id', $event->id)
                    ->lockForUpdate()
                    ->first();
                
                // Cek stok setelah lock (double check)
                if ($lockedEvent->stock <= 0) {
                    throw new \Exception('Stok habis! Tiket sudah terjual semua.');
                }

                // 3. Reserve stok (kurangi 1)
                $lockedEvent->decrement('stock');
                
                // 4. Generate Order ID Unik
                $orderId = 'TRX-' . time() . '-' . Str::random(5);
                $totalPrice = $lockedEvent->price + 5000; // Harga + biaya admin

                // 5. Simpan transaksi dengan status RESERVED
                $trx = Transaction::create([
                    'user_id' => auth()->id(),
                    'event_id' => $lockedEvent->id,
                    'order_id' => $orderId,
                    'customer_name' => $request->customer_name,
                    'customer_email' => $request->customer_email,
                    'customer_phone' => $request->customer_phone,
                    'total_price' => $totalPrice,
                    'status' => 'reserved', // ← Status baru: reserved
                    'reserved_until' => now()->addMinutes(15), // ← Batas waktu 15 menit
                ]);

                return $trx;
            });

            // 6. Generate Midtrans Snap Token (di luar DB transaction)
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $transaction->order_id,
                    'gross_amount' => $transaction->total_price,
                ],
                'customer_details' => [
                    'first_name' => $transaction->customer_name,
                    'email' => $transaction->customer_email,
                    'phone' => $transaction->customer_phone,
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            
            // 7. Simpan Snap Token ke database
            $transaction->update(['snap_token' => $snapToken]);
            
            // 8. Redirect ke halaman pembayaran
            return redirect()->route('checkout.payment', $transaction->order_id);
            
        } catch (\Exception $e) {
            // Handle error (stok habis, Midtrans error, dll)
            return back()->with('error', 'Gagal memproses checkout: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan halaman pembayaran Midtrans
     */
    public function payment($order_id)
    {
        $categories = \App\Models\Category::all();
        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();
        
        // Cek apakah reservation masih valid
        if ($transaction->isExpired()) {
            return redirect()->route('tickets.index')
                ->with('error', 'Waktu pembayaran telah habis. Silakan lakukan checkout ulang.');
        }
        
        return view('checkout.payment', compact('transaction', 'categories'));
    }

        /**
     * Tampilkan halaman sukses setelah pembayaran & Update Status
     * Dengan Fallback Check untuk handle webhook yang tidak masuk
     */
    public function success($order_id)
    {
        $categories = \App\Models\Category::all();
        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();
        
        // Cek apakah reservation sudah expired
        if ($transaction->isExpired()) {
            // Update status ke expired
            $transaction->update(['status' => 'expired']);
            
            // Kembalikan stok ke event
            if ($transaction->event) {
                $transaction->event->increment('stock');
            }
            
            return view('checkout.failed', compact('transaction', 'categories'));
        }
        
        // Konfigurasi Midtrans untuk cek status langsung ke API
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        try {
            // FALLBACK CHECK: Cek status transaksi secara manual ke API Midtrans
            $midtransStatus = \Midtrans\Transaction::status($order_id);
            $status = $midtransStatus->transaction_status;

            // Cek apakah status di database masih reserved/pending
            if (in_array(strtolower($transaction->status), ['reserved', 'pending'])) {
                
                // Jika API Midtrans mengonfirmasi transaksi berhasil
                if (in_array($status, ['settlement', 'capture'])) {
                    
                    // Update status ke success
                    $transaction->update(['status' => 'success']);
                    
                    // Kirim email E-Ticket
                    try {
                        \Illuminate\Support\Facades\Mail::to($transaction->customer_email)
                            ->send(new \App\Mail\EventTicketMail($transaction));
                        \Log::info('E-Ticket email sent via fallback check to: ' . $transaction->customer_email);
                    } catch (\Exception $e) {
                        \Log::error('Gagal mengirim email E-Ticket via fallback: ' . $e->getMessage());
                    }
                    
                    \Log::info('Fallback check berhasil: Transaction ' . $order_id . ' updated to success');
                    return view('checkout.success', compact('transaction', 'categories'));
                    
                } elseif ($status == 'pending') {
                    // Masih menunggu pembayaran (VA belum dibayar)
                    // Redirect kembali ke halaman payment agar user bisa bayar lagi
                    \Log::info('Transaction ' . $order_id . ' masih pending di Midtrans, redirect ke payment');
                    return redirect()->route('checkout.payment', $order_id);
                    
                } elseif (in_array($status, ['deny', 'expire', 'cancel', 'failure'])) {
                    // Pembayaran gagal/expire/cancel dari Midtrans
                    $transaction->update(['status' => 'failed']);
                    
                    // Kembalikan stok ke event
                    if ($transaction->event) {
                        $transaction->event->increment('stock');
                    }
                    
                    \Log::warning('Transaction ' . $order_id . ' failed/expired di Midtrans');
                    return view('checkout.failed', compact('transaction', 'categories'));
                }
            }
            
            // Jika status di database sudah success
            if (strtolower($transaction->status) === 'success') {
                return view('checkout.success', compact('transaction', 'categories'));
            }
            
            // Jika status di database failed/expired/cancelled
            if (in_array(strtolower($transaction->status), ['failed', 'expired', 'cancelled'])) {
                return view('checkout.failed', compact('transaction', 'categories'));
            }
            
            // Default: redirect ke halaman payment (untuk reserved yang belum dicek)
            return redirect()->route('checkout.payment', $order_id);
            
        } catch (\Exception $e) {
            // Jika gagal cek ke Midtrans (transaksi tidak ditemukan, network error, dll)
            \Log::error('Fallback Check Failed for ' . $order_id . ': ' . $e->getMessage());
            
            // Cek status lokal
            $statusLower = strtolower($transaction->status);
            
            if (in_array($statusLower, ['success', 'settlement'])) {
                return view('checkout.success', compact('transaction', 'categories'));
            } elseif (in_array($statusLower, ['failed', 'expired', 'cancelled'])) {
                return view('checkout.failed', compact('transaction', 'categories'));
            } else {
                // Untuk reserved/pending, redirect ke halaman payment
                return redirect()->route('checkout.payment', $order_id);
            }
        }
    }

        /**
     * Batalkan pesanan dan kembalikan stok
     */
    public function cancel($order_id)
    {
        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();
        
        // Validasi: hanya bisa cancel jika status masih reserved/pending
        if (!in_array(strtolower($transaction->status), ['reserved', 'pending'])) {
            return redirect()->route('tickets.index')
                ->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }
        
        try {
            \Illuminate\Support\Facades\DB::transaction(function () use ($transaction) {
                // Update status ke cancelled
                $oldStatus = $transaction->status;
                $transaction->update(['status' => 'cancelled']);
                
                // Kembalikan stok ke event
                if ($transaction->event) {
                    $transaction->event->increment('stock');
                    
                    \Log::info('Stok dikembalikan untuk pesanan yang dibatalkan: ' . $transaction->order_id);
                }
                
                // Catat di activity log
                \App\Models\ActivityLog::create([
                    'user_id' => auth()->id(),
                    'transaction_id' => $transaction->id,
                    'action' => 'order_cancelled_by_user',
                    'old_status' => $oldStatus,
                    'new_status' => 'cancelled',
                    'reason' => 'Dibatalkan oleh user',
                ]);
            });
            
            return redirect()->route('tickets.index')
                ->with('success', 'Pesanan berhasil dibatalkan. Stok tiket telah dikembalikan.');
                
        } catch (\Exception $e) {
            \Log::error('Gagal membatalkan pesanan: ' . $transaction->order_id . ' - ' . $e->getMessage());
            
            return redirect()->route('tickets.index')
                ->with('error', 'Gagal membatalkan pesanan. Silakan coba lagi.');
        }
    }
}