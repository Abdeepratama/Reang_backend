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
use App\Http\Controllers\Admin\InfoController;
use App\Http\Controllers\Admin\PajakController;
use App\Http\Controllers\Admin\KerjaController;
use App\Http\Controllers\Admin\AdmindukController;
use App\Http\Controllers\Admin\RenbangController;
use App\Http\Controllers\Admin\IzinController;
use App\Http\Controllers\Admin\WifiController;
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
        Route::get('/admin/ibadah/tempat', [IbadahController::class, 'tempat'])->name('admin.ibadah.tempat.index');
        Route::get('/admin/ibadah/lokasi', [IbadahController::class, 'lokasi'])->name('admin.ibadah.tempat.map');
        Route::get('/admin/pasar/tempat', [PasarController::class, 'tempat'])->name('admin.pasar.tempat.index');
        Route::get('/admin/plesir/tempat', [PlesirController::class, 'tempat'])->name('admin.plesir.tempat.index');
        Route::get('/admin/sehat/tempat', [SehatController::class, 'tempat'])->name('sehat.tempat.index');
        Route::get('/admin/info', [InfoController::class, 'dashboard'])->name('admin.info.dashboard');
        Route::get('admin/pajak', [PajakController::class, 'dashboard'])->name('pajak.index');
        Route::get('admin/kerja', [KerjaController::class, 'dashboard'])->name('kerja.index');
        Route::get('admin/adminduk', [AdmindukController::class, 'dashboard'])->name('adminduk.index');
        Route::get('admin/renbang', [RenbangController::class, 'dashboard'])->name('renbang.index');
        Route::get('dumas/aduan', [DumasController::class, 'aduanIndex'])->name('dumas.aduan.index');
        Route::get('admin/izin', [IzinController::class, 'dashboard'])->name('izin.index');
        Route::get('admin/wifi', [WifiController::class, 'dashboard'])->name('wifi.index');
        Route::get('/slider', [DashboardController::class, 'sliderIndex'])->name('slider.index');
        Route::get('/slider/create', [DashboardController::class, 'sliderCreate'])->name('slider.create');
        Route::post('/slider', [DashboardController::class, 'sliderStore'])->name('slider.store');
        Route::get('/slider/{id}/edit', [DashboardController::class, 'sliderEdit'])->name('slider.edit');
        Route::put('/slider/{id}', [DashboardController::class, 'sliderUpdate'])->name('slider.update');
        Route::delete('/slider/{id}', [DashboardController::class, 'sliderDestroy'])->name('slider.destroy');
        Route::get('admin/renbang/deskripsi', [RenbangController::class, 'deskripsiIndex'])->name('renbang.deskripsi.index');
        Route::get('dumas/aduan', [DumasController::class, 'aduanIndex'])->name('dumas.aduan.index');
        Route::get('sekolah/aduan', [SekolahController::class, 'aduanIndex'])->name('sekolah.aduan.index');


        // Resource routes
        Route::resource('/ibadah', IbadahController::class);
        Route::resource('/sehat', SehatController::class);
        Route::resource('/pasar', PasarController::class);
        Route::resource('/plesir', PlesirController::class);
        Route::resource('/dumas', DumasController::class);
        Route::resource('/sekolah', SekolahController::class);
        Route::resource('/info', InfoController::class);
        Route::resource('/pajak', PajakController::class);
        Route::resource('/Kerja', KerjaController::class);
        Route::resource('/adminduk', AdmindukController::class);
        Route::resource('/renbang', RenbangController::class);
        Route::resource('/izin', IzinController::class);
        Route::resource('/wifi', wifiController::class);


        Route::get('/fitur', function () {
            return view('admin.fitur.index');
        })->name('fitur.index');


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
