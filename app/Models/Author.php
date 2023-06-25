<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'avatar',
    ];

    protected $hidden = [
        'password',
    ];

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }
}
