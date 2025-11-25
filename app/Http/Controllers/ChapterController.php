<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
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

        return view('user.chapter', compact('posts','trends'));
    }
}
