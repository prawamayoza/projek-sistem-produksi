<?php

use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ProjekController;
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
    Route::group(
        [
            'middleware'    => ['role:admin'],
        ],
        function () {
            Route::resource('user', UserController::class);
            Route::patch('user/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('user.toggleStatus');
            Route::resource('projek', ProjekController::class);

    });
    Route::group(
        [
            'middleware'    => ['role:admin|peg.produksi|c.level'],
        ],
        function () {
            Route::get('profil', [ProfilController::class, 'index'])->name('profil');
            Route::post('update-profil/{update}', [ProfilController::class, 'updateProfil'])->name('update-profil');
    });

});
