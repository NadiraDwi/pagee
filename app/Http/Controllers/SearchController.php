<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Chapter;
use App\Models\User;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q'); // ambil query dari input

        if (!$query) {
            return redirect()->back();
        }

        // Cari di Post
        $posts = Post::where('judul', 'like', "%{$query}%")
                    ->orWhere('isi', 'like', "%{$query}%")
                    ->get();

        // Cari di Chapter
        $chapters = Chapter::where('judul_chapter', 'like', "%{$query}%")
                        ->orWhere('isi_chapter', 'like', "%{$query}%")
                        ->get();

        // Cari di Profile / User
        $profiles = User::where('nama', 'like', "%{$query}%")
                        ->orWhere('username', 'like', "%{$query}%")
                        ->get();
        
        $trends = Post::where('is_anonymous', 1)
            ->latest()
            ->take(5)
            ->pluck('isi')
            ->map(fn ($isi) => Str::limit($isi, 30, '...'));

        return view('search', compact('query', 'posts', 'chapters', 'profiles', 'trends'));
    }
}
