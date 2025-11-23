<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostCollab extends Model
{
    protected $table = 'post_collabs';
    protected $primaryKey = 'id_collab';

    protected $fillable = [
        'id_post',
        'id_user1',
        'id_user2'
    ];

    // Relasi ke Post
    public function post()
    {
        return $this->belongsTo(Post::class, 'id_post', 'id_post');
    }

    // User pertama
    public function user1()
    {
        return $this->belongsTo(User::class, 'id_user1', 'id_user');
    }

    // User kedua
    public function user2()
    {
        return $this->belongsTo(User::class, 'id_user2', 'id_user');
    }
}
