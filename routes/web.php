<?php

use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ProjekController;
use App\Http\Controllers\TasklistController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

            Route::resource('user', UserController::class);
            Route::post('/user/toggle-status/{user}', [UserController::class, 'toggleStatus'])->name('user.toggleStatus');
            Route::resource('projek', ProjekController::class);
            Route::resource('task', TasklistController::class);
            Route::resource('history', HistoryController::class);


            Route::get('profil', [ProfilController::class, 'index'])->name('profil');
            Route::post('update-profil/{update}', [ProfilController::class, 'updateProfil'])->name('update-profil');

            Route::post('/task/comment', [TasklistController::class, 'comment'])->name('task.comment');
            Route::post('/tasklist/{id}/upload', [TasklistController::class, 'uploadFile'])->name('tasklist.uploadFile');
});
