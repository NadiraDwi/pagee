<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Simpan short atau long post ke database
     */
    public function store(Request $request)
    {
        // Validasi dasar
        $request->validate([
            'isi' => 'required',
            'jenis_post' => 'required|in:short,long',
            'judul' => 'nullable|string|max:255',
            'is_anonymous' => 'nullable|boolean'
        ]);

        // Long post wajib punya judul
        if ($request->jenis_post === 'long' && empty($request->judul)) {
            return back()->withErrors(['judul' => 'Judul wajib untuk long post'])->withInput();
        }

        // Simpan post
        $post = Post::create([
            'id_user' => auth()->user()->id_user,
            'judul' => $request->judul, // null untuk short post
            'isi' => $request->isi,
            'jenis_post' => $request->jenis_post,
            'tanggal_dibuat' => now(),
            'is_anonymous' => $request->has('is_anonymous') ? true : false,
        ]);

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
                    'created_at' => $post->tanggal_dibuat->diffForHumans()
                ]
            ]);
        }

        // Redirect biasa
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
