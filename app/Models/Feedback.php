<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model; 

class Feedback extends Model
{
    use HasFactory; // Menggunakan trait HasFactory

    protected $fillable = ['user_id', 'admin_id', 'comments', 'rating']; // Kolom yang dapat diisi secara massal

    // Relasi ke model User untuk user yang memberikan feedback
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Mengindikasikan bahwa feedback ini dimiliki oleh seorang pengguna
    }

    // Relasi ke model User untuk admin yang memberikan feedback
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id'); // Mengindikasikan bahwa feedback ini diberikan oleh seorang admin
    }
}
