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

        // 1. Validasi: Pastikan user adalah pemilik toko yang sah
        $toko = DB::table('toko')->where('id', $id_toko)->first();
        if (!$toko || $toko->id_user != $user->id) {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }

        // 2. Hitung Total Penjualan (Omzet)
        // Hanya hitung transaksi yang statusnya 'selesai' agar akurat
        $totalPenjualan = DB::table('transaksi')
            ->where('id_toko', $id_toko)
            ->where('status', 'selesai')
            ->sum('total');

        // 3. Hitung Total Pesanan (Yang berhasil/selesai)
        $totalPesanan = DB::table('transaksi')
            ->where('id_toko', $id_toko)
            ->where('status', 'selesai')
            ->count();

        // 4. Hitung Total Produk Aktif
        $totalProduk = DB::table('produk')
            ->where('id_toko', $id_toko)
            ->count();

        // 5. Hitung Data Grafik (7 Hari Terakhir)
        $grafik = [];
        // Set locale Carbon ke Indonesia agar nama hari jadi "Sen", "Sel", dst.
        Carbon::setLocale('id'); 

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dateString = $date->format('Y-m-d');
            
            // Ambil nama hari singkatan (Sen, Sel, Rab...)
            $dayName = $date->isoFormat('ddd'); 

            // Hitung total penjualan pada tanggal tersebut
            $totalHariIni = DB::table('transaksi')
                ->where('id_toko', $id_toko)
                ->where('status', 'selesai') // Hanya hitung yang selesai
                ->whereDate('created_at', $dateString)
                ->sum('total');

            $grafik[] = [
                'hari' => $dayName,      // Contoh: "Sen"
                'tanggal' => $dateString, // Contoh: "2024-11-20" (opsional, buat debug)
                'total' => (int) $totalHariIni
            ];
        }

        // 6. Kirim Respons JSON
        return response()->json([
            'status' => true,
            'data' => [
                'total_penjualan' => (int) $totalPenjualan,
                'total_pesanan' => $totalPesanan,
                'total_produk' => $totalProduk,
                'grafik' => $grafik
            ]
        ]);
    }
}