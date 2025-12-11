<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\IbadahController;
use App\Http\Controllers\Admin\SehatController;
use App\Http\Controllers\Admin\PuskesmasController;
use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Admin\PasarController;
use App\Http\Controllers\Admin\PlesirController;
use App\Http\Controllers\Admin\DumasController;
use App\Http\Controllers\Admin\SekolahController;
use App\Http\Controllers\Admin\InfoController;
use App\Http\Controllers\Admin\PajakController;
use App\Http\Controllers\Admin\KerjaController;
use App\Http\Controllers\Admin\AdmindukController;
use App\Http\Controllers\Admin\RenbangController;
use App\Http\Controllers\Admin\OwnerController;
use App\Http\Controllers\Admin\IzinController;
use App\Http\Controllers\Admin\WifiController;
use App\Http\Controllers\Admin\WebController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\KategoriDumasController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CaptchaController;
use App\Http\Controllers\Admin\AdminAccountController;
use App\Http\Controllers\Admin\PanikButtonController;
use App\Http\Controllers\Admin\UmkmController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\Admin\JasaPengirimanController;

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
});

Route::prefix('admin')->group(function () {
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])
        ->middleware('auth:admin')
        ->name('admin.logout');
});

// ----------------- ROUTE ADMIN -----------------
Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/info', [InfoController::class, 'index'])->name('info.index');

    // ----------------- IBADAH -----------------
    Route::middleware('auth:admin')->prefix('ibadah')->name('ibadah.')->group(function () {
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
        Route::get('/info/edit/{id}', [IbadahController::class, 'infoEdit'])->name('info.edit');
        Route::put('/info/{id}', [IbadahController::class, 'infoUpdate'])->name('info.update');
        Route::delete('/info/{id}', [IbadahController::class, 'infoDestroy'])->name('info.destroy');
        Route::get('/info/show/{id}', [IbadahController::class, 'infoshowDetail'])->name('info.show');
    });


    // ----------------- PASAR -----------------
    Route::middleware('auth:admin')->prefix('pasar')->name('pasar.')->group(function () {

        // Tambahan (HARUS DILETAKKAN DI ATAS)
        Route::get('tempat/map', [PasarController::class, 'map'])->name('tempat.map');
        Route::post('tempat/simpan-lokasi', [PasarController::class, 'simpanLokasi'])->name('tempat.simpan');
        Route::post('tempat/upload-image', [PasarController::class, 'upload'])->name('tempat.upload');

        // CRUD Tempat
        Route::get('tempat', [PasarController::class, 'tempat'])->name('tempat.index');
        Route::get('tempat/create', [PasarController::class, 'create'])->name('tempat.create');
        Route::post('tempat', [PasarController::class, 'store'])->name('tempat.store');
        Route::get('tempat/{id}/edit', [PasarController::class, 'edit'])->name('tempat.edit');
        Route::put('tempat/{id}', [PasarController::class, 'update'])->name('tempat.update');
        Route::delete('tempat/{id}', [PasarController::class, 'destroy'])->name('tempat.destroy');
        Route::get('tempat/{id}', [PasarController::class, 'showTempatWeb'])->name('tempat.show');
    });

    // ----------------- PLESIR -----------------
    Route::middleware('auth:admin')->prefix('plesir')->name('plesir.')->group(function () {
        // CRUD Tempat
        Route::get('/tempat', [PlesirController::class, 'tempat'])->name('tempat.index');
        Route::get('/tempat/map', [PlesirController::class, 'map'])->name('tempat.map');
        Route::get('/tempat/create', [PlesirController::class, 'create'])->name('tempat.create');
        Route::post('/tempat/store', [PlesirController::class, 'store'])->name('tempat.store');
        Route::get('/tempat/edit/{id}', [PlesirController::class, 'Edit'])->name('tempat.edit');
        Route::put('/tempat/update/{id}', [PlesirController::class, 'Update'])->name('tempat.update');
        Route::delete('/tempat/destroy/{id}', [PlesirController::class, 'Destroy'])->name('tempat.destroy');
        Route::get('/tempat/{id}', [PlesirController::class, 'showTempatWeb'])->name('tempat.show');

        // CRUD Info
        Route::get('/tempat/info-map', [PlesirController::class, 'infomap'])->name('info.map');
        Route::get('/info', [PlesirController::class, 'info'])->name('info.index');
        Route::get('/info/create', [PlesirController::class, 'createInfo'])->name('info.create');
        Route::post('/store', [PlesirController::class, 'storeInfo'])->name('info.store');
        Route::get('/edit/{id}', [PlesirController::class, 'infoEdit'])->name('info.edit');
        Route::put('/update/{id}', [PlesirController::class, 'infoUpdate'])->name('info.update');
        Route::delete('/destroy/{id}', [PlesirController::class, 'infoDestroy'])->name('info.destroy');
        Route::get('/show/{id}', [PlesirController::class, 'infoshowDetail'])->name('info.show');
    });

    // ----------------- SEHAT -----------------
    Route::middleware('auth:admin')->prefix('sehat')->name('sehat.')->group(function () {

        // 📍 Lokasi Sehat
        Route::get('/tempat', [SehatController::class, 'tempat'])->name('tempat.index');
        Route::get('/tempat/create', [SehatController::class, 'create'])->name('tempat.create');
        Route::post('/tempat/store', [SehatController::class, 'store'])->name('tempat.store');
        Route::get('/tempat/edit/{id}', [SehatController::class, 'edit'])->name('tempat.edit');
        Route::put('/tempat/update/{id}', [SehatController::class, 'update'])->name('tempat.update');
        Route::get('/tempat/map', [SehatController::class, 'map'])->name('tempat.map');
        Route::delete('/tempat/{id}', [SehatController::class, 'destroy'])->name('tempat.destroy');
        Route::get('/tempat/{id}', [SehatController::class, 'showTempatWeb'])->name('tempat.show');

        // 🩺 Info Sehat
        Route::get('/info', [SehatController::class, 'infoindex'])->name('info.index');
        Route::get('/info/create', [SehatController::class, 'infocreate'])->name('info.create');
        Route::post('/info/store', [SehatController::class, 'infostore'])->name('info.store');
        Route::get('/info/edit/{id}', [SehatController::class, 'infoedit'])->name('info.edit');
        Route::put('/info/update/{id}', [SehatController::class, 'infoupdate'])->name('info.update');
        Route::get('/info/show/{id}', [SehatController::class, 'infoshowAdmin'])->name('info.show');
        Route::delete('/info/destroy/{id}', [SehatController::class, 'infodestroy'])->name('info.destroy');
        Route::post('/upload-image', [SehatController::class, 'upload'])->name('info.upload.image');
    });

    // ----------------- OLAHRAGA -----------------
    Route::middleware('auth:admin')->prefix('olahraga')->name('sehat.olahraga.')->group(function () {
        Route::get('/', [SehatController::class, 'indexolahraga'])->name('index');
        Route::get('/tempat/create', [SehatController::class, 'createolahraga'])->name('create');
        Route::post('/tempat/store', [SehatController::class, 'storeolahraga'])->name('store');
        Route::get('/tempat/edit/{id}', [SehatController::class, 'editolahraga'])->name('edit');
        Route::put('/tempat/update/{id}', [SehatController::class, 'updateolahraga'])->name('update');
        Route::delete('/tempat/delete/{id}', [SehatController::class, 'destroyolahraga'])->name('destroy');
        Route::get('/tempat/map', [SehatController::class, 'mapolahraga'])->name('map');
        Route::get('/tempat/{id}', [SehatController::class, 'showOlahragaWeb'])->name('show');
    });


    //------------------PUSKESMAS------------------
    Route::middleware('auth:admin')->prefix('puskesmas')->name('sehat.puskesmas.')->group(function () {
        Route::get('/', [PuskesmasController::class, 'index'])->name('index');
        Route::get('/create', [PuskesmasController::class, 'create'])->name('create');
        Route::get('/map', [PuskesmasController::class, 'map'])->name('map');
        Route::post('/store', [PuskesmasController::class, 'store'])->name('store');
        Route::get('/edit/{puskesmas}', [PuskesmasController::class, 'edit'])->name('edit');
        Route::put('/update/{puskesmas}', [PuskesmasController::class, 'update'])->name('update');
        Route::delete('/delete/{puskesmas}', [PuskesmasController::class, 'destroy'])->name('destroy');
    });

    //------------------Dokter----------------------
    Route::prefix('dokter')->name('sehat.dokter.')->group(function () {
        Route::get('/', [DokterController::class, 'index'])->name('index');
        Route::get('/create', [DokterController::class, 'create'])->name('create');
        Route::post('/store', [DokterController::class, 'store'])->name('store');
        Route::get('/edit/{dokter}', [DokterController::class, 'edit'])->name('edit');
        Route::put('/update/{dokter}', [DokterController::class, 'update'])->name('update');
        Route::delete('/delete/{dokter}', [DokterController::class, 'destroy'])->name('destroy');
    });

    // ----------------- PAJAK -----------------
    Route::middleware('auth:admin')->prefix('pajak')->name('pajak.')->group(function () {
        Route::resource('info', PajakController::class)->except(['show']);
        Route::post('info/upload-image', [PajakController::class, 'infoupload'])->name('info.upload.image');
        Route::get('info/show/{id}', [PajakController::class, 'showDetail'])->name('info.show');
    });

    // ----------------- KERJA -----------------
    // ----------------- KERJA -----------------
    Route::middleware('auth:admin')->prefix('kerja')->name('kerja.')->group(function () {
        // Info Kerja
        Route::get('info', [KerjaController::class, 'infoindex'])->name('info.index');
        Route::get('info/create', [KerjaController::class, 'infocreate'])->name('info.create');
        Route::post('info', [KerjaController::class, 'infostore'])->name('info.store');
        Route::get('info/edit/{id}', [KerjaController::class, 'infoedit'])->name('info.edit');
        Route::put('info/{id}', [KerjaController::class, 'infoupdate'])->name('info.update');
        Route::delete('info/{id}', [KerjaController::class, 'infodestroy'])->name('info.destroy');
        Route::get('info/show/{id}', [KerjaController::class, 'infoshowdetail'])->name('info.show');

        // Upload image (ckeditor atau summernote)
        Route::post('info/upload-image', [KerjaController::class, 'upload'])->name('info.upload.image');
    });

    // ----------------- ADMINDUK -----------------
    Route::middleware('auth:admin')->prefix('adminduk')->name('adminduk.')->group(function () {
        // INFO ADMIN DUK
        Route::get('info', [AdmindukController::class, 'infoindex'])->name('info.index');
        Route::get('info/create', [AdmindukController::class, 'infocreate'])->name('info.create');
        Route::post('info', [AdmindukController::class, 'infostore'])->name('info.store');
        Route::get('info/edit/{id}', [AdmindukController::class, 'infoedit'])->name('info.edit');
        Route::put('info/{id}', [AdmindukController::class, 'infoupdate'])->name('info.update');
        Route::delete('info/{id}', [AdmindukController::class, 'infodestroy'])->name('info.destroy');
        Route::get('info/show/{id}', [AdmindukController::class, 'infoshowDetail'])->name('info.show');

        // Upload untuk CKEditor
        Route::post('info/upload-image', [AdmindukController::class, 'infoupload'])->name('info.upload.image');
    });

    // ----------------- RENBANG -----------------
    Route::middleware('auth:admin')->prefix('renbang')->name('renbang.')->group(function () {
        // DESKRIPSI RENBANG
        Route::get('Renbang/Info', [RenbangController::class, 'infoIndex'])->name('info.index');
        Route::get('Renbang/Info/create', [RenbangController::class, 'infoCreate'])->name('info.create');
        Route::post('Renbang/Info', [RenbangController::class, 'infoStore'])->name('info.store');
        Route::get('Renbang/Info/edit/{id}', [RenbangController::class, 'infoEdit'])->name('info.edit');
        Route::put('Renbang/Info/{id}', [RenbangController::class, 'infoUpdate'])->name('info.update');
        Route::delete('Renbang/Info/{id}', [RenbangController::class, 'infoDestroy'])->name('info.destroy');
        Route::get('Renbang/Info/show/{id}', [RenbangController::class, 'infoshowDetail'])->name('info.show');

        // Upload gambar (CKEditor)
        Route::post('Info/upload-image', [RenbangController::class, 'infoUpload'])->name('info.upload.image');
    });

    // ----------------- RENBANG - AJUAN -----------------
    Route::middleware('auth:admin')->prefix('renbang/ajuan')->name('renbang.ajuan.')->group(function () {
        Route::get('/', [RenbangController::class, 'index'])->name('index');
        Route::get('/{id}', [RenbangController::class, 'show'])->name('show');
        Route::put('/{id}', [RenbangController::class, 'update'])->name('update');
        Route::delete('/{id}', [RenbangController::class, 'destroy'])->name('destroy');
    });

    // ----------------- DUMAS -----------------
    Route::middleware('auth:admin')->prefix('dumas')->name('dumas.')->group(function () {

        // Resource (tanpa show, create, store)
        Route::resource('aduan', DumasController::class)->except(['show', 'create', 'store']);

        // Show
        Route::get('aduan/{id}', [DumasController::class, 'show'])->name('aduan.show');

        Route::post('aduan/{id}/update-status', [DumasController::class, 'updateStatus'])->name('aduan.update.status');

        Route::post('/dumas/aduan/{id}/update-instansi', [DumasController::class, 'updateInstansi'])->name('aduan.update.instansi');


        Route::post('aduan/{id}/update-tanggapan-foto', [DumasController::class, 'updateTanggapanFoto'])->name('aduan.update.tanggapan_foto');
    });

    // ----------------- IZIN -----------------
    Route::middleware('auth:admin')->prefix('izin')->name('izin.')->group(function () {
        // CRUD Info Perizinan
        Route::get('info', [IzinController::class, 'infoindex'])->name('info.index');
        Route::get('info/create', [IzinController::class, 'infocreate'])->name('info.create');
        Route::post('info', [IzinController::class, 'infostore'])->name('info.store');
        Route::get('info/edit/{id}', [IzinController::class, 'infoedit'])->name('info.edit');
        Route::put('info/{id}', [IzinController::class, 'infoupdate'])->name('info.update');
        Route::delete('info/{id}', [IzinController::class, 'infodestroy'])->name('info.destroy');
        Route::get('info/show/{id}', [IzinController::class, 'infoshowDetail'])->name('info.show');

        // Upload gambar (CKEditor)
        Route::post('info/upload-image', [IzinController::class, 'upload'])->name('info.upload.image');
    });

    // ----------------- WIFI -----------------
    Route::get('wifi', [WifiController::class, 'index'])->name('wifi.index');

    // ----------------- SLIDER -----------------
    Route::prefix('admin/slider')
        ->name('slider.')
        ->middleware(['auth:admin'])
        ->group(function () {
            Route::get('/', [DashboardController::class, 'sliderIndex'])->name('index');
            Route::get('/create', [DashboardController::class, 'sliderCreate'])->name('create');
            Route::post('/store', [DashboardController::class, 'sliderStore'])->name('store');
            Route::get('/{id}/edit', [DashboardController::class, 'sliderEdit'])->name('edit');
            Route::put('/{id}/update', [DashboardController::class, 'sliderUpdate'])->name('update');
            Route::delete('/{id}/destroy', [DashboardController::class, 'sliderDestroy'])->name('destroy');
        });

    // ------------------ BANNER -------------------
    Route::prefix('admin/banner')
        ->name('banner.')
        ->middleware(['auth:admin'])
        ->group(function () {
            Route::get('/banner', [DashboardController::class, 'bannerIndex'])->name('index');
            Route::get('/banner/create', [DashboardController::class, 'bannerCreate'])->name('create');
            Route::post('/banner', [DashboardController::class, 'bannerStore'])->name('store');
            Route::get('/banner/{id}/edit', [DashboardController::class, 'bannerEdit'])->name('edit');
            Route::put('/banner/{id}', [DashboardController::class, 'bannerUpdate'])->name('update');
            Route::delete('/banner/{id}', [DashboardController::class, 'bannerDestroy'])->name('destroy');
            Route::post('info/upload-image', [DashboardController::class, 'uploadBanner'])->name('upload.image');
        });

    // ----------------- SEKOLAH -----------------
    Route::prefix('sekolah')
        ->name('sekolah.')
        ->middleware(['auth:admin'])
        ->group(function () {
            Route::get('tempat', [SekolahController::class, 'indexTempat'])->name('tempat.index');
            Route::get('tempat/create', [SekolahController::class, 'createTempat'])->name('tempat.create');
            Route::post('tempat', [SekolahController::class, 'storeTempat'])->name('tempat.store');
            Route::get('tempat/{id}/edit', [SekolahController::class, 'editTempat'])->name('tempat.edit');
            Route::put('tempat/{id}', [SekolahController::class, 'updateTempat'])->name('tempat.update');
            Route::delete('tempat/{id}', [SekolahController::class, 'destroyTempat'])->name('tempat.destroy');
            Route::get('tempat/map', [SekolahController::class, 'mapTempat'])->name('tempat.map');
            Route::get('tempat/{id}', [SekolahController::class, 'showTempatWeb'])->name('tempat.show');

            Route::get('info', [SekolahController::class, 'infoindex'])->name('info.index');
            Route::get('info/create', [SekolahController::class, 'infocreate'])->name('info.create');
            Route::post('info', [SekolahController::class, 'infostore'])->name('info.store');
            Route::get('info/edit/{id}', [SekolahController::class, 'infoedit'])->name('info.edit');
            Route::put('info/{id}', [SekolahController::class, 'infoupdate'])->name('info.update');
            Route::get('info/show/{id}', [SekolahController::class, 'infoshowDetail'])->name('info.show');
            Route::delete('info/{id}', [SekolahController::class, 'infodestroy'])->name('info.destroy');
            Route::post('info/upload-image', [SekolahController::class, 'infoupload'])->name('info.upload.image');
        });

    // ----------------- SETTING -----------------
    Route::get('setting', [SettingController::class, 'index'])
        ->name('setting.index');

    // ----------------- KATEGORI -----------------
    Route::prefix('kategori')->name('kategori.')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('index');
        Route::get('/create', [KategoriController::class, 'create'])->name('create');
        Route::post('/store', [KategoriController::class, 'store'])->name('store');

        Route::get('/edit/{kategori}', [KategoriController::class, 'edit'])->name('edit');
        Route::put('/update/{kategori}', [KategoriController::class, 'update'])->name('update');

        Route::delete('/delete/{kategori}', [KategoriController::class, 'destroy'])->name('destroy');
    });

    // ----------------- KATEGORI DUMAS -----------------
    Route::prefix('kategori-dumas')
        ->name('kategori_dumas.')
        ->group(function () {
            Route::get('/', [KategoriDumasController::class, 'index'])->name('index');
            Route::get('/create', [KategoriDumasController::class, 'create'])->name('create');
            Route::post('/store', [KategoriDumasController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [KategoriDumasController::class, 'edit'])->name('edit');
            Route::put('/{id}', [KategoriDumasController::class, 'update'])->name('update');
            Route::delete('/{id}', [KategoriDumasController::class, 'destroy'])->name('destroy');
        });

    // ----------------- AKUN ADMIN -----------------
    Route::resource('accounts', AdminAccountController::class)
        ->middleware(['auth:admin']);
    Route::get('profile', [AuthController::class, 'profile'])
        ->middleware(['auth:admin'])
        ->name('accounts.profile');

    // ----------------- MAPS WEB -----------------
    Route::resource('maps', WebController::class)
        ->middleware(['auth:admin']);

    Route::get('fitur', fn() => view('admin.fitur.index'))
        ->middleware(['auth:admin'])
        ->name('fitur.index');

    // ----------------- NOTIFIKASI -----------------
    Route::get('notifikasi/baca/{id}', function ($id) {
        $user = auth('admin')->user();
        $userData = $user->userData;
        $notifikasi = \App\Models\NotifikasiAktivitas::findOrFail($id);

        if (
            $user->role === 'superadmin' ||
            ($user->role === 'admindinas' && $notifikasi->id_instansi == $userData?->id_instansi) ||
            ($user->role === 'adminpuskesmas' && $notifikasi->id_puskesmas == $userData?->id_puskesmas)
        ) {
            $notifikasi->update(['dibaca' => true]);
            return redirect()->to($notifikasi->url ?? route('admin.dashboard'));
        }

        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    })
        ->middleware(['auth:admin'])
        ->name('notifikasi.baca.satu');
});

// panik botton
Route::middleware('auth:admin')->prefix('admin/panik')->name('admin.panik.')->group(function () {
    Route::get('/', [PanikButtonController::class, 'index'])->name('index');
    Route::get('/create', [PanikButtonController::class, 'create'])->name('create');
    Route::post('/', [PanikButtonController::class, 'store'])->name('store');
    Route::get('/{panik}/edit', [PanikButtonController::class, 'edit'])->name('edit');
    Route::put('/{panik}', [PanikButtonController::class, 'update'])->name('update');
    Route::delete('/{panik}', [PanikButtonController::class, 'destroy'])->name('destroy');
});

// jasa pengiriman
Route::middleware('auth:admin')->prefix('admin/jasa')->name('admin.jasa.')->group(function () {
    Route::get('/', [JasaPengirimanController::class, 'index'])->name('index');
    Route::get('/create', [JasaPengirimanController::class, 'create'])->name('create');
    Route::post('/', [JasaPengirimanController::class, 'store'])->name('store');
    Route::get('/{jasa}/edit', [JasaPengirimanController::class, 'edit'])->name('edit');
    Route::put('/{jasa}', [JasaPengirimanController::class, 'update'])->name('update');
    Route::delete('/{jasa}', [JasaPengirimanController::class, 'destroy'])->name('destroy');
});

// ----------------- RESET PASSWORD user -----------------
// 1. Route untuk Menampilkan Form (Diklik dari Email)
Route::get('/reset-password/{token}', function (Request $request, $token) {
    return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
})->name('password.reset');

// 2. Route untuk Memproses Reset (Saat tombol 'Ubah Password' ditekan)
Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($user));
        }
    );

    if ($status === Password::PASSWORD_RESET) {
        return back()->with('status', 'Password berhasil diubah! Silakan kembali ke aplikasi.');
    }

    return back()->withErrors(['email' => [($status)]]);
})->name('password.update');
