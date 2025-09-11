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
use App\Http\Controllers\Admin\CaptchaController;
use App\Models\NotifikasiAktivitas;

// Halaman Awal
Route::get('/', function () {
    return view('landing/pages/dashboard/index');
})->name('home');

Route::get('/bantuan', function () {
    return view('landing.pages.bantuan.wadul');
})->name('bantuan.wadul');

// captcha
Route::get('/captcha/refresh', [CaptchaController::class, 'refresh'])->name('captcha.refresh');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    });

    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth:admin')
        ->name('logout');
});

// ✅ Semua route di bawah butuh login admin
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/info', [InfoController::class, 'dashboard'])->name('info.index'); // info di dashboard
});

//--------------------------------------------ibadah-yu----------------------------------------------------------
// tempat ibadah
Route::get('/ibadah/tempat', [IbadahController::class, 'index'])->name('admin.ibadah.tempat.index');
Route::post('/ibadah/simpan-lokasi', [IbadahController::class, 'simpanLokasi'])->name('admin.ibadah.tempat.simpanLokasi');
Route::get('/ibadah/tempat/map', [IbadahController::class, 'map'])->name('admin.ibadah.tempat.map');
Route::get('/ibadah/tempat/create', [IbadahController::class, 'createTempat'])->name('admin.ibadah.tempat.create');
Route::post('/ibadah/tempat', [IbadahController::class, 'storeTempat'])->name('admin.ibadah.tempat.store');
Route::get('/ibadah/tempat/{id}/edit', [IbadahController::class, 'editTempat'])->name('admin.ibadah.tempat.edit');
Route::put('/ibadah/tempat/{id}', [IbadahController::class, 'updateTempat'])->name('admin.ibadah.tempat.update');
Route::get('/ibadah/tempat/{id}/show', [IbadahController::class, 'showTempatWeb'])->name('admin.ibadah.tempat.show');
Route::delete('/ibadah/tempat/{id}', [IbadahController::class, 'destroyTempat'])->name('admin.ibadah.tempat.destroy');
// info ibadah
Route::get('/ibadah/info', [IbadahController::class, 'infoIndex'])->name('admin.ibadah.info.index');
Route::get('/ibadah/info/map', [IbadahController::class, 'infomap'])->name('admin.ibadah.info.map');
Route::get('/ibadah/info/create', [IbadahController::class, 'createInfo'])->name('admin.ibadah.info.create');
Route::post('/ibadah/info', [IbadahController::class, 'storeInfo'])->name('admin.ibadah.info.store');
Route::get('/ibadah/info/{id}/edit', [IbadahController::class, 'infoEdit'])->name('admin.ibadah.info.edit');
Route::put('/ibadah/info/{id}', [IbadahController::class, 'infoUpdate'])->name('admin.ibadah.info.update');
Route::delete('/ibadah/info/{id}', [IbadahController::class, 'infoDestroy'])->name('admin.ibadah.info.destroy');

//--------------------------------------------pasar-yu---------------------------------------------------------
// tempat pasar
Route::get('/pasar/tempat', [PasarController::class, 'tempat'])->name('admin.pasar.tempat.index');
Route::get('/pasar/tempat/map', [PasarController::class, 'map'])->name('admin.pasar.tempat.map');
Route::get('/pasar/tempat/create', [IbadahController::class, 'create'])->name('admin.pasar.tempat.create');
Route::post('/pasar/tempat', [IbadahController::class, 'store'])->name('admin.pasar.tempat.store');
Route::get('/pasar/tempat/{id}/edit', [IbadahController::class, 'edit'])->name('admin.pasar.tempat.edit');
Route::put('/pasar/tempat/{id}', [IbadahController::class, 'update'])->name('admin.pasar.tempat.update');
Route::delete('/pasar/tempat/{id}', [IbadahController::class, 'destroy'])->name('admin.pasar.tempat.destroy');

//--------------------------------------------plesir-yu-----------------------------------------------------------
//tempat plesir
Route::get('/plesir/tempat', [PlesirController::class, 'tempat'])->name('admin.plesir.tempat.index');
Route::get('/plesir/tempat/map', [PlesirController::class, 'map'])->name('admin.plesir.tempat.map');
Route::get('/plesir/tempat/create', [PlesirController::class, 'createInfo'])->name('admin.plesir.tempat.create');
Route::post('/plesir/tempat/store', [PlesirController::class, 'storeInfo'])->name('admin.plesir.tempat.store');
Route::get('/plesir/tempat/edit/{id}', [PlesirController::class, 'infoEdit'])->name('admin.plesir.tempat.edit');
Route::put('/plesir/tempat/update/{id}', [PlesirController::class, 'infoUpdate'])->name('admin.plesir.tempat.update');
Route::delete('/plesir/tempat/destroy/{id}', [PlesirController::class, 'infoDestroy'])->name('admin.plesir.tempat.destroy');
// info map
Route::get('/plesir/tempat/info-map', [PlesirController::class, 'infomap'])->name('admin.plesir.info.map');
Route::get('/plesir/info', [PlesirController::class, 'info'])->name('admin.plesir.info.index');
Route::get('/plesir/info/create', [PlesirController::class, 'createInfo'])->name('admin.plesir.info.create');
Route::post('/plesir/store', [PlesirController::class, 'storeInfo'])->name('admin.plesir.info.store');
Route::get('/plesir/edit/{id}', [PlesirController::class, 'infoEdit'])->name('admin.plesir.info.edit');
Route::put('/plesir/update/{id}', [PlesirController::class, 'infoUpdate'])->name('admin.plesir.info.update');
Route::delete('/plesir/destroy/{id}', [PlesirController::class, 'infoDestroy'])->name('admin.plesir.info.destroy');

//-----------------------------------------------sehat------------------------------------------------------------
// lokasi rumahsakit/puskesmas
Route::get('/sehat/tempat', [SehatController::class, 'tempat'])->name('admin.sehat.tempat.index');
Route::get('/sehat/tempat/create', [SehatController::class, 'create'])->name('admin.sehat.tempat.create');
Route::post('/sehat/tempat/store', [SehatController::class, 'store'])->name('admin.sehat.tempat.store');
Route::get('/sehat/tempat/edit/{id}', [SehatController::class, 'edit'])->name('admin.sehat.tempat.edit');
Route::put('/sehat/tempat/update/{id}', [SehatController::class, 'update'])->name('admin.sehat.tempat.update');
Route::get('/sehat/tempat/map', [SehatController::class, 'map'])->name('admin.sehat.tempat.map');
Route::delete('/sehat/tempat/{id}', [SehatController::class, 'destroy'])->name('admin.sehat.tempat.destroy');
//info kesehatan
Route::get('/sehat/info', [SehatController::class, 'infoindex'])->name('admin.sehat.info.index');
Route::get('/sehat/info/create', [SehatController::class, 'infocreate'])->name('admin.sehat.info.create');
Route::post('/sehat/info/store', [SehatController::class, 'infostore'])->name('admin.sehat.info.store');
Route::get('/sehat/info/edit/{id}', [SehatController::class, 'infoedit'])->name('admin.sehat.info.edit');
Route::put('/sehat/info/update/{id}', [SehatController::class, 'infoupdate'])->name('admin.sehat.info.update');
Route::delete('/sehat/destroy/{id}', [SehatController::class, 'infodestroy'])->name('admin.sehat.info.destroy');
Route::post('/upload-image', [SehatController::class, 'upload'])->name('admin.sehat.info.upload.image');
//tempat olahraga
Route::get('/olahraga/tempat', [SehatController::class, 'indexolahraga'])->name('admin.sehat.olahraga.index');
Route::get('/olahraga/tempat/create', [SehatController::class, 'createolahraga'])->name('admin.sehat.olahraga.create');
Route::post('/olahraga/tempat/store', [SehatController::class, 'storeolahraga'])->name('admin.sehat.olahraga.store');
Route::get('/olahraga/tempat/edit/{id}', [SehatController::class, 'editolahraga'])->name('admin.sehat.olahraga.edit');
Route::put('/olahraga/tempat/update/{id}', [SehatController::class, 'updateolahraga'])->name('admin.sehat.olahraga.update');
Route::delete('/olahraga/tempat/delete/{id}', [SehatController::class, 'destroyolahraga'])->name('admin.sehat.olahraga.destroy');
Route::get('/olahraga/tempat/map', [SehatController::class, 'mapolahraga'])->name('admin.sehat.olahraga.map');

// pajak
Route::get('/pajak/info/index', [PajakController::class, 'infoindex'])->name('admin.pajak.info.index');
Route::get('/pajak/info/create', [PajakController::class, 'infocreate'])->name('admin.pajak.info.create');
Route::post('/pajak/info/store', [PajakController::class, 'infostore'])->name('admin.pajak.info.store');
Route::get('/pajak/info/{id}/edit', [PajakController::class, 'infoedit'])->name('admin.pajak.info.edit');
Route::put('/pajak/info/{id}', [PajakController::class, 'infoupdate'])->name('admin.pajak.info.update');
Route::delete('/pajak/info/{id}', [PajakController::class, 'infodestroy'])->name('admin.pajak.info.destroy');
Route::post('/pajak/info/upload-image', [PajakController::class, 'infoupload'])->name('admin.pajak.info.upload.image');

// kerja
Route::get('/kerja/index', [KerjaController::class, 'infoindex'])->name('admin.kerja.info.index');
Route::get('/kerja/create', [KerjaController::class, 'infocreate'])->name('admin.kerja.info.create');
Route::post('/kerja/store', [KerjaController::class, 'infostore'])->name('admin.kerja.info.store');
Route::get('/kerja/info/{id}/edit', [KerjaController::class, 'infoedit'])->name('admin.kerja.info.edit');
Route::put('/kerja/info/{id}', [KerjaController::class, 'infoupdate'])->name('admin.kerja.info.update');
Route::delete('/kerja/info/{id}', [KerjaController::class, 'infodestroy'])->name('admin.kerja.info.destroy');
Route::post('/kerja/info/upload-image', [KerjaController::class, 'upload'])->name('admin.kerja.info.upload.image');

// Info Adminduk
Route::get('/adminduk/index', [AdmindukController::class, 'infoindex'])->name('admin.adminduk.info.index');
Route::get('/adminduk/create', [AdmindukController::class, 'infocreate'])->name('admin.adminduk.info.create');
Route::post('/adminduk/store', [AdmindukController::class, 'infostore'])->name('admin.adminduk.info.store');
Route::get('/adminduk/info/{id}/edit', [AdmindukController::class, 'infoedit'])->name('admin.adminduk.info.edit');
Route::put('/adminduk/info/{id}', [AdmindukController::class, 'infoupdate'])->name('admin.adminduk.info.update');
Route::delete('/adminduk/info/{id}', [AdmindukController::class, 'infodestroy'])->name('admin.adminduk.info.destroy');
Route::post('/adminduk/info/upload-image', [AdmindukController::class, 'infoupload'])->name('admin.adminduk.info.upload.image');

// renbang
Route::get('/renbang/deskripsi', [RenbangController::class, 'deskripsiIndex'])->name('admin.renbang.deskripsi.index');
Route::get('/renbang/deskripsi/create', [RenbangController::class, 'deskripsiCreate'])->name('admin.renbang.deskripsi.create');
Route::post('/renbang/deskripsi/store', [RenbangController::class, 'deskripsiStore'])->name('admin.renbang.deskripsi.store');
Route::get('/renbang/deskripsi/{id}/edit', [RenbangController::class, 'deskripsiEdit'])->name('admin.renbang.deskripsi.edit');
Route::put('/renbang/deskripsi/{id}', [RenbangController::class, 'deskripsiUpdate'])->name('admin.renbang.deskripsi.update');
Route::delete('/renbang/deskripsi/{id}', [RenbangController::class, 'deskripsiDestroy'])->name('admin.renbang.deskripsi.destroy');
Route::post('/renbang/upload-image', [IzinController::class, 'deskripsiUpload'])->name('admin.renbang.deskripsi.upload.image');

// dumas
Route::get('dumas/aduan', [DumasController::class, 'aduanIndex'])->name('admin.dumas.aduan.index');
Route::get('dumas/aduan/{id}/edit', [DumasController::class, 'aduanEdit'])->name('admin.dumas.aduan.edit');
Route::put('dumas/aduan/{id}', [DumasController::class, 'aduanUpdate'])->name('admin.dumas.aduan.update');
Route::delete('dumas/aduan/{id}', [DumasController::class, 'aduanDestroy'])->name('admin.dumas.aduan.destroy');

// izin-yu
// Info Perizinan
Route::get('/izin/info', [IzinController::class, 'infoindex'])->name('admin.izin.info.index');
Route::get('/izin/info/create', [IzinController::class, 'infocreate'])->name('admin.izin.info.create');
Route::post('/izin/info/store', [IzinController::class, 'infostore'])->name('admin.izin.info.store');
Route::get('/izin/edit/{id}', [IzinController::class, 'infoedit'])->name('admin.izin.info.edit');
Route::put('/izin/update/{id}', [IzinController::class, 'infoupdate'])->name('admin.izin.info.update');
Route::delete('/izin/destroy/{id}', [IzinController::class, 'infodestroy'])->name('admin.izin.info.destroy');
Route::post('/izin/upload-image', [IzinController::class, 'upload'])->name('admin.izin.info.upload.image');

// wifi
Route::get('admin/wifi', [WifiController::class, 'index'])->name('admin.wifi.index');

// info-yu
Route::get('admin/info', [InfoController::class, 'index'])->name('admin.info.index');

//slider
Route::get('/slider', [DashboardController::class, 'sliderIndex'])->name('admin.slider.index');
Route::get('/slider/create', [DashboardController::class, 'sliderCreate'])->name('admin.slider.create');
Route::post('/slider', [DashboardController::class, 'sliderStore'])->name('admin.slider.store');
Route::get('/slider/{id}/edit', [DashboardController::class, 'sliderEdit'])->name('admin.slider.edit');
Route::put('/slider/{id}', [DashboardController::class, 'sliderUpdate'])->name('admin.slider.update');
Route::delete('/slider/{id}', [DashboardController::class, 'sliderDestroy'])->name('admin.slider.destroy');

// --------------------------------------------SEKOLAH-----------------------------------------------------------------
// tempat sekolah
Route::get('/tempat', [SekolahController::class, 'indexTempat'])->name('admin.sekolah.tempat.index');
Route::get('tempat/create', [SekolahController::class, 'createTempat'])->name('admin.sekolah.tempat.create');
Route::post('tempat', [SekolahController::class, 'storeTempat'])->name('admin.sekolah.tempat.store');
Route::get('tempat/{id}/edit', [SekolahController::class, 'editTempat'])->name('admin.sekolah.tempat.edit');
Route::put('tempat/{id}', [SekolahController::class, 'updateTempat'])->name('admin.sekolah.tempat.update');
Route::get('tempat/map', [SekolahController::class, 'mapTempat'])->name('admin.sekolah.tempat.map');
Route::delete('tempat/{id}', [SekolahController::class, 'destroyTempat'])->name('admin.sekolah.tempat.destroy');
// info sekolah
Route::get('/sekolah/index', [SekolahController::class, 'infoindex'])->name('admin.sekolah.info.index');
Route::get('/sekolah/create', [SekolahController::class, 'infocreate'])->name('admin.sekolah.info.create');
Route::post('/sekolah/store', [SekolahController::class, 'infostore'])->name('admin.sekolah.info.store');
Route::get('/sekolah/info/{id}/edit', [SekolahController::class, 'infoedit'])->name('admin.sekolah.info.edit');
Route::put('/sekolah/info/{id}', [SekolahController::class, 'infoupdate'])->name('admin.sekolah.info.update');
Route::delete('/sekolah/info/{id}', [SekolahController::class, 'infodestroy'])->name('admin.sekolah.info.destroy');
Route::post('/sekolah/info/upload-image', [SekolahController::class, 'infoupload'])->name('admin.sekolah.info.upload.image');

// setting
Route::get('/setting', [SettingController::class, 'index'])->name('admin.setting.index');

// kategori
Route::get('kategori', [KategoriController::class, 'index'])->name('admin.kategori.index');
Route::get('kategori/create', [KategoriController::class, 'create'])->name('admin.kategori.create');
Route::post('kategori', [KategoriController::class, 'store'])->name('admin.kategori.store');
Route::delete('kategori/{kategori}', [KategoriController::class, 'destroy'])->name('admin.kategori.destroy');

// Resource routes
Route::resource('/sehat', SehatController::class);
Route::resource('admin/dumas', DumasController::class);
Route::resource('/izin', IzinController::class);
Route::resource('/maps',    WebController::class);



Route::get('/fitur', function () {
    return view('admin.fitur.index');
})->name('admin.fitur.index');


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
})->name(name: 'admin.notifikasi.baca.satu');
