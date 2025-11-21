<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;

class AdminController extends Controller
{
    /**
     * Dashboard Admin
     */
    public function index()
    {
        return view('admin.dashboard');
    }
}
