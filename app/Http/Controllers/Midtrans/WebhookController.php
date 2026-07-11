<?php

namespace App\Http\Controllers\Midtrans;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    /**
     * Handle webhook notification dari Midtrans
     */
    /**
     * Handle webhook notification dari Midtrans
     */
    public function handleNotification(Request $request)
    {
        // 1. Ambil data dari Midtrans
        $notif = json_decode($request->getContent());
        
        // 2. Validasi data
        if (!$notif || !isset($notif->order_id)) {
            return response()->json(['message' => 'Invalid notification'], 400);
        }
        
        // 3. Cari transaksi berdasarkan order_id
        $transaction = Transaction::where('order_id', $notif->order_id)
            ->with('event')  // Load relasi event
            ->first();
        
        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }
        
        // 4. Verifikasi signature key (keamanan)
        // DISABLED FOR LOCAL TESTING - Enable this in production!
        /*
        $serverKey = config('midtrans.server_key');
        $signatureKey = hash('sha512', $notif->order_id . $notif->status_code . $notif->gross_amount . $serverKey);
        
        if ($signatureKey !== $notif->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }
        */
        
        // 5. Update status transaksi berdasarkan response Midtrans
        $midtransStatus = $notif->transaction_status;
        
        if (in_array($midtransStatus, ['capture', 'settlement'])) {
            // Pembayaran berhasil
            $transaction->update(['status' => 'success']);
            
            // Panggil fungsi processSuccess untuk kurangi stok & kirim email
            $this->processSuccess($transaction);
            
        } elseif ($midtransStatus == 'pending') {
            // Menunggu pembayaran (untuk metode yang butuh waktu seperti VA)
            $transaction->update(['status' => 'pending']);
        } elseif (in_array($midtransStatus, ['deny', 'expire', 'cancel'])) {
            // Pembayaran gagal/kadaluarsa
            $transaction->update(['status' => 'failed']);
        }
        
        // 6. Return response ke Midtrans (WAJIB)
        return response()->json(['message' => 'Notification received successfully']);
    }
    
    /**
     * Proses transaksi sukses: kurangi stok & kirim email
     */
    private function processSuccess(Transaction $transaction)
    {
        $event = $transaction->event;
        
        // Cek apakah event masih ada dan stok masih tersedia
        if ($event && $event->stock > 0) {
            // Kurangi stok event
            $event->stock = $event->stock - 1;
            $event->save();
            
            // Kirim email E-Ticket ke customer
            try {
                \Illuminate\Support\Facades\Mail::to($transaction->customer_email)
                    ->send(new \App\Mail\EventTicketMail($transaction));
                    
                \Log::info('E-Ticket email sent to: ' . $transaction->customer_email);
            } catch (\Exception $e) {
                // Log error jika email gagal dikirim
                \Log::error('Gagal mengirim email E-Ticket: ' . $e->getMessage());
            }
        } else {
            // Log warning jika stok habis (race condition)
            \Log::warning('Stock habis setelah pembayaran berhasil (Perlu proses refund). Order: ' . $transaction->order_id);
        }
    }
}