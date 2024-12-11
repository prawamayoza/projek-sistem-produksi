<?php

namespace App\Http\Controllers;

use App\Models\Projek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projek = Projek::orderByDesc('created_at')->get();
        return view('admin.projek.index',[
            'title'     => 'Projek ',
            'projek'    => $projek,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.projek.form', [
            'title'     => ' Tambah Projek'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required',
            'tanggal'               => 'required',
            'deskripsi'             => 'required',
            'file'                  => 'required|mimes:pdf,doc,docx|max:2048',
        ], [
            'name.required'         => 'Nama Projek Wajib Diisi',
            'tanggal.required'      => 'Tanggal Wajib Diisi',
            'deskripsi.required'    => 'Deskripsi Wajib Diisi',
            'file.required'         => 'File Projek Wajib Diisi',
            'file.max'              => 'File Projek Melebihi kapasitas Maximal 2048kb',
        ]);
        if ($request->hasFile('file')) {
            $fileName = $request->file('file')->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('files', $fileName, 'public');
        } else {
            $filePath = null;
        }
        Projek::create([
            'name'          => $request->name,
            'tanggal'       => $request->tanggal,
            'deskripsi'     => $request->deskripsi,
            'file'          => $filePath
        ]);

        return redirect()->route('projek.index')->with('success', 'Data Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {   
        $projek = Projek::findOrFail($id);
        return view('admin.projek.detail',[
            'title'     => 'Detail Projek',
            'projek'    =>$projek
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $projek = Projek::findOrFail($id);
        return view('admin.projek.form',[
            'title'     => 'Edit Projek',
            'projek'    => $projek
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $projek = Projek::findOrFail($id);
        $request->validate([
            'name'        => 'required',
            'tanggal'     => 'required',
            'deskripsi'   => 'required',
            'file'        => 'nullable|mimes:pdf,doc,docx|max:2048',
        ], [
            'name.required'         => 'Nama Projek Wajib Diisi',
            'email.required'        => 'tanggal Wajib Diisi',
            'deskripsi.required'    => 'Deskripsi Wajib Diisi',
            'file.required'         => 'File Projek Wajib Diisi',
            'file.max'              => 'File Projek Melebihi kapasitas Maximal 2048kb',
        ]);

        // Jika ada file baru yang diupload
        if ($request->hasFile('file')) {
            // Hapus file lama
            if ($projek->file) {
                Storage::disk('public')->delete($projek->file);
            }

            // Dapatkan nama file asli
            $fileName = $request->file('file')->getClientOriginalName();
            // Simpan file baru dengan nama asli
            $filePath = $request->file('file')->storeAs('files', $fileName, 'public');
        } else {
            $filePath = $projek->file; // Tetap gunakan file lama jika tidak ada file baru
        }

        // Update data projek di database
        $projek->update([
            'name'        => $request->name,
            'tanggal'     => $request->tanggal,
            'deskripsi'   => $request->deskripsi,
            'status'      => $request->status,  
            'file'        => $filePath,
        ]);

        return redirect()->route('projek.index')->with('success', 'Data Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $projek =Projek::find($id);

        if ($projek->file) {
            Storage::disk('public')->delete($projek->file);
        }

        $projek->delete();

        return response()->json(['status' => 'Data Telah Dihapus']);
    }
}
