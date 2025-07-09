<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Admin\IbadahController;
use App\Http\Controllers\Admin\PengaduanController;

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
Route::prefix('pengaduan')->group(function () {
    Route::get('/', [PengaduanController::class, 'index']);     // List semua
    Route::get('/{id}', [PengaduanController::class, 'show']);  // Detail
    Route::post('/', [PengaduanController::class, 'store']);    // Kirim pengaduan
    Route::put('/{id}', [PengaduanController::class, 'update']); // Ubah status/tanggapan
    Route::delete('/{id}', [PengaduanController::class, 'destroy']); // Hapus
});

// 📌 Ibadah API (contoh endpoint publik)
Route::get('/ibadah', [IbadahController::class, 'api']);
