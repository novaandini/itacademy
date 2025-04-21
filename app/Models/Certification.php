<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'course_id',
        'certificate_number',
        'title',
        'description',
        'image',
        'date'
    ];
    protected $casts = [
        'date' => 'date', // Automatically cast the date to Carbon
    ];
    /**
     * Get the user that owns the certification.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the course that is associated with the certification.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function students()
{
    return $this->belongsToMany(User::class, 'student_certifications')->withTimestamps();
}

}