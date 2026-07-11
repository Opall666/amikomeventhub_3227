<?php

namespace App\Jobs;

use App\Models\Transaction;
use App\Mail\EventTicketMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEticketJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $transaction;

    /**
     * Create a new job instance.
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Execute the job (Kirim Email di sini).
     */
    public function handle(): void
    {
        try {
            Mail::to($this->transaction->customer_email)
                ->send(new EventTicketMail($this->transaction));
                
            Log::info('E-Ticket email sent via Queue to: ' . $this->transaction->customer_email);
        } catch (\Exception $e) {
            Log::error('Gagal mengirim email E-Ticket via Queue: ' . $e->getMessage());
            
            // Jika gagal, job akan otomatis di-retry oleh Laravel (max 3x)
            $this->fail($e);
        }
    }
}