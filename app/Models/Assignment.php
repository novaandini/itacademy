<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model; 

class Assignment extends Model 
{
    use HasFactory; // Menggunakan trait HasFactory

    // Mendefinisikan kolom yang dapat diisi secara massal
    protected $fillable = ['course_id', 'title', 'description', 'file_path', 'deadline'];

    // Relasi ke model Course
    public function course()
    {
        return $this->belongsTo(Course::class); // Mengindikasikan bahwa assignment milik satu course
    }

    // Relasi ke model Submission
    public function submissions()
    {
        return $this->hasMany(Submission::class); // Mengindikasikan bahwa satu assignment bisa memiliki banyak submission
    }

    // Relasi untuk mengambil satu submission milik pengguna yang sedang login
    public function submission()
    {
        return $this->hasOne(Submission::class, 'assignment_id')->where('user_id', auth()->id()); // Mengindikasikan bahwa hanya mengambil submission yang dibuat oleh pengguna yang sedang login
    }
}
