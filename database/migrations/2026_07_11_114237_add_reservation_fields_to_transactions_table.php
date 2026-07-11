<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Builder;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Tambah kolom untuk menyimpan waktu expired reservation
            $table->timestamp('reserved_until')->nullable()->after('status');
            
            // Ubah kolom status menjadi string (lebih fleksibel daripada enum)
            // dan tambahkan status baru: reserved, expired, cancelled
            $table->string('status')->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('reserved_until');
            // Kembalikan ke enum asli (sesuaikan dengan struktur awal kamu)
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending')->change();
        });
    }
};