<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::orderByDesc('created_at')->get();
        return view('Admin.User.index',[
            'user'  => $user,
            'title' => 'Master User'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role   = Role::all();
        return view('admin.user.form', [
            'title'     => 'Tambah User',
            'role'      => $role,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required|unique:users,name',
            'email'                 => 'required|email|unique:users,email',
            'role'                  => 'required',
            'departemen'            => 'required',
        ], [
            'name.required'         => 'Nama Wajib Diisi',
            "name.unique"           => 'Nama Sudah Digunakan',
            'email.required'        => 'Email Wajib Diisi',
            'email.email'           => 'Format Email Harus Sesuai',
            'email.unique'          => 'Email Sudah Digunakan',
            'departemen.required'   => 'Departemen Wajib Diisi',
            'role.required'         => 'Hak Akses Wajib Diisi',
        ]);
        $role = Role::findOrFail($request->role);
        
        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'departemen'    => $request->departemen,
            'password'      => bcrypt('password'),
        ]);
        $user->assignRole($role);

        return redirect()->route('user.index')->with('success', 'Data Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user   = User::findOrFail($id);
        $roles = $user->roles->map(function ($role) {
            return $role->name;
        })->implode(', ');

        return view('admin.user.detail', [
            'user'      => $user,
            'roles'      => $roles,
            'title'     => 'Detail User'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user   = User::findOrFail($id);
        $role   = Role::all();
        return view('admin.user.form', [
            'user'      => $user,
            'role'      => $role,
            'title'     => 'Edit User'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'              => 'required|unique:users,name,' . $id,
            'role'              => 'required',
            'email'             => 'required|email|unique:users,email,' . $id,
        ], [
            'name.required'         => 'Nama Wajib Diisi',
            "name.unique"           => 'Nama Sudah Digunakan',
            'email.required'        => 'Email Wajib Diisi',
            'email.email'           => 'Format Email Harus Sesuai',
            'email.unique'          => 'Email Sudah Digunakan',
            'role.required'         => 'Hak Akses Wajib Diisi',
        ]);

        $role = Role::findOrFail($request->role);
        $user = User::findOrFail($id); // Assuming $id is the user ID

        $data = [
            'name'          => $request->name,
            'email'         => $request->email,
            'departemen'    => $request->departemen
        ];

        $user->update($data);
        $user->syncRoles($role);

        return redirect()->route('user.index')->with('success', 'Data Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        $user->delete();

        return response()->json(['status' => 'Data Telah Dihapus']);
    }


    public function toggleStatus(User $user)
    {
        // Pastikan user tidak bisa menonaktifkan dirinya sendiri
        if (auth()->id() == $user->id) {
            return response()->json(['status' => 'Anda tidak bisa menonaktifkan akun sendiri!'], 403);
        }
    
        $user->is_active = !$user->is_active;
        $user->save();
    
        return response()->json(['status' => 'Status berhasil diperbarui']);
    }
    

}
