<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroupWilayahController;
use App\Http\Controllers\JemaatController;
use App\Http\Controllers\KkJemaatController;
use App\Http\Controllers\HubunganKeluargaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will be 
| assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Middleware Authentication untuk semua route berikut
Route::middleware('auth')->group(function () {
    // Routes untuk Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes untuk Group Wilayah
    Route::get('/group-wilayah', [GroupWilayahController::class, 'index'])->name('group_wilayah.index');
    Route::post('/group-wilayah', [GroupWilayahController::class, 'store'])->name('group_wilayah.store');
    Route::put('/group-wilayah/{id}', [GroupWilayahController::class, 'update'])->name('group_wilayah.update');
    Route::delete('/group-wilayah/{id}', [GroupWilayahController::class, 'destroy'])->name('group_wilayah.destroy');

    // Routes untuk Jemaat
    Route::get('/jemaat', [JemaatController::class, 'index'])->name('jemaat.index');
    Route::get('/jemaat/create', [JemaatController::class, 'create'])->name('jemaat.create');
    Route::post('/jemaat', [JemaatController::class, 'store'])->name('jemaat.store');
    Route::get('/jemaat/{id}/edit', [JemaatController::class, 'edit'])->name('jemaat.edit');
    Route::put('/jemaat/{id}', [JemaatController::class, 'update'])->name('jemaat.update');
    Route::delete('/jemaat/{id}', [JemaatController::class, 'destroy'])->name('jemaat.destroy');

    // Routes untuk Kepala Keluarga
    Route::get('/kk-jemaat', [KkJemaatController::class, 'index'])->name('kk_jemaat.index');
    Route::get('/kk-jemaat/create', [KkJemaatController::class, 'create'])->name('kk_jemaat.create');
    Route::post('/kk-jemaat', [KkJemaatController::class, 'store'])->name('kk_jemaat.store');
    Route::get('/kk-jemaat/{id}', [KkJemaatController::class, 'show'])->name('kk_jemaat.show');
    Route::get('/kk-jemaat/{id}/edit', [KkJemaatController::class, 'edit'])->name('kk_jemaat.edit');
    Route::put('/kk-jemaat/{id}', [KkJemaatController::class, 'update'])->name('kk_jemaat.update');
    Route::delete('/kk-jemaat/{id}', [KkJemaatController::class, 'destroy'])->name('kk_jemaat.destroy');
});

// Routes untuk Hubungan Keluarga
Route::middleware('auth')->group(function () {
    Route::get('/hubungan-keluarga', [HubunganKeluargaController::class, 'index'])->name('hubungan_keluarga.index');
    Route::get('/hubungan-keluarga/create', [HubunganKeluargaController::class, 'create'])->name('hubungan_keluarga.create');
    Route::post('/hubungan-keluarga', [HubunganKeluargaController::class, 'store'])->name('hubungan_keluarga.store');
    Route::get('/hubungan-keluarga/{id}/edit', [HubunganKeluargaController::class, 'edit'])->name('hubungan_keluarga.edit');
    Route::put('/hubungan-keluarga/{id}', [HubunganKeluargaController::class, 'update'])->name('hubungan_keluarga.update');
    Route::delete('/hubungan-keluarga/{id}', [HubunganKeluargaController::class, 'destroy'])->name('hubungan_keluarga.destroy');
});


// Route untuk menghapus session error agar modal tidak muncul terus
Route::get('/clear-errors', function() {
    session()->forget('errors'); // Hapus session error
    return response()->json(['success' => true]);
})->name('clear.errors');

require __DIR__.'/auth.php';
