<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostCollab;

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
        $trends = [
            "Kalau aku jujur, kamu masih mau dengar?",
            "Capek pura-pura baik-baik aja"
        ];
        $users = \App\Models\User::all();
        return view('user.post-long-create', compact('trends', 'users'));
    }

    public function createShort(){
        $trends = [
            "Life update",
            "Mood hari ini",
            "Curhat random",
            "Overthinking",
        ];
        $users = \App\Models\User::all();
        return view('user.post-short-create', compact('trends', 'users'));
    }

}
