<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostLike extends Model
{
    protected $table = 'post_likes';
    protected $primaryKey = 'id_like';
    protected $fillable = [
        'id_post',
        'id_user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'id_post', 'id_post');
    }
}
