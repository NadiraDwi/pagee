<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id_comment';

    protected $fillable = [
        'id_post',
        'id_user',
        'isi_komentar',
        'tanggal'
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
