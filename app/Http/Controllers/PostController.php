<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function store(Request $request){
    // Validasi input minimal
    $request->validate([
        'isi' => 'required|max:280',
        'jenis_post' => 'required|in:short,long'
    ]);

    if ($request->jenis_post === 'long') {
        // Redirect ke halaman long post
        return redirect()->route('long-post.create');
    }

    // Kalau short post → simpan
    Post::create([
        'id_user' => auth()->user()->id_user,
        'isi' => $request->isi,
        'jenis_post' => $request->jenis_post,
    ]);

    // Kalau request via AJAX (popup), kembalikan response JSON
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Post berhasil dibuat!',
            'post' => [
                'isi' => $request->isi,
                'user' => auth()->user()->name
            ]
        ]);
    }

    // Kalau submit biasa, redirect ke home
    return redirect()->route('home')->with('success', 'Post berhasil dibuat!');
    }

    public function createLong(){
    // Tampilkan form untuk long post
    return view('posts.create-long'); 
    }

}
