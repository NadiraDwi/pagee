<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Yajra\DataTables\DataTables;

class PostController extends Controller
{
    public function index()
    {
        return view('admin.post.index');
    }

    public function anonim()
    {
        return view('admin.anonim.index');
    }

    public function list()
    {
        // Ambil post yang type = short
        $data = Post::with('user')
                    ->where('jenis_post', 'short')
                    ->where('is_anonymous', false)
                    ->orderBy('created_at', 'desc');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('user', function($row){
                return $row->user->nama ?? '-';
            })
            ->addColumn('tanggal', function($row){
                return $row->created_at->format('d M Y');
            })
            ->addColumn('action', function($row){
                return '
                <button class="btn btn-info btn-sm" onclick="showPostDetail('.$row->id_post.')">Detail</button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function anonimList()
    {
        // Ambil post yang type = short
        $data = Post::with('user')
                    ->where('jenis_post', 'short')
                    ->where('is_anonymous', true)
                    ->orderBy('created_at', 'desc');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('user', function($row){
                return $row->user->nama ?? '-';
            })
            ->addColumn('tanggal', function($row){
                return $row->created_at->format('d M Y');
            })
            ->addColumn('action', function($row){
                return '
                <button class="btn btn-info btn-sm" onclick="showPostDetail('.$row->id_post.')">Detail</button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function show($id)
    {
        $post = Post::with('user')->findOrFail($id);
        return view('admin.post.detail', compact('post'));
    }

    public function delete($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        $post->delete();
        return response()->json(['success' => true]);
    }
}
