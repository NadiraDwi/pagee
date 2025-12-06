<?php

namespace App\Http\Controllers;

use App\Models\PostLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Request $request)
    {
        $postId = $request->id_post;
        $userId = Auth::id();

        $like = PostLike::where('id_post', $postId)
            ->where('id_user', $userId)
            ->first();

        if ($like) {
            // kalau sudah like, hapus (unlike)
            $like->delete();
            $status = 'unliked';
        } else {
            PostLike::create([
                'id_post' => $postId,
                'id_user' => $userId,
            ]);
            $status = 'liked';
        }

        $count = PostLike::where('id_post', $postId)->count();

        return response()->json([
            'status' => $status,
            'count' => $count
        ]);
    }
}
