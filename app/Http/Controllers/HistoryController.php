<?php

namespace App\Http\Controllers;

use App\Models\history_user;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projekSelesai = history_user::where('status', 'Projek Selesai')->orderByDesc('created_at')->get();
        $projekBerjalan = history_user::where('status', 'Projek Berjalan')->orderByDesc('created_at')->get();
    
        return view('Admin.history.index', [
            'projekSelesai'   => $projekSelesai,
            'projekBerjalan'  => $projekBerjalan,
            'title'           => 'Aktivitas User'
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
