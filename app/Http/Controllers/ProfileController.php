<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();
        $tab = $request->query('tab', 'posts');

        // --- 1. Post milik user sendiri ---
        $ownPosts = Post::where('id_user', $user->id_user);

        // --- 2. Post dimana user adalah kolaborator ---
        $collabPosts = Post::whereHas('collabs', function ($q) use ($user) {
            $q->where('id_user1', $user->id_user)
              ->orWhere('id_user2', $user->id_user);
        });

        // --- 3. Gabungkan via collection (tanpa UNION / tanpa error) ---
        $posts = $ownPosts->get()
                    ->merge($collabPosts->get())
                    ->sortByDesc('created_at')
                    ->values(); // reset index biar rapi

        // --- 4. Eager load relasi user untuk setiap post ---
        $posts->load('user');

        return view('user.profile', compact('user', 'tab', 'posts'));
    }
}
