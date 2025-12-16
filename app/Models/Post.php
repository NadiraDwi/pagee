<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

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

    protected static function booted()
    {
        static::deleting(function ($post) {
            // Hapus cover post
            if ($post->cover) {
                Storage::delete($post->cover->cover_path);
                $post->cover()->delete();
            }

            // Hapus semua chapter + cover chapter
            foreach ($post->chapters as $chapter) {
                if ($chapter->cover) {
                    Storage::delete($chapter->cover->cover_path);
                    $chapter->cover()->delete();
                }
                $chapter->delete();
            }

            // Hapus kolaborasi
            $post->collabs()->delete();

            // Hapus komentar
            $post->comments()->delete();

            // Hapus like
            $post->likes()->delete();
        });
    }

    /** ===================== RELATIONS ===================== */

    public function user() {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function collabs()
    {
        return $this->hasMany(PostCollab::class, 'id_post', 'id_post');
    }

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

    public function cover()
    {
        return $this->hasOne(PostCover::class, 'id_post', 'id_post');
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'id_post', 'id_post');
    }

    public function comments(){
        return $this->hasMany(PostComment::class, 'id_post', 'id_post')->latest();
    }

    public function likes(){
        return $this->hasMany(PostLike::class, 'id_post', 'id_post');
    }

    public function likedBy($userId) {
        return $this->likes()->where('id_user', $userId)->exists();
    }

    public function canAddChapter($userId)
    {
        if ($this->id_user == $userId) return true;

        return $this->collabs()
            ->where(function ($query) use ($userId) {
                $query->where('id_user1', $userId)
                      ->orWhere('id_user2', $userId);
            })
            ->exists();
    }
}
