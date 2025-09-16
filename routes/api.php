<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Admin\IbadahController;
use App\Http\Controllers\Admin\DumasController;
use App\Http\Controllers\Admin\SekolahController;
use App\Http\Controllers\Admin\SehatController;
use App\Http\Controllers\Admin\PajakController;
use App\Http\Controllers\Admin\PasarController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\Admin\KerjaController;
use App\Http\Controllers\Admin\PlesirController;
use App\Http\Controllers\Admin\IzinController;
use App\Http\Controllers\Admin\RenbangController;
use App\Http\Controllers\Admin\AdmindukController;
use App\Http\Controllers\Api\RatingController;

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

// Dumas-yu
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dumas', [DumasController::class, 'index']);
    Route::get('/dumas/{id}', [DumasController::class, 'show']);
    Route::post('/dumas', [DumasController::class, 'store']);
    Route::put('/dumas/{id}', [DumasController::class, 'update']);
    Route::delete('/dumas/{id}', [DumasController::class, 'destroy']);
});

// Ibadah-yu
Route::get('/tempat-ibadah/{id?}', [IbadahController::class, 'showtempat']); // tempat ibadah
Route::get('/event-agama/{id?}', [IbadahController::class, 'infoshow']); //  event agama

// sekolah-yu
Route::get('/tempat-sekolah/{id?}', [SekolahController::class, 'showtempat']);
Route::get('/info-sekolah/{id?}', [SekolahController::class, 'infoshow']); // info sekolah

// slider
Route::get('/sliders', [DashboardController::class, 'apiSlider']);

// rating
Route::post('/rating', [RatingController::class, 'store']);
Route::get('/rating/{info_plesir_id}', [RatingController::class, 'show']); 
// NEW: daftar rating (paginated) untuk sebuah info_plesir
Route::get('/info-plesir/{id}/ratings', [RatingController::class, 'ratingsByInfo']);
///update
Route::put('/rating/{id}', [RatingController::class,'update']);

// sehat-yu
Route::get('/hospital/{id?}', [SehatController::class, 'show']);      // lokasi sehat 
Route::get('/info-sehat/{id?}', [SehatController::class, 'infoshow']);    // info sehat
Route::get('/sehat-olahraga/{id?}', [SehatController::class, 'showolahraga']); // lokasi olahraga

// pajak-yu
Route::get('/info-pajak/{id?}', [PajakController::class, 'infoshow']); //info

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

//renbang-yu
Route::get('/deskripsi-renbang/{id?}', [RenbangController::class, 'deskripsishow']);