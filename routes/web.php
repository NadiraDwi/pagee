<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserPublicProfileController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostCollabController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/user/{id}', [UserPublicProfileController::class, 'show'])
    ->name('user.profile');

Route::get('/post/{id_post}/chapter/{id_chapter}', [ChapterController::class, 'read'])
    ->name('chapter.read');

// ADMIN AREA
Route::middleware('admin')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::get('/list', [AdminUserController::class, 'list'])->name('list');
        Route::delete('/delete/{id}', [AdminUserController::class, 'delete'])->name('delete');
    });

    Route::prefix('post')->name('post.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
    });
});

// USER AREA
Route::middleware('user')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/short-post/create', [PostController::class, 'createShort'])
    ->name('post-short-create');
    Route::post('/comment/store', [\App\Http\Controllers\CommentController::class, 'store'])
    ->name('comment.store');

    Route::get('/whisper', [App\Http\Controllers\WhisperController::class, 'index'])->name('whisper.index');

    // routes/web.php
    Route::post('/collab/add', [PostCollabController::class, 'store'])->name('collab.add');
    Route::post('/collab/remove', [PostCollabController::class, 'remove'])->name('collab.remove');

Route::middleware('auth')->post('/post/like', [LikeController::class, 'toggle'])->name('post.like');
Route::post('/post/like', [PostController::class, 'like'])->name('post.like')->middleware('user');




    // Halaman form long post
    Route::get('/long-post/create', [PostController::class, 'createLong'])
        ->name('post-long-create');
    Route::post('/posts-long', [PostController::class, 'storeLong'])->name('posts.store.long');
    Route::get('/chapter', [ChapterController::class, 'index'])->name('chapter');
    Route::get('/chapter/{id}', [ChapterController::class, 'show'])->name('chapter.show');

    Route::get('/chapter/{id_post}', [ChapterController::class, 'show'])->name('chapter.show');
    // tambahkan semua route Chapter
    Route::get('/chapter/{id_post}/create', [ChapterController::class, 'create'])->name('chapter.create');
    Route::post('/chapter/{id_post}', [ChapterController::class, 'store'])->name('chapter.store');
    Route::get('/chapter/{id}/show', [ChapterController::class, 'show'])->name('chapter.show');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/check-username', [ProfileController::class, 'checkUsername'])->name('profile.checkUsername');
});

