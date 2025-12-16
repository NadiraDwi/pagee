<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Tampilkan halaman register
    public function showRegister() {
        return view('register'); // resources/views/register.blade.php
    }

    // Handle proses register
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // default user
        ]);

        auth()->login($user); // Login otomatis

        $request->session()->flash('justLoggedIn', true);

        // 👉 Redirect berdasarkan role
        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home');
        // default user

    }


    // Tampilkan halaman login
    public function showLogin() {
        return view('login'); // resources/views/login.blade.php
    }

    // Handle proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 1. Cek apakah email terdaftar
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar.',
            ])->withInput();
        }

        // 2. Cek password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Password tidak sesuai.',
            ])->withInput();
        }

        // 3. Login manual
        auth()->login($user);
        $request->session()->regenerate();

        // 4. Redirect sesuai role
        if ($user->role === 'admin') {
            return redirect()->route('admin.index');
        }

        if ($user->role === 'user') {
            $request->session()->flash('justLoggedIn', true);
            return redirect()->route('home');
        }

        return redirect('/home');
    }

    // Logout user
    public function logout(Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
