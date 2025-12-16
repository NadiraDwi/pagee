<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostCollab;
use App\Models\PostCover;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Simpan short atau long post ke database
     */
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'isi' => 'required',
            'jenis_post' => 'required|in:short,long',
            'judul' => 'nullable|string|max:255',
            'is_anonymous' => 'nullable|boolean',
            'mentions' => 'nullable' // JSON array
        ]);

        // Long post wajib judul
        if ($request->jenis_post === 'long' && empty($request->judul)) {
            return back()->withErrors(['judul' => 'Judul wajib untuk long post'])->withInput();
        }

        // 1️⃣ Buat postingan dulu
        $post = Post::create([
            'id_user' => auth()->user()->id_user,
            'judul' => $request->judul,
            'isi' => $request->isi,
            'jenis_post' => $request->jenis_post,
            'tanggal_dibuat' => now(),
            'is_anonymous' => $request->has('is_anonymous'),
        ]);

        // 2️⃣ Proses collab
        if ($request->filled('mentions')) {

            // Decode JSON → array ID user
            $mentionIds = json_decode($request->mentions, true);

            if (is_array($mentionIds)) {
                foreach ($mentionIds as $idUser) {

                    // Simpan ke tabel post_collabs
                    PostCollab::create([
                        'id_post' => $post->id_post,
                        'id_user1' => auth()->user()->id_user, // pembuat post
                        'id_user2' => $idUser, // collab
                    ]);
                }
            }
        }

        // Response AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Post berhasil dibuat!',
                'post' => [
                    'id' => $post->id_post,
                    'judul' => $post->judul,
                    'isi' => $post->isi,
                    'jenis_post' => $post->jenis_post,
                    'user' => $post->is_anonymous ? 'Anonymous' : auth()->user()->nama,
                    'created_at' => $post->tanggal_dibuat->diffForHumans(),
                ]
            ]);
        }

        return redirect()->route('home')->with('success', 'Post berhasil dibuat!');
    }

    /**
     * Tampilkan form long post
     */
    public function createLong()
    {
        $trends = Post::where('is_anonymous', 1)
                      ->latest()
                      ->take(5)
                      ->pluck('isi')
                      ->map(fn($isi) => Str::limit($isi, 30, '...'));

        $users = \App\Models\User::all();
        return view('user.post-long-create', compact('trends', 'users'));
    }

    public function createShort(){
        $trends = Post::where('is_anonymous', 1)
                      ->latest()
                      ->take(5)
                      ->pluck('isi')
                      ->map(fn($isi) => Str::limit($isi, 30, '...'));
                      
        $users = \App\Models\User::all();
        return view('user.post-short-create', compact('trends', 'users'));
    }

    public function storeLong(Request $request)
    {
        // VALIDASI
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'jenis_post' => 'required',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        // SIMPAN POST UTAMA
        $post = Post::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'jenis_post' => $request->jenis_post,
            'id_user' => auth()->user()->id_user
        ]);

        // ==========================
        // SIMPAN COVER BILA ADA
        // ==========================
        if ($request->hasFile('cover')) {

            $coverFile = $request->file('cover');
            $fileName = time() . '_' . $coverFile->getClientOriginalName();

            // simpan ke storage/app/public/covers
            $coverPath = $coverFile->storeAs('covers', $fileName, 'public');

            // simpan ke tabel post_covers
            PostCover::create([
                'id_post' => $post->id_post,
                'cover_path' => $coverPath
            ]);
        }

        // 2️⃣ Proses collab
        if ($request->filled('mentions')) {

            // Decode JSON → array ID user
            $mentionIds = json_decode($request->mentions, true);

            if (is_array($mentionIds)) {
                foreach ($mentionIds as $idUser) {

                    // Simpan ke tabel post_collabs
                    PostCollab::create([
                        'id_post' => $post->id_post,
                        'id_user1' => auth()->user()->id_user, // pembuat post
                        'id_user2' => $idUser, // collab
                    ]);
                }
            }
        }

        return redirect()->route('chapter')->with('success', 'Postingan berhasil dibuat!');
    }

    public function whispers($username)
{
    // cari user berdasarkan username
    $user = User::where('username', $username)->firstOrFail();

    // ambil whisper dari tabel posts
    $whispers = Post::where('id_user', $user->id)
                    ->where('is_anonymous', 1) // ini yang penting
                    ->latest()
                    ->get();

    return view('profile.tabs.whisper', compact('user', 'whispers'));
}

public function comment(Request $request, $id)
{
    $request->validate([
        'comment' => 'required|string|max:500',
    ]);

    Reaction::create([
        'id_post' => $id,
        'id_user' => auth()->id(),
        'jenis_reaksi' => $request->comment,
    ]);

    return back()->with('success', 'Komentar berhasil ditambahkan!');
}

public function like(Request $request)
{
    $post = Post::findOrFail($request->id_post);
    $userId = auth()->id();

    if ($post->likes()->where('id_user', $userId)->exists()) {
        // Unlike
        $post->likes()->where('id_user', $userId)->delete();
        $status = 'unliked';
    } else {
        // Like
        $post->likes()->create(['id_user' => $userId]);
        $status = 'liked';
    }

    return response()->json([
        'status' => $status,
        'count' => $post->likes()->count()
    ]);
}

public function update(Request $request, $id)
{
    $request->validate([
        'isi' => 'required|string',
    ]);

    $post = Post::findOrFail($id);

    $post->isi = $request->isi;
    $post->save();

    return back()->with('success', 'Post berhasil diperbarui!');
}

public function destroy($id)
{
    $post = Post::findOrFail($id);
    $post->delete();

    return back()->with('success', 'Post berhasil dihapus!');
}

public function show($id_post)
{
    $post = Post::with([
        'user',
        'comments.user',
        'chapters' => function ($q) {
            $q->published()
              ->orderBy('created_at', 'desc');
        }
    ])->findOrFail($id_post); // ✅ PENTING

    $trends = Post::where('is_anonymous', 1)
        ->latest()
        ->take(5)
        ->pluck('isi')
        ->map(fn ($isi) => Str::limit($isi, 30, '...'));

    return view('user.post-show', compact('post', 'trends'));
}

}
