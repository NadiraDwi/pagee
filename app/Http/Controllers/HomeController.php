<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class HomeController extends Controller
{
    public function index(){
    $posts = Post::with('user')->orderBy('created_at', 'desc')->get();
    $trends = [
        "Kalau aku jujur, kamu masih mau dengar?",
        "Capek pura-pura baik-baik aja"
    ];

    return view('home', compact('posts','trends'));
}

}
