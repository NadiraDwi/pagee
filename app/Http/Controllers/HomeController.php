<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index(){
        $posts = Post::with([
            'user',
            'comments.user',
            'chapters' => function ($q) {
                $q->published()
                ->orderBy('created_at', 'desc');
            }
        ])
        ->orderBy('created_at', 'desc')
        ->get();

        $trends = Post::where('is_anonymous', 1)
                      ->latest()
                      ->take(5)
                      ->pluck('isi')
                      ->map(fn($isi) => Str::limit($isi, 30, '...'));

        return view('user.home', compact('posts','trends'));
    }
}
