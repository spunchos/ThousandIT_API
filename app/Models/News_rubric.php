<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News_rubric extends Model
{
    use HasFactory;

    protected $table = 'news_rubric';

    protected $fillable = ['rubric_id', 'news_id'];
}
