<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\history_user;
use App\Models\Projek;
use App\Models\Tasklist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TasklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $id = Auth::user()->id;
        $filter = (object)[
            'projeks_id' => $request->projek_id // Hanya menggunakan projek_id
        ];

        if (Auth::user()->hasRole('peg.produksi')) {
            $task = Tasklist::filter($filter)
            ->orderBy('created_at', 'desc')
            ->where('user_id', $id)
            ->get();
        } else {
            $task = Tasklist::filter($filter)
            ->orderBy('created_at', 'desc')
            ->get();
        }
    
        $projek = Projek::all(); 
    
        return view('admin.tasklist.index', [
            'task'   => $task,
            'projek' => $projek,
            'title'  => 'Tasklist'
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
            'name'                  => 'required|unique:tasklists,name',
            'tanggal'               => 'required',
            'projek_id'             => 'required',
            'user_id'               => 'required',
        ], [
            'name.required'         => 'Nama Task Wajib Diisi',
            'name.unique'           => 'Nama Task Sudah Digunakan',
            'tanggal.required'      => 'Tanggal Wajib Diisi',
            'user_id.required'     => 'Penanggung Jawab Wajib Diisi',
            'projek_id.required'   => 'Projek Wajib Diisi',
        ]);

        $tasklist = Tasklist::create([
            'name'          => $request->name,
            'tanggal'       => $request->tanggal,
            'user_id'       => $request->user_id,
            'projek_id'     => $request->projek_id,
        ]);

        history_user::create([
            'user_id'     => $request->user_id,
            'tasklist_id' => $tasklist->id,
            'status'      => 'Projek Berjalan', // default status
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
        $user       = User::role('peg.produksi')->get();
        $projek     = Projek::where('status', '!=', 'Completed')->get();
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
        $task = Tasklist::findOrFail($id);
    
        $request->validate([
            'name'      => 'required|unique:tasklists,name,' . $id,
            'tanggal'   => 'required',
            'projek_id' => 'required',
            'user_id'   => 'required',
        ], [
            'name.required'      => 'Nama Task Wajib Diisi',
            'name.unique'        => 'Nama Task Sudah Digunakan',
            'tanggal.required'   => 'Tanggal Wajib Diisi',
            'user_id.required'   => 'Penanggung Jawab Wajib Diisi',
            'projek_id.required' => 'Projek Wajib Diisi',
        ]);
    
        // Check if user_id or status has changed
        $userChanged = $task->user_id != $request->user_id;
        $statusChangedToCompleted = $request->status === 'Completed';
        $statusChangedFromCompleted = $task->status === 'Completed' && $request->status !== 'Completed';
    
        // Update the Tasklist
        $task->update([
            'name'       => $request->name,
            'tanggal'    => $request->tanggal,
            'user_id'    => $request->user_id,
            'projek_id'  => $request->projek_id,
            'status'     => $request->status,
        ]);
    
        // Find the related HistoryUser entry
        $history = history_user::where('tasklist_id', $task->id)->first();
    
        // Update HistoryUser if user_id has changed
        if ($userChanged) {
            $history->update(['user_id' => $request->user_id]);
        }
    
        // Update HistoryUser status based on Tasklist status
        if ($statusChangedToCompleted) {
            $history->update(['status' => 'Projek Selesai']);
        } elseif ($statusChangedFromCompleted) {
            $history->update(['status' => 'Projek Berjalan']);
        }
    
        return redirect()->route('task.index')->with('success', 'Data Berhasil Diperbarui');
    }    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Tasklist::findOrFail($id);

        if ($task->file) {
            Storage::disk('public')->delete($task->file);
        }

        // Hapus data history yang terkait
        history_user::where('tasklist_id', $task->id)->delete();

        // Hapus tasklist
        $task->delete();

        return response()->json(['status' => 'Data Telah Dihapus']);
    }

    private function handleUpload($request)
    {
        $uploadedFiles = [];
        $fileLinks = [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filePath = $file->storeAs('tasklist_files', $file->getClientOriginalName(), 'public');
                $uploadedFiles[] = $filePath;
            }
        }

        if ($request->has('file_links')) {
            $fileLinks = $request->file_links;
        }

        return [
            'files' => json_encode($uploadedFiles),
            'file_links' => json_encode($fileLinks),
        ];
    }

    public function comment(Request $request)
    {
        $request->validate([
            'tasklist_id'       => 'required|exists:tasklists,id',
            'comment'           => 'required|string',
            'files'             => 'required_without:file_links',
            'file_links'        => 'required_without:files',
            'files.*'           => 'required|mimes:jpg,jpeg,png|max:2048',
            'file_links.*'      => 'url'
        ], [
            'files.required_without'       => "Upload dokumen wajib diisi jika link tidak ada",
            'file_links.required_without'  => "Link wajib diisi jika tidak ada dokumen yang diupload",
            'files.mimes'                  => "File harus berupa JPG, JPEG, atau PNG",
            'files.max'                    => "Ukuran file melebihi kapasitas maksimal 2MB",
            'file_links.url'               => "Masukkan link yang valid"
        ]);

        // Panggil fungsi handleUpload
        $uploadResult = $this->handleUpload($request);
        // Simpan komentar dengan files dan file_links
        Comment::create([
            'tasklist_id' => $request->tasklist_id,
            'comment' => $request->comment,
            'user_id' => auth()->id(),
            'files' => $uploadResult['files'],
            'file_links' => $uploadResult['file_links'],
        ]);

        return response()->json(['status' => 'Komentar Berhasil Ditambah']);
    }


    public function uploadFile(Request $request, $id)
    {
        $request->validate([
            'files'             => 'required_without:file_links',
            'file_links'        => 'required_without:files',
            'files.*'           => 'mimes:pdf,doc,docx|max:2048',
            'file_links.*'      => 'url'
        ], [
            'files.required_without'       => "Upload dokumen wajib diisi jika link tidak ada",
            'file_links.required_without'  => "Link wajib diisi jika tidak ada dokumen yang diupload",
            'files.mimes'                  => "File harus berupa PDF, DOC, atau DOCX",
            'files.max'                    => "Ukuran dokumen melebihi kapasitas maksimal 2MB",
            'file_links.url'               => "Masukkan link yang valid"
        ]);
    
        $tasklist = Tasklist::findOrFail($id);
    
        // Panggil fungsi handleUpload
        $uploadResult = $this->handleUpload($request);
    
        // Update tasklist dengan files dan file_links baru
        $tasklist->files = $uploadResult['files'];
        $tasklist->file_links = $uploadResult['file_links'];
        $tasklist->save();
    
        return response()->json(['status' => 'Upload Berhasil Ditambah']);
    }
    
}
