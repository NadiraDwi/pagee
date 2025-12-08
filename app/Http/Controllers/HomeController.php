<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class HomeController extends Controller
{
    public function index(){
        $posts = Post::with([
            'user',
            'comments.user',
            'chapters' => function($q){
                $q->orderBy('created_at', 'desc'); // ambil latest
            }
        ])
        ->orderBy('created_at', 'desc')
        ->get();

        $trends = [
            "Kalau aku jujur, kamu masih mau dengar?",
            "Capek pura-pura baik-baik aja"
        ];

        return view('user.home', compact('posts','trends'));
    }
}
