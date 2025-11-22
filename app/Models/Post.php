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

}
