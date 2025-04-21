<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class TransactionItem extends Model 
{
    use HasFactory; // Menggunakan trait HasFactory

    protected $fillable = [ // Kolom yang dapat diisi secara massal
        'transaction_id',
        'course_id',
        'price',
        'quantity',
    ];

    // Relasi ke model Transaction
    public function transaction()
    {
        return $this->belongsTo(Transaction::class); // Mengindikasikan bahwa item transaksi ini dimiliki oleh sebuah transaksi
    }

    // Relasi ke model Course
    public function course()
    {
        return $this->belongsTo(Course::class); // Mengindikasikan bahwa item transaksi ini terkait dengan sebuah kursus
    }
}
