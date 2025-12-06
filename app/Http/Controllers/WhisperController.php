<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;

class WhisperController extends Controller
{
    public function index()
    {
        // Ambil semua post anonim terbaru
        $posts = Post::where('is_anonymous', 1)
                     ->orderBy('created_at', 'desc')
                     ->with(['comments', 'likes', 'user'])
                     ->get();

        // Ambil 5 kata/isi singkat dari post anonim untuk trending
        $trends = Post::where('is_anonymous', 1)
                      ->latest()
                      ->take(5)
                      ->pluck('isi') // ambil isi post
                      ->map(fn($isi) => Str::limit($isi, 30, '...')); // potong maksimal 30 karakter

        return view('user.whisper', compact('posts', 'trends'));
    }
}
