<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Kolom yang boleh diisi mass assignment
    protected $fillable = [
        'user_id',
        'content',
    ];

    // Relasi ke User: setiap post punya 1 user
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
}
