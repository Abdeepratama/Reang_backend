<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Admin\IbadahController;
use App\Http\Controllers\Admin\DumasController;
use App\Http\Controllers\Admin\SekolahController;
use App\Http\Controllers\Admin\SehatController;
use App\Http\Controllers\Admin\PajakController;
use App\Http\Controllers\Admin\PasarController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KerjaController;
use App\Http\Controllers\Admin\PlesirController;
use App\Http\Controllers\Admin\IzinController;
use App\Http\Controllers\Admin\RenbangController;
use App\Http\Controllers\Admin\AdmindukController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\RatingDumasController;
use App\Http\Controllers\Admin\OwnerController;
use App\Http\Controllers\Api\ChatImageController;
use App\Http\Controllers\Api\FirebaseController;
use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Admin\PuskesmasController;
use App\Http\Controllers\Admin\DokterController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ProdukController;
use App\Http\Controllers\Api\KeranjangController;
use App\Http\Controllers\Api\TransaksiController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Admin\PanikButtonController;
use App\Http\Controllers\Api\OngkirController;

// 🔐 Grup untuk autentikasi
Route::prefix('auth')->group(function () {
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::post('/signin', [AuthController::class, 'signin']);
    Route::post('/forgotpassword', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [AuthController::class, 'user']);
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::put('/profile/edit', [AuthController::class, 'updateProfile']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::middleware('auth:sanctum')->get('/check-token', function (Request $request) {
    return response()->json([
        'status' => 'valid',
        'message' => 'Token masih berlaku',
    ]);
});

Route::post('/admin/login', [AdminAuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/admin/profile', [AdminAuthController::class, 'profile']);
    Route::post('/admin/logout', [AdminAuthController::class, 'logout']);
});

// Dumas-yu
// API publik (tanpa login)
Route::get('/dumas/kategori', [DumasController::class, 'getKategori']);
Route::get('/dumas', [DumasController::class, 'publicIndex']);
Route::get('/dumas/{id}', [DumasController::class, 'publikShow']);
Route::get('/dumas/{id}/rating', [RatingDumasController::class, 'show']);

// API dengan login (auth:sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/dumas', [DumasController::class, 'store']);
    Route::put('/dumas/{id}', [DumasController::class, 'update']);
    Route::delete('/dumas/{id}', [DumasController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/dumas/{id}/rating', [RatingDumasController::class, 'store']);
    Route::delete('/dumas/{id}/rating', [RatingDumasController::class, 'destroy']);
});


// Ibadah-yu
Route::get('/tempat-ibadah/{id?}', [IbadahController::class, 'showtempat']); // tempat ibadah
Route::get('/event-agama/{id?}', [IbadahController::class, 'infoshow']); //  event agama
Route::get('/tempat-ibadah/all', [IbadahController::class, 'showtempatAll']);

// sekolah-yu
Route::get('/tempat-sekolah/{id?}', [SekolahController::class, 'showtempat']);
Route::get('/info-sekolah/{id?}', [SekolahController::class, 'infoshow']); // info sekolah

// slider
Route::get('/slider', [DashboardController::class, 'apiSlider']);

// banner
Route::get('/banner', [DashboardController::class, 'apiBanner']);

// rating
Route::post('/rating', [RatingController::class, 'store']);
Route::get('/rating/{info_plesir_id}', [RatingController::class, 'show']);
// NEW: daftar rating (paginated) untuk sebuah info_plesir
Route::get('/info-plesir/{id}/ratings', [RatingController::class, 'ratingsByInfo']);
///update
Route::put('/rating/{id}', [RatingController::class, 'update']);
//delete
Route::delete('/rating/{id}', [RatingController::class, 'destroy']);
// top plesir
Route::get('plesir/top', [RatingController::class, 'topPlesir']);
Route::get('/dumas/{id}/rating', [RatingDumasController::class, 'show']);

Route::get('/info-plesir/fitur', [PlesirController::class, 'apiGetInfoFitur']);

// sehat-yu
Route::get('/hospital/{id?}', [SehatController::class, 'show']);      // lokasi sehat 
Route::get('/info-sehat/{id?}', [SehatController::class, 'infoshow']);    // info sehat
Route::get('/olahraga/{id?}', [SehatController::class, 'showolahraga']); // lokasi olahraga

// pajak-yu
Route::get('/info-pajak/{id?}', [PajakController::class, 'show']); //info

// Kerja-yu
Route::get('/info-kerja/{id?}', [KerjaController::class, 'infoshow']); //info

// Plesir-yu
Route::get('/tempat-plesir/{id?}', [PlesirController::class, 'showtempat']);
Route::get('/info-plesir/{id?}', [PlesirController::class, 'infoshow']); //info

// Izin-yu
Route::get('/info-perizinan/{id?}', [IzinController::class, 'infoshow']); //info

// Adminduk
Route::get('/info-adminduk/{id?}', [AdmindukController::class, 'infoshow']); //info

// pasar-yu
Route::get('/tempat-pasar/{id?}', [PasarController::class, 'show']);
Route::get('/pasar/kategori', [PasarController::class, 'categories']);

//renbang-yu
//deskripsi
Route::get('/renbang/fitur', [RenbangController::class, 'apiGetFitur']);
Route::get('/renbang/{id?}', [RenbangController::class, 'apiShow']);

//ajuan
Route::get('renbang/ajuan/index', [RenbangController::class, 'apiIndex']);
Route::get('renbang/ajuan/{id}', [RenbangController::class, 'apiajuanShow'])->where('id', '[0-9]+');

// Hanya login user
Route::prefix('renbang/ajuan')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [RenbangController::class, 'apiStore']);
    Route::post('like/{id}', [RenbangController::class, 'apiToggleLike']);
    Route::get('likes/{id}', [RenbangController::class, 'apiLikes']);
});

//puskesmas
Route::prefix('puskesmas')->group(function () {
    Route::post('/login', [PuskesmasController::class, 'apiLogin']);
    Route::middleware('auth:sanctum')->get('/profile', [PuskesmasController::class, 'apiProfile']);
    Route::middleware('auth:sanctum')->post('/logout', [PuskesmasController::class, 'apiLogout']);
});

Route::get('/puskesmas', [PuskesmasController::class, 'apiIndex']);
Route::get('/puskesmas/search', [PuskesmasController::class, 'apiSearch']);
Route::get('/puskesmas/{id}', [PuskesmasController::class, 'apiShow']);
Route::get('/puskesmas/by-admin/{adminId}', [PuskesmasController::class, 'apiShowByAdmin']);

//dokter
Route::get('/dokter', [DokterController::class, 'apiIndex']);
Route::get('/dokter/{id}', [DokterController::class, 'apiShow'])->where('id', '[0-9]+');
Route::get('/dokter/by-admin/{adminId}', [DokterController::class, 'apiShowByAdmin']);



// BAGIAN 3: Rute API untuk Aksi Chat
Route::middleware('auth:sanctum')->group(function () {
    ///storage chat image
    Route::post('/chat/upload-image', [ChatImageController::class, 'upload']);
});

// token dari firebase
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/firebase/token', [FirebaseController::class, 'createCustomToken']);
    Route::post('/save-fcm-token', [FirebaseController::class, 'saveFcmToken']);
    Route::post('/chat/send-notification', [FirebaseController::class, 'sendChatNotification']);
    Route::post('/delete-fcm-token', [FirebaseController::class, 'deleteFcmToken']);
});

///storage chat image
Route::post('/chat/upload-image', [ChatImageController::class, 'upload']);

//Produk
Route::get('/', [ProdukController::class, 'index']);       // GET semua produk
Route::get('/{id}', [ProdukController::class, 'show']);    // GET 1 produk

//admin ongkir
Route::prefix('produk')->group(function () {
    Route::post('/', [ProdukController::class, 'store']);      // POST tambah produk
    Route::put('/{id}', [ProdukController::class, 'update']);  // PUT edit produk
    Route::delete('/{id}', [ProdukController::class, 'destroy']); // DELETE produk
});

//Keranjang
Route::prefix('keranjang')->group(function () {
    Route::post('/create', [KeranjangController::class, 'tambah']);
    Route::get('/{id_user}', [KeranjangController::class, 'lihat']);
});

//Transaksi
Route::prefix('transaksi')->group(function () {
    Route::get('/user/{userId}', [TransaksiController::class, 'index']);
    Route::post('/', [TransaksiController::class, 'store']);
    Route::put('/{id}', [TransaksiController::class, 'update']);
    Route::get('/transaksi/{id_user}', [TransaksiController::class, 'riwayat']);
});

//Payment
Route::prefix('payment')->group(function () {
    Route::post('/', [PaymentController::class, 'store']);
    Route::get('/{noTransaksi}', [PaymentController::class, 'show']);
    Route::get('/user/{id_user}', [PaymentController::class, 'riwayat']);
});

Route::prefix('checkout')->group(function () {
    Route::post('/', [CheckoutController::class, 'checkout']);
});

//panik button
Route::get('/panik', [PanikButtonController::class, 'apiIndex']);
Route::get('/panik/{id}', [PanikButtonController::class, 'apiShow']);

//ongkir
Route::prefix('ongkir')->group(function () {
    Route::get('/', [OngkirController::class, 'index']);
    Route::get('/show/{id}', [OngkirController::class, 'show']);
    Route::post('/store', [OngkirController::class, 'store']);
    Route::put('/update/{id}', [OngkirController::class, 'update']);
    Route::delete('/{id}', [OngkirController::class, 'destroy']);
});
