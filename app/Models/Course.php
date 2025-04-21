<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory; // Menggunakan trait HasFactory
    use HasUuids;

    protected $table = 'courses'; // Mendefinisikan nama tabel yang digunakan

    protected $guarded = [];

    // Relasi ke model LearningMaterial
    public function learningMaterials()
    {
        return $this->hasMany(LearningMaterial::class); // Mengindikasikan bahwa satu course bisa memiliki banyak learning materials
    }

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke model Certification
    public function certifications()
    {
        return $this->hasMany(Certification::class); // Mengindikasikan bahwa satu course bisa memiliki banyak certifications
    }

    // Relasi ke model Student
    // public function students()
    // {
    //     return $this->hasMany(StudentCourse::class); // Mengindikasikan bahwa satu course bisa memiliki banyak students
    // }

    public function students()
    {
        return $this->hasManyThrough(User::class, StudentCourse::class, 'course_id', 'id', 'id', 'user_id');
    }

    // Relasi ke model Transaction
    public function transactions()
    {
        return $this->hasMany(Transaction::class); // Mengindikasikan bahwa satu course bisa memiliki banyak transactions
    }

    // Relasi ke model TransactionItem
    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class); // Mengindikasikan bahwa satu course bisa memiliki banyak transaction items
    }
}
