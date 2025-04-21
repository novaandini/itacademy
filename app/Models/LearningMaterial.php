<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;

class LearningMaterial extends Model 
{
    use HasFactory; // Menggunakan trait HasFactory
    
    protected $guarded = [];

    // Relasi ke model Course
    public function course()
    {
        return $this->belongsTo(Course::class); // Mengindikasikan bahwa learning material ini dimiliki oleh suatu kursus
    }
}
