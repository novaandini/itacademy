<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryNews extends Model
{
    use HasFactory;
    protected $guarded = '';

    public function news(): HasMany {
        return $this->hasMany(News::class);
    }
}
