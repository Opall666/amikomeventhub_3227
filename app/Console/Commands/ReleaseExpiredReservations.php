<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReleaseExpiredReservations extends Command
{
    protected $signature = 'reservations:release-expired';
    protected $description = 'Release stock for expired unpaid reservations';

    public function handle()
    {
        $this->info('🔍 Checking for expired reservations...');
        
        // Cari semua transaksi reserved yang sudah expired
        $expiredReservations = Transaction::where('status', 'reserved')
            ->where('reserved_until', '<', now())
            ->with('event')
            ->get();

        if ($expiredReservations->isEmpty()) {
            $this->info('✅ No expired reservations found.');
            return 0;
        }

        $this->info('📦 Found ' . $expiredReservations->count() . ' expired reservations.');

        $released = 0;
        
        foreach ($expiredReservations as $reservation) {
            try {
                DB::transaction(function () use ($reservation) {
                    // Update status ke expired
                    $reservation->update(['status' => 'expired']);
                    
                    // Kembalikan stok ke event
                    if ($reservation->event) {
                        $reservation->event->increment('stock');
                        
                        Log::info('Stok dikembalikan untuk reservation expired: ' . $reservation->order_id);
                    }
                    
                    // Catat di activity log
                    \App\Models\ActivityLog::create([
                        'transaction_id' => $reservation->id,
                        'action' => 'reservation_expired_auto',
                        'old_status' => 'reserved',
                        'new_status' => 'expired',
                        'reason' => 'Payment timeout (15 minutes)',
                    ]);
                });
                
                $released++;
                $this->line("✅ Released: {$reservation->order_id}");
                
            } catch (\Exception $e) {
                $this->error("❌ Failed to release {$reservation->order_id}: " . $e->getMessage());
                Log::error('Failed to release reservation: ' . $reservation->order_id . ' - ' . $e->getMessage());
            }
        }

        $this->info("🎉 Successfully released {$released} expired reservations.");
        
        return 0;
    }
}