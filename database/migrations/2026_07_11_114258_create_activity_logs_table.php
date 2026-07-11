<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('transaction_id')->constrained()->cascadeOnDelete();
            $table->string('action'); // 'admin_override', 'payment_success', 'reservation_expired', 'order_cancelled'
            $table->string('old_status')->nullable();
            $table->string('new_status');
            $table->text('reason')->nullable(); // Alasan perubahan (wajib untuk admin override)
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->json('metadata')->nullable(); // Data tambahan (payload Midtrans, dll)
            $table->timestamps();
            
            // Index untuk query yang cepat
            $table->index('transaction_id');
            $table->index('action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};