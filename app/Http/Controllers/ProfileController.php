<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Chapter;

class ProfileController extends Controller
{
    public function show(Request $request){
    $user = Auth::user();

    $tab = $request->query('tab', 'posts');

    // Ambil post sesuai user login, sekaligus eager load user
    $posts = Post::where('id_user', $user->id_user)
                 ->with('user') // supaya data user bisa dipanggil di view
                 ->latest()
                 ->get();

    return view('profile', compact('user', 'tab', 'posts'));
    }
}
