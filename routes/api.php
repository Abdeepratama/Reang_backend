<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Admin\IbadahController;
use App\Http\Controllers\Admin\DumasController;
use App\Http\Controllers\Admin\SekolahController;
use App\Http\Controllers\Admin\SehatController;
use App\Http\Controllers\admin\DashboardController;
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

// 📌 Rute API Pengaduan (tidak harus login)
Route::prefix('dumas')->group(function () {
    Route::get('/', [DumasController::class, 'index']);     // List semua
    Route::get('/{id}', [DumasController::class, 'show']);  // Detail
    Route::post('/', [DumasController::class, 'store']);    // Kirim pengaduan
    Route::put('/{id}', [DumasController::class, 'update']); // Ubah status/tanggapan
    Route::delete('/{id}', [DumasController::class, 'destroy']); // Hapus
});

// 📌 Ibadah API (contoh endpoint publik)
Route::get('/ibadah', [IbadahController::class, 'api']);

// 📌 sekolah API 
Route::post('/sekolah-aduan', [SekolahController::class, 'store']);

Route::get('/sliders', [DashboardController::class, 'apiSlider']);

Route::post('/rating', [RatingController::class, 'store']);
Route::get('/rating/{info_plesir_id}', [RatingController::class, 'show']);

// list semua lokasi sehat
Route::get('/sehat/{id?}', [SehatController::class, 'show']);      // lokasi sehat 
Route::get('/info-sehat/{id?}', [SehatController::class, 'infoshow']);    // info sehat

Route::get('/sehat-olahraga/{id?}', [SehatController::class, 'showolahraga']); // ambil semua lokasi olahraga