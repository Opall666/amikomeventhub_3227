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
}