<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Post;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ChapterController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'cover'])
            ->where('jenis_post', 'long')
            ->orderBy('created_at', 'desc')
            ->get();

        $trends = Post::where('is_anonymous', 1)
                      ->latest()
                      ->take(5)
                      ->pluck('isi')
                      ->map(fn($isi) => Str::limit($isi, 30, '...'));

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

        $trends = Post::where('is_anonymous', 1)
                      ->latest()
                      ->take(5)
                      ->pluck('isi')
                      ->map(fn($isi) => Str::limit($isi, 30, '...'));

        return view('user.chapter.show', compact(
            'post', 'chapters', 'isOwner', 'isCollaborator', 'users', 'trends'
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

        $trends = Post::where('is_anonymous', 1)
                      ->latest()
                      ->take(5)
                      ->pluck('isi')
                      ->map(fn($isi) => Str::limit($isi, 30, '...'));

        return view('user.chapter.create', compact('post', 'trends'));
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

        $trends = Post::where('is_anonymous', 1)
                      ->latest()
                      ->take(5)
                      ->pluck('isi')
                      ->map(fn($isi) => Str::limit($isi, 30, '...'));

        return view('user.chapter.read', compact(
            'post', 'chapter', 'prev', 'next', 'isOwner', 'isCollaborator', 'trends'
        ));
    }

    public function edit($id_post, $id_chapter)
    {
        $chapter = Chapter::with('post')->findOrFail($id_chapter);
        $post = $chapter->post;

        $authId = auth()->id();
        $isOwner = $authId === $post->id_user;
        $isCollaborator = $post->collabs()->where('id_user2', $authId)->exists();

        if (!($isOwner || $isCollaborator)) {
            abort(403, 'Tidak memiliki akses mengedit chapter.');
        }

        $trends = Post::where('is_anonymous', 1)
                      ->latest()
                      ->take(5)
                      ->pluck('isi')
                      ->map(fn($isi) => Str::limit($isi, 30, '...'));

        return view('user.chapter.edit', compact('chapter', 'post', 'isOwner', 'isCollaborator', 'trends'));
    }

    public function update(Request $request, $id_post, $id_chapter)
    {
        $chapter = Chapter::findOrFail($id_chapter);

        $authId = auth()->id();
        $isOwner = $authId === $chapter->post->id_user;
        $isCollaborator = $chapter->post->collabs()->where('id_user2', $authId)->exists();

        if (!($isOwner || $isCollaborator)) {
            abort(403, 'Tidak memiliki izin mengupdate chapter.');
        }

        $request->validate([
            'judul_chapter' => 'required|string|max:255',
            'isi_chapter'   => 'required',
            'link_musik'    => 'nullable|string',
            'scheduled_at'  => 'nullable|date|after:now',
        ]);

        $chapter->update($request->only('judul_chapter', 'isi_chapter', 'link_musik', 'scheduled_at'));

        $trends = Post::where('is_anonymous', 1)
                      ->latest()
                      ->take(5)
                      ->pluck('isi')
                      ->map(fn($isi) => Str::limit($isi, 30, '...'));

        return redirect()->route('chapter.read', [$chapter->id_post, $chapter->id_chapter, $trends])
                        ->with('success', 'Chapter berhasil diperbarui!');
    }

    public function destroy( $id_post, $id_chapter)
    {
        $chapter = Chapter::findOrFail($id_chapter);

        $authId = auth()->id();
        $isOwner = $authId === $chapter->post->id_user;
        $isCollaborator = $chapter->post->collabs()->where('id_user2', $authId)->exists();

        if (!($isOwner || $isCollaborator)) {
            abort(403, 'Tidak memiliki izin menghapus chapter.');
        }

        $chapter->delete();

        return redirect()->route('chapter.show', $id_post)
                         ->with('success', 'Chapter berhasil ditambahkan!');
    }

    public function delete($id_post)
    {
        $post = Post::findOrFail($id_post);

        // Hapus semua yang terkait lewat event deleting di model
        $post->delete();

        $posts = Post::with(['user', 'cover'])
            ->where('jenis_post', 'long')
            ->orderBy('created_at', 'desc')
            ->get();

        $trends = Post::where('is_anonymous', 1)
                      ->latest()
                      ->take(5)
                      ->pluck('isi')
                      ->map(fn($isi) => Str::limit($isi, 30, '...'));

        return redirect()->route('chapter');
    }

}
