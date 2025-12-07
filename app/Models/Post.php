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

    /** ===================== RELATIONS ===================== */

    // Pemilik post
    public function user() {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Kolaborasi
    public function collabs()
    {
        return $this->hasMany(PostCollab::class, 'id_post', 'id_post');
    }

    // User yang terlibat kolaborasi (pemilik & partner)
    public function collaborators()
    {
        return $this->collabs()
            ->with(['user1', 'user2'])
            ->get()
            ->map(function ($c) {
                return [$c->user1, $c->user2];
            })
            ->flatten();
    }

    // Cover
    public function cover()
    {
        return $this->hasOne(PostCover::class, 'id_post', 'id_post');
    }

    // Chapters
    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'id_post', 'id_post');
    }

    // Comments
    public function comments(){
        return $this->hasMany(PostComment::class, 'id_post', 'id_post')->latest();
    }

    // Likes
    public function likes(){
        return $this->hasMany(PostLike::class, 'id_post', 'id_post');
    }

    // Cek apakah user telah like
    public function likedBy($userId) {
        return $this->likes()->where('id_user', $userId)->exists();
    }

    /** ===================== LOGIC ACCESS ===================== */

    // Cek hak akses untuk menambahkan chapter
    public function canAddChapter($userId)
    {
        // Pemilik post
        if ($this->id_user == $userId) return true;

        // Kolaborator
        return $this->collabs()
            ->where(function ($query) use ($userId) {
                $query->where('id_user1', $userId)
                      ->orWhere('id_user2', $userId);
            })
            ->exists();
    }
}
