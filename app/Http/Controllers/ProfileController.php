<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

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
