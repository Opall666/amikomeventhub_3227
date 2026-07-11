<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',      
        'event_id',
        'order_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'total_price',
        'status',
        'snap_token',
        'reserved_until',
    ];
    protected $casts = [
    'reserved_until' => 'datetime', // ← TAMBAHKAN INI
    ];

    // Relasi: Transaction belongs to satu event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

        // TAMBAHKAN INI ↓
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
    * Relasi ke Activity Logs (riwayat perubahan status)
    */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Scope: Transaksi yang masih dalam masa reservation
     */
    public function scopeReserved($query)
    {
        return $query->where('status', 'reserved')
                    ->where('reserved_until', '>', now());
    }

    /**
     * Scope: Transaksi yang sudah expired (belum bayar lewat 15 menit)
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'reserved')
                    ->where('reserved_until', '<=', now());
    }

    /**
     * Cek apakah transaksi masih dalam masa reservation
     */
    public function isReserved(): bool
    {
        return $this->status === 'reserved' 
            && $this->reserved_until 
            && $this->reserved_until->isFuture();
    }

    /**
     * Cek apakah transaksi sudah expired
     */
    public function isExpired(): bool
    {
        return $this->status === 'reserved' 
            && $this->reserved_until 
            && $this->reserved_until->isPast();
    }
}