<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $primaryKey = 'id_chapter';

    protected $fillable = [
        'id_post',
        'judul_chapter',
        'isi_chapter',
        'link_musik',
    ];

    // Relasi ke Post
    public function post()
    {
        return $this->belongsTo(Post::class, 'id_post', 'id_post');
    }
}
