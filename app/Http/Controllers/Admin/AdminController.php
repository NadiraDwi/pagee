<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
class AdminController extends Controller
{
    /**
     * Dashboard Admin
     */
    public function index()
    {
        return view('admin.dashboard');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function updateSettings(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'string|max:255|unique:users,username,'.$user->id_user.',id_user',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id_user.',id_user',
            'bio' => 'nullable|string|max:500',
            'foto' => 'nullable|image|max:2048',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if($request->hasFile('foto')){
            if($user->foto){
                Storage::delete($user->foto);
            }
            $path = $request->file('foto')->store('users');
            $user->foto = $path;
        }

        $user->nama = $validated['nama'];
        $user->username = $validated['username'];
        $user->email = $validated['email'];
        $user->bio = $validated['bio'];

        if(!empty($validated['password'])){
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }

}
