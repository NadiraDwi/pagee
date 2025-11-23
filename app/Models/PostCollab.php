<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCollab extends Model
{
    use HasFactory;

    protected $table = 'post_collabs';
    protected $primaryKey = 'id_collab';

    protected $fillable = [
        'id_post',
        'id_user1',
        'id_user2'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'id_post', 'id_post');
    }

    public function user1()
    {
        return $this->belongsTo(User::class, 'id_user1', 'id_user');
    }

    public function user2()
    {
        return $this->belongsTo(User::class, 'id_user2', 'id_user');
    }
}
