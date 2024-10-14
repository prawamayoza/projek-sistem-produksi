<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Projek;
use App\Models\Tasklist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TasklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $task = Tasklist::orderByDesc('created_at')->get();
        return view('admin.tasklist.index',[
            'task'      => $task,
            'title'     => 'Tasklist'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::role('peg.produksi')->get(); 
        $projek = Projek::where('status', '!=', 'Completed')->get();
        return view('admin.tasklist.form', [
            'user'      => $user,
            'projek'    => $projek,
            'title'     => 'Tambah Tasklist'
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
            'projek_id'             => 'required',
            'user_id'               => 'required',
            'file'                  => 'required|max:2048',
        ], [
            'name.required'         => 'Nama Projek Wajib Diisi',
            'tanggal.required'      => 'Tanggal Wajib Diisi',
            'user_id.required'     => 'Penanggung Jawab Wajib Diisi',
            'projek_id.required'   => 'Projek Wajib Diisi',
            'file.required'         => 'File Projek Wajib Diisi',
            'file.max'              => 'File Projek Melebihi kapasitas Maximal 2048kb',
        ]);
        if ($request->hasFile('file')) {
            $fileName = $request->file('file')->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('files', $fileName, 'public');
        } else {
            $filePath = null;
        }

        Tasklist::create([
            'name'          => $request->name,
            'tanggal'       => $request->tanggal,
            'user_id'       => $request->user_id,
            'projek_id'     => $request->projek_id,
            'file'          => $filePath
        ]);

        return redirect()->route('task.index')->with('success', 'Data Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    $task = Tasklist::with('comment.user')->findOrFail($id); // Memuat komentar dan pengguna
    return view('admin.tasklist.detail', [
        'task' => $task,
        'title' => 'Detail Tasklist'
    ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user       = User::all();
        $projek     = Projek::where('status', 'Pending')->get();
        $task       = Tasklist::findOrFail($id);
        return view('admin.tasklist.form', [
            'user'      => $user,
            'projek'    => $projek,
            'task'      => $task,
            'title'     => 'Edit Tasklist'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task       = Tasklist::findOrFail($id);
        $request->validate([
            'name'                  => 'required',
            'tanggal'               => 'required',
            'projek_id'             => 'required',
            'user_id'               => 'required',
            'file'                  => 'nullable|max:2048',
        ], [
            'name.required'         => 'Nama Projek Wajib Diisi',
            'tanggal.required'      => 'Tanggal Wajib Diisi',
            'user_id.required'     => 'Penanggung Jawab Wajib Diisi',
            'projek_id.required'   => 'Projek Wajib Diisi',
            'file.required'         => 'File Projek Wajib Diisi',
            'file.max'              => 'File Projek Melebihi kapasitas Maximal 2048kb',
        ]);

        // Jika ada file baru yang diupload
        if ($request->hasFile('file')) {
            // Hapus file lama
            if ($task->file) {
                Storage::disk('public')->delete($task->file);
            }

            // Dapatkan nama file asli
            $fileName = $request->file('file')->getClientOriginalName();
            // Simpan file baru dengan nama asli
            $filePath = $request->file('file')->storeAs('files', $fileName, 'public');
        } else {
            $filePath = $task->file; // Tetap gunakan file lama jika tidak ada file baru
        }

        $task->update([
            'name'          => $request->name,
            'tanggal'       => $request->tanggal,
            'user_id'       => $request->user_id,
            'projek_id'     => $request->projek_id,
            'status'        => $request->status,
            'file'          => $filePath
        ]);

        return redirect()->route('task.index')->with('success', 'Data Berhasil Diperbarui');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task =Tasklist::find($id);

        if ($task->file) {
            Storage::disk('public')->delete($task->file);
        }

        $task->delete();

        return response()->json(['status' => 'Data Telah Dihapus']);
    }

    public function comment(Request $request)
    {
        $request->validate([
            'tasklist_id' => 'required|exists:tasklists,id',
            'comment' => 'required|string',
        ]);

        // Simpan komentar
        Comment::create([
            'tasklist_id' => $request->tasklist_id,
            'comment' => $request->comment,
            'user_id' => auth()->id(),
        ]);
        return response()->json(['status' => 'Komentar Berhasil Ditambah']);
    }
}
