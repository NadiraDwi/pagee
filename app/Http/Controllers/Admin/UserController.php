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

    public function list(Request $request)
    {
        if ($request->ajax()) {

            $data = User::orderBy('nama', 'ASC');

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-sm btn-outline-danger"
                            onclick="deleteData(\''.$row->id_user.'\')">
                            Hapus
                        </button>
                    ';
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return abort(404);
    }

    public function delete($id)
    {
        $user = User::where('id_user', $id)->first();

        if (!$user) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        $user->delete(); // ✅ posts ikut terhapus otomatis karena cascade

        return response()->json(['success' => true]);
    }

}
