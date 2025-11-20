<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    // Kalau kolomnya berbeda, bisa tambahkan fillable
    protected $fillable = ['title', 'content', 'user_id'];
}
