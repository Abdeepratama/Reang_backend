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
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Admin\PuskesmasController;
use App\Http\Controllers\Admin\DokterController;
use Illuminate\Http\Request;

// 🔐 Grup untuk autentikasi
Route::prefix('auth')->group(function () {
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::post('/signin', [AuthController::class, 'signin']);
    Route::post('/forgotpassword', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [AuthController::class, 'user']);
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
Route::get('/renbang/fitur', [RenbangController::class, 'apiGetFitur']);
Route::get('/renbang/{id?}', [RenbangController::class, 'apiShow']);

// puskesmas
Route::get('/puskesmas', [PuskesmasController::class, 'apiIndex']);
Route::get('/puskesmas/search', [PuskesmasController::class, 'apiSearch']);
Route::get('/puskesmas/{id}', [PuskesmasController::class, 'apiShow']);

//dokter
Route::get('/dokter', [DokterController::class, 'apiIndex']);
Route::get('/dokter/{id?}', [DokterController::class, 'apiShow']);

//chat
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/chat/send', [ChatController::class, 'sendMessage']);
    Route::get('/chat/{user_id}', [ChatController::class, 'getMessages']);
});

Route::middleware('auth:admin')->group(function () {
    Route::get('/chat', [ChatController::class, 'index']);
});

// untuk user login (lihat chat dengan dokter tertentu)
Route::middleware('auth:sanctum')->get('/chat/{dokter_id}', [ChatController::class, 'getMessages']);

Route::middleware('auth:sanctum')->get('/dokter/chats', [ChatController::class, 'getAllMessagesForDokter']);
