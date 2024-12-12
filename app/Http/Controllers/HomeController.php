<?php

namespace App\Http\Controllers;

use App\Models\history_user;
use App\Models\Projek;
use App\Models\Tasklist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {


        $countSelesai       = history_user::where('status', 'Projek Selesai')->count();
        $countBerjalan      = history_user::where('status', 'Projek Berjalan')->count();
        $countInprogres     = Projek::where('status', 'In Progres')->count();
        $countCompleted     = Projek::where('status', 'Completed')->count();
        $countPending       = Projek::where('status', 'Pending')->count();
        $countAll           = Projek::all()->count();
        $countUser          = User::all()->count();
        if (Auth::user()->hasRole('peg.produksi')) {
            // Jika yang login adalah pegawai, hitung tasklist berdasarkan user_id
            $countTask = Tasklist::where('user_id', Auth::id())->count();
            $projekSelesai      = history_user::where('status', 'Projek Selesai')->where('user_id', Auth::id())->orderByDesc('created_at')->get();
            $projekBerjalan     = history_user::where('status', 'Projek Berjalan')->where('user_id', Auth::id())->orderByDesc('created_at')->get();
            $countSelesai       = history_user::where('status', 'Projek Selesai')->where('user_id', Auth::id())->count();
            $countBerjalan      = history_user::where('status', 'Projek Berjalan')->where('user_id', Auth::id())->count();
        } else {
            // Jika yang login bukan pegawai, hitung seluruh tasklist
            $countTask = Tasklist::count();
            $projekSelesai      = history_user::where('status', 'Projek Selesai')->orderByDesc('created_at')->get();
            $projekBerjalan     = history_user::where('status', 'Projek Berjalan')->orderByDesc('created_at')->get();
            $countSelesai       = history_user::where('status', 'Projek Selesai')->count();
            $countBerjalan      = history_user::where('status', 'Projek Berjalan')->count();
        }


        return view('home', [
            'countBerjalan'             => $countBerjalan,
            'projekBerjalan'            => $projekBerjalan,
            'countInprogres'            => $countInprogres,
            'countCompleted'            => $countCompleted,
            'projekSelesai'             => $projekSelesai,
            'countPending'              => $countPending,
            'countSelesai'              => $countSelesai,
            'countAll'                  => $countAll,
            'countTask'                 => $countTask,
            'countUser'                 => $countUser,
            'title'                     => 'Dashboard'
        ]);

    }
}
