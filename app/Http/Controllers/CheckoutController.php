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
    public function store(Request $request, $eventId)
    {
        // Validasi input
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        // Ambil event dengan lock untuk mencegah race condition
        $event = Event::lockForUpdate()->findOrFail($eventId);

        // Cek stok tersedia
        if ($event->stock <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok tiket sudah habis!');
        }

        // Cek apakah event GRATIS
        $isFreeEvent = ($event->price == 0);

        try {
            return DB::transaction(function () use ($event, $request, $isFreeEvent) {
                // Kurangi stok event
                $event->decrement('stock');

                // Generate Order ID unik
                $orderId = 'TRX-' . time() . '-' . strtoupper(Str::random(6));

                // Hitung total harga
                $serviceFee = $isFreeEvent ? 0 : 5000; // Biaya layanan hanya untuk event berbayar
                $totalPrice = $event->price + $serviceFee;

                // Buat transaksi
                $transaction = Transaction::create([
                    'order_id' => $orderId,
                    'event_id' => $event->id,
                    'customer_name' => $request->customer_name,
                    'customer_email' => $request->customer_email,
                    'customer_phone' => $request->customer_phone,
                    'total_price' => $totalPrice,
                    'status' => $isFreeEvent ? 'success' : 'reserved', // Langsung success jika gratis
                    'reserved_until' => $isFreeEvent ? null : now()->addMinutes(15), // Tidak perlu reserved_until jika gratis
                    'snap_token' => null, // Tidak perlu snap_token jika gratis
                ]);

                // Catat di activity log
                \App\Models\ActivityLog::create([
                    'user_id' => auth()->id(),
                    'transaction_id' => $transaction->id,
                    'action' => $isFreeEvent ? 'free_event_registered' : 'checkout_created',
                    'old_status' => null,
                    'new_status' => $transaction->status,
                    'reason' => $isFreeEvent ? 'Event gratis - langsung sukses' : 'Checkout dibuat - menunggu pembayaran',
                ]);

                // Jika event GRATIS, langsung kirim email E-Ticket
                if ($isFreeEvent) {
                    \App\Jobs\SendEticketJob::dispatch($transaction);
                    
                    return redirect()->route('ticket', $orderId)
                        ->with('success', 'Pendaftaran berhasil! E-Ticket telah dikirim ke email Anda.');
                }

                // Jika event BERBAYAR, buat Snap Token Midtrans
                $midtransParams = [
                    'enable_payments' => ['gopay', 'bank_transfer', 'qris'],
                    'transaction_details' => [
                        'order_id' => $transaction->order_id,
                        'gross_amount' => (int) $transaction->total_price,
                    ],
                    'customer_details' => [
                        'first_name' => $transaction->customer_name,
                        'email' => $transaction->customer_email,
                        'phone' => $transaction->customer_phone,
                    ],
                    'expiry' => [
                        'start_time' => now()->format('Y-m-d H:i:s'),
                        'unit' => 'minutes',
                        'duration' => 15,
                    ],
                ];

                try {
                    $snapToken = \Midtrans\Snap::getSnapToken($midtransParams);
                    $transaction->update(['snap_token' => $snapToken]);
                } catch (\Exception $e) {
                    \Log::error('Midtrans Snap Token Error: ' . $e->getMessage());
                    return redirect()->back()->with('error', 'Gagal membuat token pembayaran. Silakan coba lagi.');
                }

                // Redirect ke halaman pembayaran
                return redirect()->route('checkout.payment', $transaction->order_id);
            });

        } catch (\Exception $e) {
            \Log::error('Checkout Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
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
                        \App\Jobs\SendEticketJob::dispatch($transaction);
                    
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