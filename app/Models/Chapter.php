<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $table = 'chapters';
    protected $primaryKey = 'id_chapter';
    public $timestamps = true;

    protected $fillable = [
        'id_post',
        'judul_chapter',
        'isi_chapter',
        'link_musik',
        'scheduled_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    // Relasi ke Post
    public function post()
    {
        return $this->belongsTo(Post::class, 'id_post', 'id_post');
    }

    // =============== ACCESS LOGIC ===============
    public function canEdit($userId)
    {
        return $this->post->canAddChapter($userId);
    }

    // =============== SCOPES =====================
    public function scopePublished($query)
    {
        return $query->whereNull('scheduled_at')
                     ->orWhere('scheduled_at', '<=', now());
    }

    public function scopeScheduled($query)
    {
        return $query->whereNotNull('scheduled_at')
                     ->where('scheduled_at', '>', now());
    }
}
