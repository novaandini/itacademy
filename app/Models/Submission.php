<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model; 

class Submission extends Model 
{
    use HasFactory; // Menggunakan trait HasFactory

    protected $fillable = [ // Kolom yang dapat diisi secara massal
        'assignment_id',
        'user_id',
        'answer_text',
        'answer_file',
        'status',
        'grade',
    ];

    // Relasi ke model Assignment
    public function assignment()
    {
        return $this->belongsTo(Assignment::class); // Mengindikasikan bahwa submission ini dimiliki oleh suatu assignment
    }

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class); // Mengindikasikan bahwa submission ini dibuat oleh seorang user
    }
}
