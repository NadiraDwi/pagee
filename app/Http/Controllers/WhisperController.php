<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;

class WhisperController extends Controller
{
    // Tampilkan semua whisper anonim
    public function index()
    {
        $whispers = Post::where('is_anonymous', 1)
                        ->orderBy('created_at', 'desc')
                        ->get();

        $trends = Post::where('is_anonymous', 1)
                      ->latest()
                      ->take(5)
                      ->pluck('isi')
                      ->map(fn($isi) => Str::limit($isi, 30, '...'));

        return view('user.whisper', compact('whispers', 'trends'));
    }

    // Update whisper
    public function update(Request $request, $id)
    {
        $whisper = Post::findOrFail($id);
        $request->validate([
            'isi' => 'required|string|max:1000',
        ]);

        $whisper->isi = $request->isi;
        $whisper->save();

        return redirect()->back()->with('success', 'Whisper berhasil diupdate!');
    }

    // Hapus whisper
    public function destroy($id)
    {
        $whisper = Post::findOrFail($id);
        $whisper->delete();

        return redirect()->back()->with('success', 'Whisper berhasil dihapus!');
    }
}
