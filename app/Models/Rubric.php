<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Rubric extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'pid',
    ];

    public function news(): BelongsToMany
    {
        return $this->belongsToMany(News::class);
    }
}
