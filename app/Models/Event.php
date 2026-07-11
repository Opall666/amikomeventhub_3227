<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'date',
        'location',
        'price',
        'stock',
        'poster_path',
    ];

    protected $casts = [
        'date' => 'datetime',
        'price' => 'integer',
        'stock' => 'integer',
    ];

    // Relasi: 1 Event belongs to 1 Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: 1 Event memiliki BANYAK Transaction
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}