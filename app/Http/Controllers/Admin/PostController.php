<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Dashboard Admin
     */
    public function index()
    {
        return view('admin.post.index');
    }
}
