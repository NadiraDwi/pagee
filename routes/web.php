<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

//Route::get('/login', function () {
    //return view('login');
//});

//Route::get('/register', function () {
    //return view('register');
//});

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;


// Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

Route::post('/posts', [PostController::class, 'store'])->name('posts.store')->middleware('auth');

// Halaman form long post
Route::get('/long-post/create', [PostController::class, 'createLong'])
    ->name('post-long-create')
    ->middleware('auth');

Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show')->middleware('auth');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');

Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');

