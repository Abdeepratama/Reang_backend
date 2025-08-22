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
use App\Http\Controllers\Admin\WebController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\SettingController;
use App\Models\Kategori;
use App\Models\NotifikasiAktivitas;

// Halaman Awal
Route::get('/', function () {
    return view('landing/pages/dashboard/index');
})->name('home');

Route::get('/bantuan', function () {
    return view('landing.pages.bantuan.wadul');
})->name('bantuan.wadul');

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
        Route::get('/ibadah/tempat', [IbadahController::class, 'tempat'])->name('ibadah.tempat.index');
        Route::get('/pasar/tempat', [PasarController::class, 'tempat'])->name('pasar.tempat.index');
        Route::post('/ibadah/simpan-lokasi', [IbadahController::class, 'simpanLokasi'])->name('admin.ibadah.tempat.simpanLokasi');
        Route::get('/ibadah/tempat/map', [IbadahController::class, 'map'])->name('ibadah.tempat.map');
        Route::get('/plesir/tempat', [PlesirController::class, 'tempat'])->name('plesir.tempat.index');
        Route::get('/plesir/tempat/map', [PlesirController::class, 'map'])->name('plesir.tempat.map');
        Route::get('/plesir/tempat/info-map', [PlesirController::class, 'infomap'])->name('plesir.info.map');
        Route::get('/sehat/tempat', [SehatController::class, 'tempat'])->name('sehat.tempat.index');
        Route::get('/sehat/tempat/map', [SehatController::class, 'map'])->name('sehat.tempat.map');
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
        Route::get('/renbang/deskripsi', [RenbangController::class, 'deskripsiIndex'])->name('renbang.deskripsi.index');
        Route::get('dumas/aduan', [DumasController::class, 'aduanIndex'])->name('dumas.aduan.index');
        Route::get('sekolah/aduan', [SekolahController::class, 'aduanIndex'])->name('sekolah.aduan.index');
        Route::get('ibadah/tempat/create', [IbadahController::class, 'createTempat'])->name('ibadah.tempat.create');
        Route::get('ibadah/info', [IbadahController::class, 'infoIndex'])->name('ibadah.info.index');
        Route::get('/ibadah/info/map', [IbadahController::class, 'infomap'])->name('ibadah.info.map');
        Route::get('ibadah/info/create', [IbadahController::class, 'createInfo'])->name('ibadah.info.create');
        Route::post('ibadah/info', [IbadahController::class, 'storeInfo'])->name('ibadah.info.store');
        Route::get('ibadah/info/{id}/edit', [IbadahController::class, 'infoEdit'])->name('ibadah.info.edit');
        Route::put('ibadah/info/{id}', [IbadahController::class, 'infoUpdate'])->name('ibadah.info.update');
        Route::delete('ibadah/info/{id}', [IbadahController::class, 'infoDestroy'])->name('ibadah.info.destroy');
        Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');

        Route::get('/plesir/info', [PlesirController::class, 'info'])->name('plesir.info.index');
        Route::get('/plesir/info/create', [PlesirController::class, 'createInfo'])->name('plesir.info.create');
        Route::post('/plesir/store', [PlesirController::class, 'storeInfo'])->name('plesir.info.store');
        Route::get('/{id}/plesir/edit', [PlesirController::class, 'infoEdit'])->name('plesir.info.edit');
        Route::put('/{id}/plesir/update', [PlesirController::class, 'infoUpdate'])->name('plesir.info.update');
        Route::delete('/{id}/plesir/destroy', [PlesirController::class, 'infoDestroy'])->name('plesir.info.destroy');
        Route::get('/pasar/tempat/map', [PasarController::class, 'map'])->name('pasar.tempat.map');

        Route::get('/tempat', [SekolahController::class, 'indexTempat'])->name('sekolah.tempat.index');
        Route::get('tempat/create', [SekolahController::class, 'createTempat'])->name('sekolah.tempat.create');
        Route::post('tempat', [SekolahController::class, 'storeTempat'])->name('sekolah.tempat.store');
        Route::get('tempat/{id}/edit', [SekolahController::class, 'editTempat'])->name('sekolah.tempat.edit');
        Route::put('tempat/{id}', [SekolahController::class, 'updateTempat'])->name('sekolah.tempat.update');
        Route::get('tempat/map', [SekolahController::class, 'mapTempat'])->name('sekolah.tempat.map');
        Route::delete('tempat/{id}', [SekolahController::class, 'destroyTempat'])->name('sekolah.tempat.destroy');

        Route::get('/aduan', [SekolahController::class, 'aduanindex'])->name('sekolah.aduan.index');
        Route::get('aduan/create', [SekolahController::class, 'createAduan'])->name('sekolah.aduan.create');
        Route::post('aduan', [SekolahController::class, 'storeAduan'])->name('sekolah.aduan.store');
        Route::get('aduan/{id}/edit', [SekolahController::class, 'editAduan'])->name('sekolah.aduan.edit');
        Route::put('aduan/{id}', [SekolahController::class, 'updateAduan'])->name('sekolah.aduan.update');
        Route::delete('aduan/{id}', [SekolahController::class, 'aduanDestroy'])->name('sekolah.aduan.destroy');
        Route::get('aduan/map', [SekolahController::class, 'mapAduan'])->name('sekolah.aduan.map');

        Route::get('/pasar/info', [PasarController::class, 'info'])->name('pasar.info.index');
        Route::get('/pasar/info/create', [PasarController::class, 'createInfo'])->name('pasar.info.create');
        Route::post('/pasar/store', [PasarController::class, 'storeInfo'])->name('pasar.info.store');
        Route::get('/{id}/pasar/edit', [PasarController::class, 'infoEdit'])->name('pasar.info.edit');
        Route::put('/{id}/pasar/update', [PasarController::class, 'infoUpdate'])->name('pasar.info.update');
        Route::delete('/{id}/pasar/destroy', [PasarController::class, 'infoDestroy'])->name('pasar.info.destroy');
        // Opsional: untuk peta
        Route::get('/pasar/info/map', [PasarController::class, 'map'])->name('pasar.info.map');

        Route::get('/sehat/info', [SehatController::class, 'infoindex'])->name('sehat.info.index');
        Route::get('/sehat/info/create', [SehatController::class, 'infocreate'])->name('sehat.info.create');
        Route::post('/sehat/store', [SehatController::class, 'infostore'])->name('sehat.info.store');
        Route::get('/{id}/sehat/edit', [SehatController::class, 'infoedit'])->name('sehat.info.edit');
        Route::put('/{id}/sehat/update', [SehatController::class, 'infoupdate'])->name('sehat.info.update');
        Route::delete('/{id}/sehat/destroy', [SehatController::class, 'infodestroy'])->name('sehat.info.destroy');

        // Resource routes
        Route::resource('ibadah', IbadahController::class);
        Route::resource('/sehat', SehatController::class);
        Route::resource('/pasar', PasarController::class);
        Route::resource('/plesir', PlesirController::class);
        Route::resource('/dumas', DumasController::class);
        Route::resource('/info', InfoController::class);
        Route::resource('/pajak', PajakController::class);
        Route::resource('/Kerja', KerjaController::class);
        Route::resource('/adminduk', AdmindukController::class);
        Route::resource('/renbang', RenbangController::class);
        Route::resource('/izin', IzinController::class);
        Route::resource('/wifi', wifiController::class);
        Route::resource('/kategori', KategoriController::class);
        Route::resource('/maps',    WebController::class);



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
