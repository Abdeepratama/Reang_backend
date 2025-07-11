<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\IbadahController;
use App\Http\Controllers\Admin\SehatController;
use App\Http\Controllers\Admin\PasarController;
use App\Http\Controllers\Admin\PlesirController;
use App\Http\Controllers\Admin\DumasController;
use App\Http\Controllers\Admin\SekolahController;
use App\Models\NotifikasiAktivitas;

// Halaman Awal
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route Admin
Route::prefix('admin')->name('admin.')->group(function () {

    // ✅ Route login (khusus guest)
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    });

    // ✅ Route logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth:admin')
        ->name('logout');

    // ✅ Semua route di bawah butuh login admin
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Resource routes
        Route::resource('/ibadah', IbadahController::class);
        Route::resource('/sehat', SehatController::class);
        Route::resource('/pasar', PasarController::class);
        Route::resource('/plesir', PlesirController::class);
        Route::resource('/dumas', DumasController::class);
        Route::resource('/sekolah', SekolahController::class);

        Route::get('/admin/ibadah/tempat', [IbadahController::class, 'tempat'])->name('admin.ibadah.tempat.index');
        Route::get('/admin/pasar/tempat', [PasarController::class, 'tempat'])->name('admin.pasar.tempat.index');
        Route::get('/admin/plesir/tempat', [PlesirController::class, 'tempat'])->name('admin.plesir.tempat.index');
        Route::get('/admin/sehat/tempat', [SehatController::class, 'tempat'])->name('sehat.tempat.index');
        Route::get('/sekolah/aduan', [SekolahController::class, 'aduan'])->name('sekolah.aduan.index');

        // ✅ Route untuk klik notifikasi
        Route::get('/notifikasi/baca/{id}', function ($id) {
            $notifikasi = NotifikasiAktivitas::findOrFail($id);
            $notifikasi->update(['dibaca' => true]);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'url' => $notifikasi->url ?? route('admin.dashboard')
                ]);
            }

            return redirect()->to($notifikasi->url ?? route('admin.dashboard'));
        })->name('notifikasi.baca.satu');
    });
});
