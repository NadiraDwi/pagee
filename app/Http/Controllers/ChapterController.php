<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Post;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ChapterController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'cover'])
            ->where('jenis_post', 'long')
            ->orderBy('created_at', 'desc')
            ->get();

        $trends = [
            "Kalau aku jujur, kamu masih mau dengar?",
            "Capek pura-pura baik-baik aja"
        ];

        return view('user.chapter.index', compact('posts', 'trends'));
    }

    public function show($id_post)
    {
        $post = Post::with(['chapters', 'collabs'])->findOrFail($id_post);
        $authId = auth()->id();

        $isOwner = $authId === $post->id_user;
        $isCollaborator = $post->collabs()->where('id_user2', $authId)->exists();

        // Ambil chapter
        $chapters = ($isOwner || $isCollaborator)
            ? $post->chapters()->orderBy('created_at', 'asc')->get()
            : $post->chapters()->where(function($q) {
                $q->whereNull('scheduled_at')
                  ->orWhere('scheduled_at', '<=', now());
              })->orderBy('created_at', 'asc')->get();

        $users = ($isOwner || $isCollaborator) ? \App\Models\User::all() : collect();

        return view('user.chapter.show', compact(
            'post', 'chapters', 'isOwner', 'isCollaborator', 'users'
        ));
    }

    public function create($id_post)
    {
        $post = Post::findOrFail($id_post);

        $authId = auth()->id();
        $isOwner = $authId === $post->id_user;
        $isCollaborator = $post->collabs()->where('id_user2', $authId)->exists();

        if (!($isOwner || $isCollaborator)) {
            abort(403, 'Tidak memiliki akses menambahkan chapter.');
        }

        return view('user.chapter.create', compact('post'));
    }

    public function store(Request $request, $id_post)
    {
        $request->validate([
            'judul_chapter' => 'required|string|max:255',
            'isi_chapter'   => 'required',
            'link_musik'    => 'nullable|string',
            'scheduled_at'  => 'nullable|date|after:now',
        ]);

        Chapter::create([
            'id_post'       => $id_post,
            'judul_chapter' => $request->judul_chapter,
            'isi_chapter'   => $request->isi_chapter,
            'link_musik'    => $request->link_musik,
            'scheduled_at'  => $request->scheduled_at,
        ]);

        return redirect()->route('chapter.show', $id_post)
                         ->with('success', 'Chapter berhasil ditambahkan!');
    }

    public function read($id_post, $id_chapter)
    {
        $post = Post::with('collabs')->findOrFail($id_post);
        $chapter = Chapter::where('id_post', $id_post)
            ->where('id_chapter', $id_chapter)
            ->firstOrFail();

        $authId = auth()->id();
        $isOwner = $authId === $post->id_user;
        $isCollaborator = $post->collabs()->where('id_user2', $authId)->exists();

        // Proteksi chapter yang belum rilis untuk user biasa
        if (!($isOwner || $isCollaborator) && $chapter->scheduled_at?->isFuture()) {
            abort(403, 'Chapter ini belum rilis.');
        }

        // NEXT & PREV
        $prev = Chapter::where('id_post', $id_post)
            ->where('id_chapter', '<', $id_chapter)
            ->orderBy('id_chapter', 'desc')
            ->first();

        $next = Chapter::where('id_post', $id_post)
            ->where('id_chapter', '>', $id_chapter)
            ->orderBy('id_chapter', 'asc')
            ->first();

        return view('user.chapter.read', compact('post', 'chapter', 'prev', 'next'));
    }
}
