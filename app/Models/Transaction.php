<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model; 

class Transaction extends Model 
{
    use HasFactory; // Menggunakan trait HasFactory

    protected $fillable = [ // Kolom yang dapat diisi secara massal
        'id',
        'user_id',
        'amount',
        'status',
    ];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class); // Mengindikasikan bahwa transaksi ini dimiliki oleh seorang user
    }

    // Relasi ke model TransactionItem
    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class); // Mengindikasikan bahwa transaksi ini dapat memiliki banyak item transaksi
    }
}
