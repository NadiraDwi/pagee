<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Chapter;

class UserPublicProfileController extends Controller
{
    public function show($id)
    {
        // Ambil user berdasarkan ID
        $user = User::findOrFail($id);

        // --- Ambil postingan milik user tersebut ---
        $ownPosts = Post::where('id_user', $user->id_user);

        // --- Post dimana user itu jadi kolaborator ---
        $collabPosts = Post::whereHas('collabs', function ($q) use ($user) {
            $q->where('id_user1', $user->id_user)
              ->orWhere('id_user2', $user->id_user);
        });

        // --- Gabungkan ---
        $posts = $ownPosts->get()
                    ->merge($collabPosts->get())
                    ->sortByDesc('created_at')
                    ->values();

        // Eager load relasi user
        $posts->load('user');

        $ownPostIds = Post::where('id_user', $user->id_user)->pluck('id_post');
        $chapters = Chapter::whereIn('id_post', $ownPostIds)
                    ->latest()
                    ->get();
        return view('user.public-profile', compact('user', 'posts', 'chapters'));
    }
}
