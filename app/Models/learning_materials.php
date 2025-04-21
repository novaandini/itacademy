<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class learning_materials extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'file_path',
    ];

    // Relasi dengan model Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
