<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $primaryKey = 'id_post';
    protected $fillable = [
        'id_user',
        'judul',
        'isi',
        'jenis_post',
        'tanggal_dibuat',
        'is_anonymous'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function collaborations()
    {
        return $this->hasMany(PostCollab::class, 'id_post', 'id_post');
    }

    // User yang berkolaborasi
    public function collaborators()
    {
        return $this->collaborations->map(function($c){
            return [$c->user1, $c->user2];
        })->flatten();
    }

}
