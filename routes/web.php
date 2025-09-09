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

        // dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/admin/info', [InfoController::class, 'dashboard'])->name('admin.info.dashboard'); // info di dashboard

        //--------------------------------------------ibadah-yu----------------------------------------------------------
        // tempat ibadah
        Route::get('/ibadah/tempat', [IbadahController::class, 'index'])->name('ibadah.tempat.index');
        Route::post('/ibadah/simpan-lokasi', [IbadahController::class, 'simpanLokasi'])->name('ibadah.tempat.simpanLokasi');
        Route::get('/ibadah/tempat/map', [IbadahController::class, 'map'])->name('ibadah.tempat.map');
        Route::get('/ibadah/tempat/create', [IbadahController::class, 'createTempat'])->name('ibadah.tempat.create');
        Route::post('/ibadah/tempat', [IbadahController::class, 'storeTempat'])->name('ibadah.tempat.store');
        Route::get('/ibadah/tempat/{id}/edit', [IbadahController::class, 'editTempat'])->name('ibadah.tempat.edit');
        Route::put('/ibadah/tempat/{id}', [IbadahController::class, 'updateTempat'])->name('ibadah.tempat.update');
        Route::get('/ibadah/tempat/{id}/show', [IbadahController::class, 'showTempatWeb'])->name('ibadah.tempat.show');
        Route::delete('/ibadah/tempat/{id}', [IbadahController::class, 'destroyTempat'])->name('ibadah.tempat.destroy');
        // info ibadah
        Route::get('/ibadah/info', [IbadahController::class, 'infoIndex'])->name('ibadah.info.index');
        Route::get('/ibadah/info/map', [IbadahController::class, 'infomap'])->name('ibadah.info.map');
        Route::get('/ibadah/info/create', [IbadahController::class, 'createInfo'])->name('ibadah.info.create');
        Route::post('/ibadah/info', [IbadahController::class, 'storeInfo'])->name('ibadah.info.store');
        Route::get('/ibadah/info/{id}/edit', [IbadahController::class, 'infoEdit'])->name('ibadah.info.edit');
        Route::put('/ibadah/info/{id}', [IbadahController::class, 'infoUpdate'])->name('ibadah.info.update');
        Route::delete('/ibadah/info/{id}', [IbadahController::class, 'infoDestroy'])->name('ibadah.info.destroy');

        //--------------------------------------------pasar-yu---------------------------------------------------------
        // tempat pasar
        Route::get('/pasar/tempat', [PasarController::class, 'tempat'])->name('pasar.tempat.index');
        Route::get('/pasar/tempat/map', [PasarController::class, 'map'])->name('pasar.tempat.map');

        //--------------------------------------------plesir-yu-----------------------------------------------------------
        //tempat plesir
        Route::get('/plesir/tempat', [PlesirController::class, 'tempat'])->name('plesir.tempat.index');
        Route::get('/plesir/tempat/map', [PlesirController::class, 'map'])->name('plesir.tempat.map');
        // info map
        Route::get('/plesir/tempat/info-map', [PlesirController::class, 'infomap'])->name('plesir.info.map');
        Route::get('/plesir/info', [PlesirController::class, 'info'])->name('plesir.info.index');
        Route::get('/plesir/info/create', [PlesirController::class, 'createInfo'])->name('plesir.info.create');
        Route::post('/plesir/store', [PlesirController::class, 'storeInfo'])->name('plesir.info.store');
        Route::get('/plesir/edit/{id}', [PlesirController::class, 'infoEdit'])->name('plesir.info.edit');
        Route::put('/plesir/update/{id}', [PlesirController::class, 'infoUpdate'])->name('plesir.info.update');
        Route::delete('/plesir/destroy/{id}', [PlesirController::class, 'infoDestroy'])->name('plesir.info.destroy');

        //-----------------------------------------------sehat------------------------------------------------------------
        // lokasi rumahsakit/puskesmas
        Route::get('/sehat/tempat', [SehatController::class, 'tempat'])->name('sehat.tempat.index');
        Route::get('/sehat/tempat/map', [SehatController::class, 'map'])->name('sehat.tempat.map');
        Route::delete('/sehat/tempat/{id}', [SehatController::class, 'destroy'])->name('sehat.tempat.destroy');
        //info kesehatan
        Route::get('/sehat/info', [SehatController::class, 'infoindex'])->name('sehat.info.index');
        Route::get('/sehat/info/create', [SehatController::class, 'infocreate'])->name('sehat.info.create');
        Route::post('/sehat/info/store', [SehatController::class, 'infostore'])->name('sehat.info.store');
        Route::get('/sehat/edit/{id}', [SehatController::class, 'infoedit'])->name('sehat.info.edit');
        Route::put('/sehat/update/{id}', [SehatController::class, 'infoupdate'])->name('sehat.info.update');
        Route::delete('/sehat/destroy/{id}', [SehatController::class, 'infodestroy'])->name('sehat.info.destroy');
        Route::post('/upload-image', [SehatController::class, 'upload'])->name('sehat.info.upload.image');
        //tempat olahraga
        Route::get('/olahraga/tempat', [SehatController::class, 'indexolahraga'])->name('sehat.olahraga.index');
        Route::get('/olahraga/tempat/create', [SehatController::class, 'createolahraga'])->name('sehat.olahraga.create');
        Route::post('/olahraga/tempat/store', [SehatController::class, 'storeolahraga'])->name('sehat.olahraga.store');
        Route::get('/olahraga/tempat/edit/{id}', [SehatController::class, 'editolahraga'])->name('sehat.olahraga.edit');
        Route::put('/olahraga/tempat/update/{id}', [SehatController::class, 'updateolahraga'])->name('sehat.olahraga.update');
        Route::delete('/olahraga/tempat/delete/{id}', [SehatController::class, 'destroyolahraga'])->name('sehat.olahraga.destroy');
        Route::get('/olahraga/tempat/map', [SehatController::class, 'mapolahraga'])->name('sehat.olahraga.map');

        // pajak
        Route::get('/pajak/info/index', [PajakController::class, 'infoindex'])->name('pajak.info.index');
        Route::get('/pajak/info/create', [PajakController::class, 'infocreate'])->name('pajak.info.create');
        Route::post('/pajak/info/store', [PajakController::class, 'infostore'])->name('pajak.info.store');
        Route::get('/pajak/info/{id}/edit', [PajakController::class, 'infoedit'])->name('pajak.info.edit');
        Route::put('/pajak/info/{id}', [PajakController::class, 'infoupdate'])->name('pajak.info.update');
        Route::delete('/pajak/info/{id}', [PajakController::class, 'infodestroy'])->name('pajak.info.destroy');
        Route::post('/pajak/info/upload-image', [PajakController::class, 'infoupload'])->name('pajak.info.upload.image');

        // kerja
        Route::get('/kerja/index', [KerjaController::class, 'infoindex'])->name('kerja.info.index');
        Route::get('/kerja/create', [KerjaController::class, 'infocreate'])->name('kerja.info.create');
        Route::post('/kerja/store', [KerjaController::class, 'infostore'])->name('kerja.info.store');
        Route::get('/kerja/info/{id}/edit', [KerjaController::class, 'infoedit'])->name('kerja.info.edit');
        Route::put('/kerja/info/{id}', [KerjaController::class, 'infoupdate'])->name('kerja.info.update');
        Route::delete('/kerja/info/{id}', [KerjaController::class, 'infodestroy'])->name('kerja.info.destroy');
        Route::post('/kerja/info/upload-image', [KerjaController::class, 'upload'])->name('kerja.info.upload.image');

        // Info Adminduk
        Route::get('/adminduk/index', [AdmindukController::class, 'infoindex'])->name('adminduk.info.index');
        Route::get('/adminduk/create', [AdmindukController::class, 'infocreate'])->name('adminduk.info.create');
        Route::post('/adminduk/store', [AdmindukController::class, 'infostore'])->name('adminduk.info.store');
        Route::get('/adminduk/info/{id}/edit', [AdmindukController::class, 'infoedit'])->name('adminduk.info.edit');
        Route::put('/adminduk/info/{id}', [AdmindukController::class, 'infoupdate'])->name('adminduk.info.update');
        Route::delete('/adminduk/info/{id}', [AdmindukController::class, 'infodestroy'])->name('adminduk.info.destroy');
        Route::post('/adminduk/info/upload-image', [AdmindukController::class, 'infoupload'])->name('adminduk.info.upload.image');

        // renbang
        Route::get('/renbang', [RenbangController::class, 'dashboard'])->name('renbang.index');
        Route::get('/renbang/deskripsi', [RenbangController::class, 'deskripsiIndex'])->name('renbang.deskripsi.index');

        // dumas
        Route::get('dumas/aduan', [DumasController::class, 'aduanIndex'])->name('dumas.aduan.index');

        // izin-yu
        // Info Perizinan
        Route::get('/izin/info', [IzinController::class, 'infoindex'])->name('izin.info.index');
        Route::get('/izin/info/create', [IzinController::class, 'infocreate'])->name('izin.info.create');
        Route::post('/izin/info/store', [IzinController::class, 'infostore'])->name('izin.info.store');
        Route::get('/izin/edit/{id}', [IzinController::class, 'infoedit'])->name('izin.info.edit');
        Route::put('/izin/update/{id}', [IzinController::class, 'infoupdate'])->name('izin.info.update');
        Route::delete('/izin/destroy/{id}', [IzinController::class, 'infodestroy'])->name('izin.info.destroy');
        Route::post('/izin/upload-image', [IzinController::class, 'upload'])->name('izin.info.upload.image');

        // wifi
        Route::get('admin/wifi', [WifiController::class, 'dashboard'])->name('wifi.index');

        //slider
        Route::get('/slider', [DashboardController::class, 'sliderIndex'])->name('slider.index');
        Route::get('/slider/create', [DashboardController::class, 'sliderCreate'])->name('slider.create');
        Route::post('/slider', [DashboardController::class, 'sliderStore'])->name('slider.store');
        Route::get('/slider/{id}/edit', [DashboardController::class, 'sliderEdit'])->name('slider.edit');
        Route::put('/slider/{id}', [DashboardController::class, 'sliderUpdate'])->name('slider.update');
        Route::delete('/slider/{id}', [DashboardController::class, 'sliderDestroy'])->name('slider.destroy');

        // --------------------------------------------SEKOLAH-----------------------------------------------------------------
        // tempat sekolah
        Route::get('/tempat', [SekolahController::class, 'indexTempat'])->name('sekolah.tempat.index');
        Route::get('tempat/create', [SekolahController::class, 'createTempat'])->name('sekolah.tempat.create');
        Route::post('tempat', [SekolahController::class, 'storeTempat'])->name('sekolah.tempat.store');
        Route::get('tempat/{id}/edit', [SekolahController::class, 'editTempat'])->name('sekolah.tempat.edit');
        Route::put('tempat/{id}', [SekolahController::class, 'updateTempat'])->name('sekolah.tempat.update');
        Route::get('tempat/map', [SekolahController::class, 'mapTempat'])->name('sekolah.tempat.map');
        Route::delete('tempat/{id}', [SekolahController::class, 'destroyTempat'])->name('sekolah.tempat.destroy');
        // info sekolah
        Route::get('/sekolah/index', [SekolahController::class, 'infoindex'])->name('sekolah.info.index');
        Route::get('/sekolah/create', [SekolahController::class, 'infocreate'])->name('sekolah.info.create');
        Route::post('/sekolah/store', [SekolahController::class, 'infostore'])->name('sekolah.info.store');
        Route::get('/sekolah/info/{id}/edit', [SekolahController::class, 'infoedit'])->name('sekolah.info.edit');
        Route::put('/sekolah/info/{id}', [SekolahController::class, 'infoupdate'])->name('sekolah.info.update');
        Route::delete('/sekolah/info/{id}', [SekolahController::class, 'infodestroy'])->name('sekolah.info.destroy');
        Route::post('/sekolah/info/upload-image', [SekolahController::class, 'infoupload'])->name('sekolah.info.upload.image');

        // setting
        Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');


        // Resource routes
        Route::resource('/ibadah', IbadahController::class);
        Route::resource('/sehat', SehatController::class);
        Route::resource('/pasar', PasarController::class);
        Route::resource('/plesir', PlesirController::class);
        Route::resource('/dumas', DumasController::class);
        Route::resource('/info', InfoController::class);
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
