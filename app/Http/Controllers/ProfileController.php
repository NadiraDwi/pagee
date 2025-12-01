<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show(Request $request){
   
        $user = Auth::user();              // user yang sedang login
        $tab = $request->query('tab', 'posts');

        // --- siapkan variabel default supaya blade gak error ---
        $posts = collect();
        $chapters = collect();
        $whispers = collect();
        $capsules = collect();
        $likes = collect();

        // === TAB POSTS (gabungan own + collab) ===
        if ($tab === 'posts') {
            $ownPosts = Post::where('id_user', $user->id_user);
            $collabPosts = Post::whereHas('collabs', function ($q) use ($user) {
                $q->where('id_user1', $user->id_user)
                ->orWhere('id_user2', $user->id_user);
            });

            $posts = $ownPosts->get()
                        ->merge($collabPosts->get())
                        ->sortByDesc('created_at')
                        ->values();

            // eager load relasi user jika ada
            if ($posts->isNotEmpty()) {
                $posts->load('user');
            }
        }

        // === TAB WHISPER ===
        if ($tab === 'whisper') {
            $whispers = Post::where('id_user', $user->id_user)
                            ->where('is_anonymous', 1)
                            ->latest()
                            ->get();
        }

        // === TAB CHAPTER ===
        if ($tab === 'chapter') {
            // contoh: chapter disimpan di posts dengan jenis_post = 'long'
            $chapters = Post::with('cover')
                            ->where('id_user', $user->id_user)
                            ->where('jenis_post', 'long')
                            ->latest()
                            ->get();
        }

        // === TAB TIMECAPSULE ===
        if ($tab === 'timecapsule') {
            $capsules = Post::where('id_user', $user->id_user)
                            ->whereNotNull('scheduled_at')
                            ->latest()
                            ->get();
        }

        // === TAB LIKES ===
        if ($tab === 'likes') {
            // asumsi relasi likes() di model User yang mengembalikan model Like
            // dan table likes punya kolom id_post
            if (method_exists($user, 'likes')) {
                $likedIds = $user->likes()->pluck('id_post')->toArray();
                if (!empty($likedIds)) {
                    $likes = Post::whereIn('id_post', $likedIds)->latest()->get();
                }
            }
        }

        // Kembalikan view SEKALI dengan semua variabel (supaya blade aman)
        return view('user.profile', compact(
            'user', 'tab', 'posts', 'chapters', 'whispers', 'capsules', 'likes'
        ));
    }

    public function edit()
    {
        return view('user.edit', ['user' => auth()->user()]);
    }
    
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nama' => 'required|max:50',
            'username' => 'required|alpha_num|max:30|unique:users,username,' . $user->id_user . ',id_user',
            'bio' => 'nullable|max:200',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'header' => 'nullable|image|mimes:jpg,png,jpeg|max:4096',
        ]);

        // Update data text
        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->bio = $request->bio;

        // FOTO PROFIL
        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }
            $user->foto = $request->file('foto')->store('profile', 'public');
        }

        // HEADER
        if ($request->hasFile('header')) {
            if ($user->header && Storage::disk('public')->exists($user->header)) {
                Storage::disk('public')->delete($user->header);
            }
            $user->header = $request->file('header')->store('profile/header', 'public');
        }

        $user->save();

        return redirect('/profile')->with('success', 'Profil berhasil diperbarui.');
    }

    // AJAX Username Checker
    public function checkUsername(Request $request)
    {
        $exists = \App\Models\User::where('username', $request->username)
            ->where('id_user', '!=', auth()->user()->id_user)
            ->exists();

        return response()->json([
            'available' => !$exists
        ]);
    }
}
