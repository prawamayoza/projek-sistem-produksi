<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user    =   auth()->user();
        
        return view ('profil.index', [
            'user'      =>  $user,
            'title'     => 'Profil'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProfil(Request $request, string $id)
    {
        $request->validate([
            'name'              => 'required',
            'departemen'        => 'required',
            'email'             => 'required|email|unique:users,email,' . $id,
        ], [
            'name.required'         => 'Nama Harus Diisi',
            'departemen.required'   => 'Departemen Harus Diisi',
            'email.required'        => 'Email Harus Diisi',
            'email.email'           => 'Format Email Harus Sesuai',
            'email.unique'          => 'Email Sudah Digunakan',
        ]);

        $data = [
            'name'          => $request->name,
            'departemen'    => $request->departemen,
            'email'         => $request->email,
        ];

        if ($request->password) {

            $request->validate([
                'password'       => 'min:3',
            ], [
                'password.min'   => 'Password minimal 3 huruf/angka',
            ]);

            $data['password'] = bcrypt($request->password);;
        }

        User::where('id', $id)->update($data);

        return redirect()->back()->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
