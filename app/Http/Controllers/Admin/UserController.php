<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.index');
    }

    public function list()
    {
        $data = User::orderBy('nama', 'asc'); // ❗ tanpa get()

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                return '
                <button onclick="deleteData('.$row->id_user.')" class="btn btn-danger btn-sm">
                    Hapus
                </button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function delete($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        $user->delete(); // ✅ posts ikut terhapus otomatis karena cascade

        return response()->json(['success' => true]);
    }

}
