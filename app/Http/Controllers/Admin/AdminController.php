<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $admins = User::select(['id', 'name', 'email', 'phone', 'status', 'created_at'])
                ->where('user_type', 1)
                ->orderByDesc('id');

            return DataTables::of($admins)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $checked = $row->status ? 'checked' : '';
                    return '<div class="form-check form-switch">
                                <input class="form-check-input toggle-status" data-id="' . $row->id . '" type="checkbox" ' . $checked . '>
                            </div>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="dropdown">
                          <button class="btn btn-soft-secondary btn-sm" data-bs-toggle="dropdown"><i class="ri-more-fill"></i></button>
                          <ul class="dropdown-menu dropdown-menu-end">
                            <li><button class="dropdown-item EditBtn" data-id="' . $row->id . '"><i class="ri-pencil-fill me-2"></i>Edit</button></li>
                            <li class="dropdown-divider"></li>
                            <li><button class="dropdown-item deleteBtn" data-delete-url="' . route('admin.delete', $row->id) . '" data-method="DELETE" data-table="#adminTable"><i class="ri-delete-bin-fill me-2"></i>Delete</button></li>
                          </ul>
                        </div>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('admin.admins.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'password'  => Hash::make($request->password),
            'user_type' => 1,  // Admin type
            'status'    => 1,
        ]);

        return response()->json(['message' => 'Admin created successfully.']);
    }

    public function edit($id)
    {
        $admin = User::where('id', $id)->where('user_type', 1)->firstOrFail();
        return response()->json($admin);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'       => 'required|exists:users,id',
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $request->id,
            'phone'    => 'required|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $admin = User::where('id', $request->id)->where('user_type', 1)->firstOrFail();
        
        $admin->name  = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        
        if ($request->password) {
            $admin->password = Hash::make($request->password);
        }
        
        $admin->save();

        return response()->json(['message' => 'Admin updated successfully.']);
    }

    public function destroy($id)
    {
        $admin = User::where('id', $id)->where('user_type', 1)->firstOrFail();
        $admin->delete();
        
        return response()->json(['message' => 'Admin deleted successfully.']);
    }

    public function toggleStatus(Request $request)
    {
        $admin = User::where('id', $request->id)->where('user_type', 1)->firstOrFail();
        $admin->status = $request->status;
        $admin->save();
        
        return response()->json(['message' => 'Status updated successfully.']);
    }
}