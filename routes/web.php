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
use App\Http\Controllers\Admin\KategoriDumasController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CaptchaController;
use App\Http\Controllers\Admin\AdminAccountController;
use App\Models\NotifikasiAktivitas;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// ----------------- HALAMAN DEPAN -----------------
Route::get('/', fn() => view('landing/pages/dashboard/index'))->name('home');
Route::get('/bantuan', fn() => view('landing.pages.bantuan.wadul'))->name('bantuan.wadul');
Route::get('/captcha/refresh', [CaptchaController::class, 'refresh'])->name('captcha.refresh');

// ----------------- AUTH ADMIN -----------------
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:admin')->name('logout');
});

// ----------------- ROUTE ADMIN -----------------
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'checkadmindinas'])->group(function () {
    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/info', [InfoController::class, 'index'])->name('info.index');

    // ----------------- IBADAH -----------------
    Route::prefix('ibadah')->name('ibadah.')->group(function () {
        Route::get('/tempat', [IbadahController::class, 'index'])->name('tempat.index');
        Route::post('/simpan-lokasi', [IbadahController::class, 'simpanLokasi'])->name('tempat.simpanLokasi');
        Route::get('/tempat/map', [IbadahController::class, 'mapTempat'])->name('tempat.map');
        Route::get('/tempat/create', [IbadahController::class, 'createTempat'])->name('tempat.create');
        Route::post('/tempat', [IbadahController::class, 'storeTempat'])->name('tempat.store');
        Route::get('/tempat/{id}/edit', [IbadahController::class, 'editTempat'])->name('tempat.edit');
        Route::put('/tempat/{id}', [IbadahController::class, 'updateTempat'])->name('tempat.update');
        Route::get('/tempat/{id}/show', [IbadahController::class, 'showTempatWeb'])->name('tempat.show');
        Route::delete('/tempat/{id}', [IbadahController::class, 'destroyTempat'])->name('tempat.destroy');

        Route::get('/info', [IbadahController::class, 'infoIndex'])->name('info.index');
        Route::get('/info/map', [IbadahController::class, 'infomap'])->name('info.map');
        Route::get('/info/create', [IbadahController::class, 'createInfo'])->name('info.create');
        Route::post('/info', [IbadahController::class, 'storeInfo'])->name('info.store');
        Route::get('/info/{id}/edit', [IbadahController::class, 'infoEdit'])->name('info.edit');
        Route::put('/info/{id}', [IbadahController::class, 'infoUpdate'])->name('info.update');
        Route::delete('/info/{id}', [IbadahController::class, 'infoDestroy'])->name('info.destroy');
    });

    // ----------------- PASAR -----------------
    Route::prefix('pasar')->name('pasar.')->group(function () {
        // CRUD Tempat
        Route::get('tempat', [PasarController::class, 'tempat'])->name('tempat.index');
        Route::get('tempat/create', [PasarController::class, 'create'])->name('tempat.create');
        Route::post('tempat', [PasarController::class, 'store'])->name('tempat.store');
        Route::get('tempat/{id}/edit', [PasarController::class, 'edit'])->name('tempat.edit');
        Route::put('tempat/{id}', [PasarController::class, 'update'])->name('tempat.update');
        Route::delete('tempat/{id}', [PasarController::class, 'destroy'])->name('tempat.destroy');

        // Tambahan
        Route::get('tempat/map', [PasarController::class, 'map'])->name('tempat.map');
        Route::post('tempat/simpan-lokasi', [PasarController::class, 'simpanLokasi'])->name('tempat.simpan');
        Route::post('tempat/upload-image', [PasarController::class, 'upload'])->name('tempat.upload');

        // API JSON
        Route::get('tempat/show/{id?}', [PasarController::class, 'show'])->name('tempat.show');
    });

    // ----------------- PLESIR -----------------
    Route::prefix('plesir')->name('plesir.')->group(function () {
        Route::get('/tempat', [PlesirController::class, 'tempat'])->name('tempat.index');
        Route::get('/tempat/map', [PlesirController::class, 'map'])->name('tempat.map');
        Route::get('/tempat/create', [PlesirController::class, 'createInfo'])->name('tempat.create');
        Route::post('/tempat/store', [PlesirController::class, 'storeInfo'])->name('tempat.store');
        Route::get('/tempat/edit/{id}', [PlesirController::class, 'infoEdit'])->name('tempat.edit');
        Route::put('/tempat/update/{id}', [PlesirController::class, 'infoUpdate'])->name('tempat.update');
        Route::delete('/tempat/destroy/{id}', [PlesirController::class, 'infoDestroy'])->name('tempat.destroy');

        Route::get('/tempat/info-map', [PlesirController::class, 'infomap'])->name('info.map');
        Route::get('/info', [PlesirController::class, 'info'])->name('info.index');
        Route::get('/info/create', [PlesirController::class, 'createInfo'])->name('info.create');
        Route::post('/store', [PlesirController::class, 'storeInfo'])->name('info.store');
        Route::get('/edit/{id}', [PlesirController::class, 'infoEdit'])->name('info.edit');
        Route::put('/update/{id}', [PlesirController::class, 'infoUpdate'])->name('info.update');
        Route::delete('/destroy/{id}', [PlesirController::class, 'infoDestroy'])->name('info.destroy');
    });

    // ----------------- SEHAT -----------------
    Route::prefix('sehat')->name('sehat.')->group(function () {
        // lokasi sehat
        Route::get('/tempat', [SehatController::class, 'tempat'])->name('tempat.index');
        Route::get('/tempat/create', [SehatController::class, 'create'])->name('tempat.create');
        Route::post('/tempat/store', [SehatController::class, 'store'])->name('tempat.store');
        Route::get('/tempat/edit/{id}', [SehatController::class, 'edit'])->name('tempat.edit');
        Route::put('/tempat/update/{id}', [SehatController::class, 'update'])->name('tempat.update');
        Route::get('/tempat/map', [SehatController::class, 'map'])->name('tempat.map');
        Route::delete('/tempat/{id}', [SehatController::class, 'destroy'])->name('tempat.destroy');

        // info sehat
        Route::get('/info', [SehatController::class, 'infoindex'])->name('info.index');
        Route::get('/info/create', [SehatController::class, 'infocreate'])->name('info.create');
        Route::post('/info/store', [SehatController::class, 'infostore'])->name('info.store');
        Route::get('/info/edit/{id}', [SehatController::class, 'infoedit'])->name('info.edit');
        Route::put('/info/update/{id}', [SehatController::class, 'infoupdate'])->name('info.update');
        Route::delete('/info/destroy/{id}', [SehatController::class, 'infodestroy'])->name('info.destroy');
        Route::post('/upload-image', [SehatController::class, 'upload'])->name('info.upload.image');
    });

    // ----------------- OLAHRAGA -----------------
    Route::prefix('olahraga')->name('sehat.olahraga.')->group(function () {
        Route::get('/olahraga', [SehatController::class, 'indexolahraga'])->name('index');
        Route::get('/tempat/create', [SehatController::class, 'createolahraga'])->name('create');
        Route::post('/tempat/store', [SehatController::class, 'storeolahraga'])->name('store');
        Route::get('/tempat/edit/{id}', [SehatController::class, 'editolahraga'])->name('edit');
        Route::put('/tempat/update/{id}', [SehatController::class, 'updateolahraga'])->name('update');
        Route::delete('/tempat/delete/{id}', [SehatController::class, 'destroyolahraga'])->name('destroy');
        Route::get('/tempat/map', [SehatController::class, 'mapolahraga'])->name('map');
    });

    // ----------------- PAJAK -----------------
    Route::prefix('pajak')->name('pajak.')->group(function () {
        Route::resource('info', PajakController::class)->except(['show']);
        Route::post('info/upload-image', [PajakController::class, 'infoupload'])->name('info.upload.image');
    });

    // ----------------- KERJA -----------------
    Route::prefix('kerja')->name('kerja.')->group(function () {
        // Info Kerja
        Route::get('info', [KerjaController::class, 'infoindex'])->name('info.index');
        Route::get('info/create', [KerjaController::class, 'infocreate'])->name('info.create');
        Route::post('info', [KerjaController::class, 'infostore'])->name('info.store');
        Route::get('info/{id}/edit', [KerjaController::class, 'infoedit'])->name('info.edit');
        Route::put('info/{id}', [KerjaController::class, 'infoupdate'])->name('info.update');
        Route::delete('info/{id}', [KerjaController::class, 'infodestroy'])->name('info.destroy');

        // Upload image (ckeditor atau summernote)
        Route::post('info/upload-image', [KerjaController::class, 'upload'])->name('info.upload.image');
    });

    // ----------------- ADMINDUK -----------------
    Route::prefix('adminduk')->name('adminduk.')->group(function () {
        // INFO ADMIN DUK
        Route::get('info', [AdmindukController::class, 'infoindex'])->name('info.index');
        Route::get('info/create', [AdmindukController::class, 'infocreate'])->name('info.create');
        Route::post('info', [AdmindukController::class, 'infostore'])->name('info.store');
        Route::get('info/{id}/edit', [AdmindukController::class, 'infoedit'])->name('info.edit');
        Route::put('info/{id}', [AdmindukController::class, 'infoupdate'])->name('info.update');
        Route::delete('info/{id}', [AdmindukController::class, 'infodestroy'])->name('info.destroy');

        // Upload untuk CKEditor
        Route::post('info/upload-image', [AdmindukController::class, 'infoupload'])->name('info.upload.image');
    });

    // ----------------- RENBANG -----------------
    Route::prefix('renbang')->name('renbang.')->group(function () {
        // DESKRIPSI RENBANG
        Route::get('Renbang/Info', [RenbangController::class, 'infoIndex'])->name('info.index');
        Route::get('Renbang/Info/create', [RenbangController::class, 'infoCreate'])->name('info.create');
        Route::post('Renbang/Info', [RenbangController::class, 'infoStore'])->name('info.store');
        Route::get('Renbang/Info/{id}/edit', [RenbangController::class, 'infoEdit'])->name('info.edit');
        Route::put('Renbang/Info/{id}', [RenbangController::class, 'infoUpdate'])->name('info.update');
        Route::delete('Renbang/Info/{id}', [RenbangController::class, 'infoDestroy'])->name('info.destroy');

        // Upload gambar (CKEditor)
        Route::post('Info/upload-image', [RenbangController::class, 'infoUpload'])->name('info.upload.image');
    });

    // ----------------- DUMAS -----------------
    Route::prefix('dumas')->name('dumas.')->group(function () {
        Route::resource('aduan', DumasController::class)->except(['show', 'create', 'store']);
    });

    // ----------------- IZIN -----------------
    Route::prefix('izin')->name('izin.')->group(function () {
        // CRUD Info Perizinan
        Route::get('info', [IzinController::class, 'infoindex'])->name('info.index');
        Route::get('info/create', [IzinController::class, 'infocreate'])->name('info.create');
        Route::post('info', [IzinController::class, 'infostore'])->name('info.store');
        Route::get('info/{id}/edit', [IzinController::class, 'infoedit'])->name('info.edit');
        Route::put('info/{id}', [IzinController::class, 'infoupdate'])->name('info.update');
        Route::delete('info/{id}', [IzinController::class, 'infodestroy'])->name('info.destroy');

        // Upload gambar (CKEditor)
        Route::post('info/upload-image', [IzinController::class, 'upload'])->name('info.upload.image');
    });

    // ----------------- WIFI -----------------
    Route::get('wifi', [WifiController::class, 'index'])->name('wifi.index');

    // ----------------- SLIDER -----------------
    Route::prefix('admin/slider')->name('slider.')->group(function () {
        Route::get('/', [DashboardController::class, 'sliderIndex'])->name('index');
        Route::get('/create', [DashboardController::class, 'sliderCreate'])->name('create');
        Route::post('/store', [DashboardController::class, 'sliderStore'])->name('store');
        Route::get('/{id}/edit', [DashboardController::class, 'sliderEdit'])->name('edit');
        Route::put('/{id}/update', [DashboardController::class, 'sliderUpdate'])->name('update');
        Route::delete('/{id}/destroy', [DashboardController::class, 'sliderDestroy'])->name('destroy');
    });

    // ------------------BANNER-------------------
    Route::prefix('admin/banner')->name('banner.')->group(function () {
        Route::get('/banner', [DashboardController::class, 'bannerIndex'])->name('index');
        Route::get('/banner/create', [DashboardController::class, 'bannerCreate'])->name('create');
        Route::post('/banner', [DashboardController::class, 'bannerStore'])->name('store');
        Route::get('/banner/{id}/edit', [DashboardController::class, 'bannerEdit'])->name('edit');
        Route::put('/banner/{id}', [DashboardController::class, 'bannerUpdate'])->name('update');
        Route::delete('/banner/{id}', [DashboardController::class, 'bannerDestroy'])->name('destroy');
        Route::post('info/upload-image', [DashboardController::class, 'uploadBanner'])->name('upload.image');
    });

    // ----------------- SEKOLAH -----------------
    Route::prefix('sekolah')->name('sekolah.')->group(function () {
        Route::get('tempat', [SekolahController::class, 'indexTempat'])->name('tempat.index');
        Route::get('tempat/create', [SekolahController::class, 'createTempat'])->name('tempat.create');
        Route::post('tempat', [SekolahController::class, 'storeTempat'])->name('tempat.store');
        Route::get('tempat/{id}/edit', [SekolahController::class, 'editTempat'])->name('tempat.edit');
        Route::put('tempat/{id}', [SekolahController::class, 'updateTempat'])->name('tempat.update');
        Route::delete('tempat/{id}', [SekolahController::class, 'destroyTempat'])->name('tempat.destroy');
        Route::get('tempat/map', [SekolahController::class, 'mapTempat'])->name('tempat.map');

        Route::get('info', [SekolahController::class, 'infoindex'])->name('info.index');
        Route::get('info/create', [SekolahController::class, 'infocreate'])->name('info.create');
        Route::post('info', [SekolahController::class, 'infostore'])->name('info.store');
        Route::get('info/{id}/edit', [SekolahController::class, 'infoedit'])->name('info.edit');
        Route::put('info/{id}', [SekolahController::class, 'infoupdate'])->name('info.update');
        Route::delete('info/{id}', [SekolahController::class, 'infodestroy'])->name('info.destroy');
        Route::post('info/upload-image', [SekolahController::class, 'infoupload'])->name('info.upload.image');
    });

    // ----------------- SETTING -----------------
    Route::get('setting', [SettingController::class, 'index'])->name('setting.index');

    // ----------------- KATEGORI -----------------
    Route::resource('kategori', KategoriController::class)->except(['show', 'edit', 'update']);

    // ----------------- KATEGORI DUMAS -----------------
    Route::get('kategori-dumas', [KategoriDumasController::class, 'index'])->name('kategori_dumas.index');
    Route::get('kategori-dumas/create', [KategoriDumasController::class, 'create'])->name('kategori_dumas.create');
    Route::post('kategori-dumas', [KategoriDumasController::class, 'store'])->name('kategori_dumas.store');
    Route::get('kategori-dumas/{id}/edit', [KategoriDumasController::class, 'edit'])->name('kategori_dumas.edit');
    Route::put('kategori-dumas/{id}', [KategoriDumasController::class, 'update'])->name('kategori_dumas.update');
    Route::delete('kategori-dumas/{id}', [KategoriDumasController::class, 'destroy'])->name('kategori_dumas.destroy');

    // ----------------- AKUN ADMIN -----------------
    Route::resource('accounts', AdminAccountController::class);
    Route::get('profile', [AuthController::class, 'profile'])->name('accounts.profile');

    // ----------------- MAPS WEB -----------------
    Route::resource('maps', WebController::class);

    // ----------------- FITUR -----------------
    Route::get('fitur', fn() => view('admin.fitur.index'))->name('fitur.index');

    // ----------------- NOTIFIKASI -----------------
    Route::get('notifikasi/baca/{id}', function ($id) {
        $notifikasi = NotifikasiAktivitas::findOrFail($id);
        $notifikasi->update(['dibaca' => true]);
        return redirect()->to($notifikasi->url ?? route('admin.dashboard'));
    })->name('notifikasi.baca.satu');
});
