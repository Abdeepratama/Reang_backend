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
use App\Http\Controllers\Api\TokoController;
use App\Http\Controllers\Api\MetodePembayaranController;
use App\Http\Controllers\Api\AdminPesananController;
use App\Http\Controllers\Api\AdminAnalitikController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\UlasanController;
use App\Http\Controllers\Admin\JasaPengirimanController;
// --- [BARU] Import Controller Mitra Plesir yang baru dibuat ---
use App\Http\Controllers\Api\Plesir\MitraPlesirController;
use App\Http\Controllers\Api\Plesir\TiketWisataController;
use App\Http\Controllers\Api\Plesir\TiketEventController;
use App\Http\Controllers\Api\Plesir\UserPlesirController;
use App\Http\Controllers\Api\Plesir\TransaksiUserController;
use App\Http\Controllers\Api\Plesir\TransaksiAdminController;
use App\Http\Controllers\Api\Plesir\MetodePembayaranPlesirController;
use App\Http\Controllers\Api\Plesir\NotifikasiUserController;



//panik button
Route::get('/panik', [PanikButtonController::class, 'apiIndex']);
Route::get('/panik/{id}', [PanikButtonController::class, 'apiShow']);

Route::get('/check-email', [AuthController::class, 'checkEmail']);

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

Route::post('/auth/google-callback', [App\Http\Controllers\Api\AuthController::class, 'googleCallback']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/update-profile', [App\Http\Controllers\Api\AuthController::class, 'updateProfile']);
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

    // Rating Dumas
    Route::post('/dumas/{id}/rating', [RatingDumasController::class, 'store']);
    Route::delete('/dumas/{id}/rating', [RatingDumasController::class, 'destroy']);
});


// Ibadah-yu
Route::get('/tempat-ibadah/{id?}', [IbadahController::class, 'showtempat']); // tempat ibadah
// HARUS diletakkan di atas route dengan parameter
Route::get('/tempat-ibadah/all', [IbadahController::class, 'showtempatAll']);
// baru setelah itu
Route::get('/tempat-ibadah/{id?}', [IbadahController::class, 'showtempat']);
//event agama
Route::get('/event-agama/{id?}', [IbadahController::class, 'infoshow']); //  event agama

// sekolah-yu
Route::get('/tempat-sekolah/{id?}', [SekolahController::class, 'showtempat']);
Route::get('/info-sekolah/{id?}', [SekolahController::class, 'infoshow']); // info sekolah

// slider & banner
Route::get('/slider', [DashboardController::class, 'apiSlider']);
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
Route::get('/info-plesir/fitur', [PlesirController::class, 'apiGetInfoFitur']);

// sehat-yu
Route::get('/hospital/{id?}', [SehatController::class, 'show']);      // lokasi sehat 
Route::get('/info-sehat/{id?}', [SehatController::class, 'infoshow']);    // info sehat
Route::get('/olahraga/{id?}', [SehatController::class, 'showolahraga']); // lokasi olahraga

// pajak-yu
Route::get('/info-pajak/{id?}', [PajakController::class, 'show']); //info

// Kerja-yu
Route::get('/info-kerja/{id?}', [KerjaController::class, 'infoshow']); //info

// Plesir-yu (Publik)
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
Route::get('renbang/ajuan/index', [RenbangController::class, 'apiIndex']);
Route::get('renbang/ajuan/{id}', [RenbangController::class, 'apiajuanShow'])->where('id', '[0-9]+');

// Hanya login user renbang
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

// BAGIAN 3: Rute API untuk Aksi Chat & Firebase
Route::middleware('auth:sanctum')->group(function () {
    // storage chat image
    Route::post('/chat/upload-image', [ChatImageController::class, 'upload']);

    // token dari firebase
    Route::post('/firebase/token', [FirebaseController::class, 'createCustomToken']);
    Route::post('/save-fcm-token', [FirebaseController::class, 'saveFcmToken']);
    Route::post('/chat/send-notification', [FirebaseController::class, 'sendChatNotification']);
    Route::post('/delete-fcm-token', [FirebaseController::class, 'deleteFcmToken']);
});

//toko
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/toko', [TokoController::class, 'index']);
    Route::get('/toko/{id}', [TokoController::class, 'show']);
    Route::post('/toko/store', [TokoController::class, 'store']);
    Route::put('/toko/{id}', [TokoController::class, 'update']);
    Route::delete('/toko/{id}', [TokoController::class, 'destroy']);
    Route::get('/toko/cek-kelengkapan/{id_toko}', [TokoController::class, 'cekKelengkapan']);
    Route::post('/toko/update', [TokoController::class, 'updateProfile']);
});

//Produk
Route::get('/produk/show', [ProdukController::class, 'index']);
Route::get('/produk/show/{id}', [ProdukController::class, 'show']);
Route::get('/produk/toko/{id_toko}', [ProdukController::class, 'showByToko']);
Route::get('/produk/kategori/{kategori}', [ProdukController::class, 'showByKategori']);
Route::get('/produk/suggestions', [ProdukController::class, 'getSuggestions']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/produk/store', [ProdukController::class, 'store']);      // POST tambah produk
    Route::put('/produk/update/{id}', [ProdukController::class, 'update']);  // PUT edit produk
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy']); // DELETE produk
});

//keranjang
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/keranjang/create', [KeranjangController::class, 'tambah']);
    Route::get('/keranjang/show/{id_user}', [KeranjangController::class, 'lihat']);
    Route::put('/keranjang/update/{id}', [KeranjangController::class, 'update']);
    Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus']);
});

//transaksi
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/transaksi/create', [TransaksiController::class, 'store']);
    Route::get('/transaksi/riwayat/{id_user}', [TransaksiController::class, 'riwayat']);
    Route::get('/transaksi/detail/{no_transaksi}', [TransaksiController::class, 'show']);
    Route::post('/transaksi/batalkan/{no_transaksi}', [TransaksiController::class, 'batalkan']);
    Route::post('/transaksi/selesai/{no_transaksi}', [TransaksiController::class, 'selesaikanPesanan']);
    Route::get('/transaksi/counts/{id_user}', [TransaksiController::class, 'getCounts']);
});

//Payment
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/payment/upload/{no_transaksi}', [PaymentController::class, 'uploadBukti']);
});

//ongkir
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/ongkir/{id_toko}', [OngkirController::class, 'index']);
    Route::post('/ongkir/store', [OngkirController::class, 'store']);
    Route::put('/ongkir/{id_toko}/{id}', [OngkirController::class, 'update']);
    Route::delete('/ongkir/{id_toko}/{id}', [OngkirController::class, 'destroy']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/metode', [MetodePembayaranController::class, 'index']);
    Route::get('/metode/show/{id_toko}', [MetodePembayaranController::class, 'show']);
    Route::post('/metode/create', [MetodePembayaranController::class, 'store']);
    Route::put('/metode/update/{id_toko}/{id}', [MetodePembayaranController::class, 'update']);
    Route::delete('/metode/{id_toko}/{id}', [MetodePembayaranController::class, 'destroy']);
});

Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    // 1. Mengambil semua pesanan toko
    Route::get('/pesanan/{id_toko}', [AdminPesananController::class, 'index']);
    // 2. Aksi Konfirmasi (Lunas)
    Route::post('/pesanan/konfirmasi/{no_transaksi}', [AdminPesananController::class, 'konfirmasiPembayaran']);
    Route::post('/pesanan/batalkan/{no_transaksi}', [AdminPesananController::class, 'batalkanPesanan']);
    // 3. Aksi Tolak Bukti Bayar
    Route::post('/pesanan/tolak/{no_transaksi}', [AdminPesananController::class, 'tolakPembayaran']);
    // 4. Aksi Kirim (Input Resi)
    Route::post('/pesanan/kirim/{no_transaksi}', [AdminPesananController::class, 'kirimPesanan']);
    // 5. Aksi Selesai
    Route::post('/pesanan/selesai/{no_transaksi}', [AdminPesananController::class, 'tandaiSelesai']);
    Route::get('/pesanan/counts/{id_toko}', [AdminPesananController::class, 'getCounts']);
    Route::get('/analitik/{id_toko}', [AdminAnalitikController::class, 'index']);
});

// notifications
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead']);
    Route::get('/notifications/unread-count', [NotificationController::class, 'countUnread']);
    Route::post('/notifications/delete-all', [NotificationController::class, 'deleteAll']);
});

// Ulasan Produk
Route::get('/ulasan/{id_produk}', [UlasanController::class, 'index']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/ulasan/store', [UlasanController::class, 'store']);
    Route::get('/ulasan/cek/{no_transaksi}', [UlasanController::class, 'showByTransaksi']);
});

Route::get('/jasa-pengiriman', [JasaPengirimanController::class, 'apiIndex']);

// =================================================================
// 1. ROUTE PUBLIC (TIDAK PERLU LOGIN / TANPA SANCTUM)
// =================================================================
Route::prefix('plesir')->group(function () {
    // API Explore untuk Halaman User (Bebas Akses)
    Route::get('/explore', [UserPlesirController::class, 'explore']);

    // 👇 Rute untuk mengambil metode pembayaran saat checkout/ganti metode
    Route::get('/metode-checkout', [TransaksiUserController::class, 'getMetodeForCheckout']);
});

// =======================================================================
// 2. ROUTE KHUSUS PLESIR-YU (WAJIB LOGIN / SANCTUM)
// =======================================================================
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('plesir')->group(function () {

        // --- ROUTE REGISTRASI & PROFIL MITRA ---
        Route::post('/register-mitra', [MitraPlesirController::class, 'registerMitra']);
        Route::get('/profil-mitra', [MitraPlesirController::class, 'getProfil']);
        Route::post('/update-mitra', [MitraPlesirController::class, 'updateProfil']);

        // --- ROUTE KELOLA TIKET WISATA ---
        Route::get('/mitra/tiket-ku', [TiketEventController::class, 'getTiketKu']);
        Route::post('/wisata', [TiketWisataController::class, 'createWisata']);
        Route::post('/wisata/update/{id}', [TiketWisataController::class, 'updateWisata']);
        Route::delete('/wisata/delete/{id}', [TiketWisataController::class, 'deleteWisata']);

        // --- ROUTE KELOLA TIKET EVENT ---
        Route::post('/event', [TiketEventController::class, 'createEvent']);
        Route::post('/event/update/{id}', [TiketEventController::class, 'updateEvent']);
        Route::delete('/event/delete/{id}', [TiketEventController::class, 'deleteEvent']);

        // --- TRANSAKSI USER (PEMBELI) ---
        Route::post('/checkout', [TransaksiUserController::class, 'checkout']);
        Route::post('/transaksi/{id}/upload-bukti', [TransaksiUserController::class, 'uploadBukti']);
        Route::get('/semua-tiket-ku', [TransaksiUserController::class, 'getSemuaTiketKu']);

        // 👇 PERBAIKAN: Hapus "/plesir" di depan karena sudah ada di prefix()
        Route::post('/transaksi/{id}/ganti-metode', [TransaksiUserController::class, 'gantiMetodePembayaran']);

        // --- TRANSAKSI ADMIN (MITRA) ---
        Route::get('/mitra/pesanan-masuk', [TransaksiAdminController::class, 'pesananMasuk']);
        Route::post('/mitra/transaksi/{id}/konfirmasi', [TransaksiAdminController::class, 'konfirmasiPembayaran']);
        Route::post('/mitra/scan-tiket', [TransaksiAdminController::class, 'scanTiket']);

        // --- CRUD METODE PEMBAYARAN MITRA PLESIR ---
        Route::get('/mitra/metode-pembayaran', [MetodePembayaranPlesirController::class, 'index']);
        Route::post('/mitra/metode-pembayaran', [MetodePembayaranPlesirController::class, 'store']);
        Route::post('/mitra/metode-pembayaran/{id}', [MetodePembayaranPlesirController::class, 'update']);
        Route::delete('/mitra/metode-pembayaran/{id}', [MetodePembayaranPlesirController::class, 'destroy']);

        //analitik mitra plesir
        Route::get('/mitra/analitik', [TransaksiAdminController::class, 'getAnalitik']);
        Route::post('/mitra/notifikasi/mark-read', [TransaksiAdminController::class, 'tandaiNotifDibaca']);
        Route::get('/user/notifikasi', [NotifikasiUserController::class, 'getNotifikasi']);
        Route::post('/user/notifikasi/mark-read', [NotifikasiUserController::class, 'tandaiDibaca']);
    });
});
