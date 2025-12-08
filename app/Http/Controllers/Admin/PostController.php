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

    public function list()
    {
        $data = Post::with('user')->orderBy('created_at', 'desc');

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
                <button onclick="deletePost('.$row->id.')" class="btn btn-danger btn-sm">Hapus</button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
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
