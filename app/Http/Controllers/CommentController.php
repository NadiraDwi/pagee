<?php

namespace App\Http\Controllers;

use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_post' => 'required|integer',
            'isi_komentar' => 'required|string',
        ]);

        $comment = PostComment::create([
            'id_post' => $request->id_post,
            'id_user' => Auth::id(),
            'isi_komentar' => $request->isi_komentar,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil ditambahkan',
            'data' => $comment
        ]);
    }
}
