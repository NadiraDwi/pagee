<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostCollab;

class PostCollabController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_post' => 'required',
            'id_user' => 'required'
        ]);

        // Cegah duplikasi
        $exists = PostCollab::where('id_post', $request->id_post)
                ->where(function ($q) use ($request) {
                    $q->where('id_user1', $request->id_user)
                      ->orWhere('id_user2', $request->id_user);
                })
                ->exists();

        if ($exists) return response()->json(['message' => 'exists']);

        PostCollab::create([
            'id_post' => $request->id_post,
            'id_user1' => auth()->id(),
            'id_user2' => $request->id_user
        ]);

        return response()->json(['message' => 'added']);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'id_post' => 'required',
            'id_user' => 'required'
        ]);

        PostCollab::where('id_post', $request->id_post)
                ->where(function ($q) use ($request) {
                    $q->where('id_user1', $request->id_user)
                      ->orWhere('id_user2', $request->id_user);
                })
                ->delete();

        return response()->json(['message' => 'removed']);
    }
}
