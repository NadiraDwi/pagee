<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ADMIN AREA
Route::middleware('admin')->group(function () {
    Route::get('/admin/home', [AdminController::class, 'index'])->name('admin.index');
});

// USER AREA
Route::middleware('user')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/short-post/create', [PostController::class, 'createShort'])
    ->name('post-short-create');


    // Halaman form long post
    Route::get('/long-post/create', [PostController::class, 'createLong'])
        ->name('post-long-create')        ;
    Route::post('/chapters', [ChapterController::class, 'store'])->name('chapters.store');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

