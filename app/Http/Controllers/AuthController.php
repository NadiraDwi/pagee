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
    public function register(Request $request) {
        $request->validate([
            'nama' => 'required|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password), // hash password
        ]);

        auth()->login($user); // login otomatis setelah register
        return redirect('/home'); // redirect ke halaman utama
    }

    // Tampilkan halaman login
    public function showLogin() {
        return view('login'); // resources/views/login.blade.php
    }

    // Handle proses login
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/home'); // login sukses
        }

        // login gagal
        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }

    // Logout user
    public function logout(Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
