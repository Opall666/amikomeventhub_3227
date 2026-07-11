<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
     * Proses penyimpanan transaksi
     */
    public function store(Request $request, Event $event)
    {
        // 1. Validasi Input
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        // 2. Cek stok lagi (double check)
        if ($event->stock <= 0) {
            return back()->with('error', 'Mohon maaf, tiket untuk acara ini sudah habis.');
        }

        // 3. Generate Order ID Unik
        $orderId = 'TRX-' . time() . '-' . Str::random(5);
        $totalPrice = $event->price + 5000; // Harga + biaya admin

        // 4. Simpan transaksi dengan status PENDING
        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
            'order_id' => $orderId,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);


        // --- INTEGRASI SNAP MIDTRANS ---
        
        // Konfigurasi Kredensial Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Susun Data Transaksi untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $request->customer_name,
                'email' => $request->customer_email,
                'phone' => $request->customer_phone,
            ],
        ];

        try {
            // Generate Snap Token dari Midtrans
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            
            // Simpan Snap Token ke database
            $transaction->update(['snap_token' => $snapToken]);
            
            // Redirect ke halaman pembayaran
            return redirect()->route('checkout.payment', $orderId);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan halaman pembayaran Midtrans
     */
    public function payment($order_id)
    {
        $categories = \App\Models\Category::all();
        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();
        
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
        
        // Konfigurasi Midtrans untuk cek status langsung ke API
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        try {
            // FALLBACK CHECK: Cek status transaksi secara manual ke API Midtrans
            $midtransStatus = \Midtrans\Transaction::status($order_id);
            $status = $midtransStatus->transaction_status;
            $fraud = $midtransStatus->fraud_status ?? null;

            // Cek apakah status di database masih pending
            // (indikasi webhook tidak masuk atau gagal)
            if (strtolower($transaction->status) === 'pending') {
                
                // Jika API Midtrans mengonfirmasi transaksi berhasil
                if (in_array($status, ['settlement', 'capture'])) {
                    
                    // Update status ke success
                    $transaction->update(['status' => 'success']);
                    
                    // Kurangi stok event (jika belum dikurangi)
                    if ($transaction->event && $transaction->event->stock >= 0) {
                        // Cek apakah stok sudah dikurangi sebelumnya
                        // Jika belum, kurangi sekarang
                        $transaction->event->stock = $transaction->event->stock - 1;
                        $transaction->event->save();
                        
                        // Kirim email E-Ticket (jika belum dikirim)
                        try {
                            \Illuminate\Support\Facades\Mail::to($transaction->customer_email)
                                ->send(new \App\Mail\EventTicketMail($transaction));
                                
                            \Log::info('E-Ticket email sent via fallback check to: ' . $transaction->customer_email);
                        } catch (\Exception $e) {
                            \Log::error('Gagal mengirim email E-Ticket via fallback: ' . $e->getMessage());
                        }
                    }
                    
                    \Log::info('Fallback check berhasil: Transaction ' . $order_id . ' updated to success');
                }
                // Jika status di Midtrans masih pending
                elseif ($status == 'pending') {
                    // Biarkan status pending, user belum bayar
                    \Log::info('Transaction ' . $order_id . ' masih pending di Midtrans');
                }
                // Jika status di Midtrans gagal/expire
                elseif (in_array($status, ['deny', 'expire', 'cancel', 'failure'])) {
                    $transaction->update(['status' => 'failed']);
                    \Log::warning('Transaction ' . $order_id . ' failed/expired di Midtrans');
                }
            }
        } catch (\Exception $e) {
            // Jika gagal cek ke Midtrans (transaksi tidak ditemukan, network error, dll)
            \Log::error('Fallback Check Failed for ' . $order_id . ': ' . $e->getMessage());
            
            // Jangan tampilkan error ke user, biarkan halaman success tetap muncul
            // Status tetap seperti yang ada di database
        }

        return view('checkout.success', compact('transaction', 'categories'));
    }
}