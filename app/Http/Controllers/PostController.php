<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    // Simpan post baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'content' => 'required|max:280', // maksimal 280 karakter
        ]);

        // Simpan ke database
        Post::create([
            'user_id' => auth()->user()->id_user, // ambil id_user dari user login
            'content' => $request->content,
        ]);

        return redirect()->back(); // kembali ke halaman sebelumnya
    }
}
