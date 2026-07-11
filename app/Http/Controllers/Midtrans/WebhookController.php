<?php

namespace App\Http\Controllers\Midtrans;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
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
            ->with('event')
            ->first();
        
        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }
        
        // 4. IDEMPOTENCY CHECK: Cegah proses ulang
        if (in_array(strtolower($transaction->status), ['success', 'failed', 'expired', 'cancelled'])) {
            Log::info('Webhook diabaikan - transaksi sudah diproses: ' . $transaction->order_id);
            return response()->json(['message' => 'Already processed']);
        }
        
        // 5. Update status transaksi berdasarkan response Midtrans
        $midtransStatus = $notif->transaction_status;
        
        DB::transaction(function () use ($transaction, $midtransStatus, $notif) {
            if (in_array($midtransStatus, ['capture', 'settlement'])) {
                // Pembayaran berhasil
                $transaction->update(['status' => 'success']);
                $this->processSuccess($transaction);
                
            } elseif ($midtransStatus == 'pending') {
                // Menunggu pembayaran
                $transaction->update(['status' => 'pending']);
                
            } elseif (in_array($midtransStatus, ['deny', 'expire', 'cancel', 'failure'])) {
                // Pembayaran gagal/kadaluarsa/dibatalkan
                $transaction->update(['status' => 'failed']);
                
                // PENTING: Kembalikan stok ke event!
                if ($transaction->event) {
                    $transaction->event->increment('stock');
                    Log::info('Stok dikembalikan ke event ' . $transaction->event->id . ' karena pembayaran gagal: ' . $transaction->order_id);
                }
            }
            
            // Catat di activity log
            \App\Models\ActivityLog::create([
                'transaction_id' => $transaction->id,
                'action' => 'webhook_' . $midtransStatus,
                'old_status' => $transaction->getOriginal('status'),
                'new_status' => $transaction->status,
                'metadata' => (array) $notif,
            ]);
        });
        
        // 6. Return response ke Midtrans (WAJIB)
        return response()->json(['message' => 'Notification received successfully']);
    }
    
    /**
     * Proses transaksi sukses: kirim email (stok sudah dikurangi saat checkout)
     */
    private function processSuccess(Transaction $transaction)
    {
        // Kirim email E-Ticket ke customer
        try {
            \Illuminate\Support\Facades\Mail::to($transaction->customer_email)
                ->send(new \App\Mail\EventTicketMail($transaction));
                
            Log::info('E-Ticket email sent to: ' . $transaction->customer_email);
        } catch (\Exception $e) {
            Log::error('Gagal mengirim email E-Ticket: ' . $e->getMessage());
        }
    }
}