<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostCover extends Model
{
    protected $table = 'post_covers';
    protected $primaryKey = 'id_cover';

    protected $fillable = [
        'id_post',
        'cover_path'
    ];

    public function post()
    {
        return $this->hasOne(Post::class, 'id_post', 'id_post');
    }
}
