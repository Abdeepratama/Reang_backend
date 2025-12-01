<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminAnalitikController extends Controller
{
    /**
     * GET: /api/admin/analitik/{id_toko}
     */
    public function index(Request $request, $id_toko)
    {
        $user = $request->user();

        // 1. Validasi
        $toko = DB::table('toko')->where('id', $id_toko)->first();
        if (!$toko || $toko->id_user != $user->id) {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }

        // 2. Data Dasar
        $totalPenjualan = DB::table('transaksi')
            ->where('id_toko', $id_toko)
            ->where('status', 'selesai')
            ->sum('total');

        $totalPesanan = DB::table('transaksi')
            ->where('id_toko', $id_toko)
            ->where('status', 'selesai')
            ->count();

        $totalProduk = DB::table('produk')->where('id_toko', $id_toko)->count();

        // 3. [BARU] Hitung Ulasan & Rating Toko
        // Ambil semua ID produk milik toko ini
        $productIds = DB::table('produk')->where('id_toko', $id_toko)->pluck('id');

        // Hitung ulasan berdasarkan produk-produk tersebut
        $totalUlasan = DB::table('ulasan')->whereIn('id_produk', $productIds)->count();
        $ratingToko  = DB::table('ulasan')->whereIn('id_produk', $productIds)->avg('rating');

        // 4. Grafik (Tetap sama)
        $grafik = [];
        Carbon::setLocale('id'); 
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dateString = $date->format('Y-m-d');
            $dayName = $date->isoFormat('ddd'); 

            $totalHariIni = DB::table('transaksi')
                ->where('id_toko', $id_toko)
                ->where('status', 'selesai')
                ->whereDate('created_at', $dateString)
                ->sum('total');

            $grafik[] = [
                'hari' => $dayName,
                'tanggal' => $dateString,
                'total' => (int) $totalHariIni
            ];
        }

        return response()->json([
            'status' => true,
            'data' => [
                'total_penjualan' => (int) $totalPenjualan,
                'total_pesanan' => $totalPesanan,
                'total_produk'  => $totalProduk,
                'total_ulasan'  => $totalUlasan, // [BARU]
                'rating_toko'   => round($ratingToko, 1), // [BARU] (Misal 4.5)
                'grafik'        => $grafik
            ]
        ]);
    }
    
}