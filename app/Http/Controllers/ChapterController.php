<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Post;

class ChapterController extends Controller
{
    public function index(){
        $posts = Post::with(['user', 'cover'])
            ->where('jenis_post', 'long')
            ->orderBy('created_at', 'desc')
            ->get();

        $trends = [
            "Kalau aku jujur, kamu masih mau dengar?",
            "Capek pura-pura baik-baik aja"
        ];

        return view('user.chapter.index', compact('posts','trends'));
    }

    public function show($id_post)
    {
        // Ambil post
        $post = Post::with('chapters')->findOrFail($id_post);

        // Ambil chapters per post
        $chapters = Chapter::where('id_post', $id_post)->get();

        return view('user.chapter.show', compact('post', 'chapters'));
    }

    public function create($id_post)
    {
        $post = Post::findOrFail($id_post);
        return view('user.chapter.create', compact('post'));
    }

    public function store(Request $request, $id_post)
    {
        $request->validate([
            'judul_chapter' => 'required|string|max:255',
            'isi_chapter' => 'required',
            'link_musik' => 'nullable|string',
        ]);

        Chapter::create([
            'id_post' => $id_post,
            'judul_chapter' => $request->judul_chapter,
            'isi_chapter' => $request->isi_chapter,
            'link_musik' => $request->link_musik,
        ]);

        return redirect()->route('chapter.show', $id_post)
                        ->with('success', 'Chapter berhasil ditambahkan!');
    }

}
