<?php

namespace App\Http\Controllers\Api\Plesir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiPlesir;
use App\Models\TiketPlesirUser;
use Illuminate\Support\Str;

class TransaksiAdminController extends Controller
{
    // =========================================================================
    // 1. API SAKTI: AMBIL SEMUA PESANAN MASUK (GROUPING 5 TAB)
    // =========================================================================
    public function pesananMasuk(Request $request)
    {
        // Catatan: Jika nanti sistem multi-mitra sudah jalan, 
        // kamu bisa tambahkan ->where('mitra_id', $request->user()->id) di query ini

        // A. Ambil data dari tabel TRANSAKSI (untuk Tab 1, 2, 3)
        $queryTransaksi = TransaksiPlesir::with(['user', 'wisata', 'event', 'varian'])
            ->orderBy('updated_at', 'desc');

        // B. Ambil data dari tabel TIKET DIGITAL (untuk Tab 4, 5)
        $queryTiketDigital = TiketPlesirUser::with(['transaksi.wisata', 'transaksi.event', 'transaksi.varian', 'user'])
            ->orderBy('updated_at', 'desc');

        // Kelompokkan data berdasarkan status untuk 5 Tab di Flutter
        return response()->json([
            'status' => 'success',
            'data' => [
                // Tab 1: Menunggu Pembayaran
                'pending' => (clone $queryTransaksi)->where('status_pembayaran', 'pending')->get(),

                // Tab 2: Menunggu Verifikasi
                'menunggu_verifikasi' => (clone $queryTransaksi)->where('status_pembayaran', 'menunggu_konfirmasi')->get(),

                // Tab 3: Ditolak
                'ditolak' => (clone $queryTransaksi)->where('status_pembayaran', 'ditolak')->get(),

                // Tab 4: Tiket Aktif
                'aktif' => (clone $queryTiketDigital)->where('status_tiket', 'aktif')->get(),

                // Tab 5: Sudah Digunakan
                'terpakai' => (clone $queryTiketDigital)->where('status_tiket', 'terpakai')->get(),
            ]
        ]);
    }

    // =========================================================================
    // 2. KONFIRMASI PEMBAYARAN (TERIMA / TOLAK)
    // =========================================================================
    public function konfirmasiPembayaran(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:terima,tolak',
            'keterangan' => 'nullable|string'
        ]);

        $transaksi = TransaksiPlesir::findOrFail($id);

        if ($request->status == 'tolak') {
            $transaksi->update([
                'status_pembayaran' => 'ditolak',
                'keterangan_admin' => $request->keterangan
            ]);
            return response()->json(['status' => 'success', 'message' => 'Pembayaran ditolak']);
        }

        // Jika DITERIMA: Ubah status & Generate Tiket Digital
        $transaksi->update(['status_pembayaran' => 'lunas']);

        // Generate tiket sebanyak jumlah_tiket yang dibeli
        for ($i = 0; $i < $transaksi->jumlah_tiket; $i++) {
            TiketPlesirUser::create([
                'transaksi_id' => $transaksi->id,
                'user_id' => $transaksi->user_id,
                'kode_tiket' => 'REANG-' . strtoupper(Str::random(10)),
                'status_tiket' => 'aktif'
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Pembayaran dikonfirmasi, tiket berhasil diterbitkan']);
    }

    // =========================================================================
    // 3. API SCAN TIKET (Menu Khusus Scanner Admin)
    // =========================================================================
    public function scanTiket(Request $request)
    {
        $request->validate([
            'kode_tiket' => 'required|string'
        ]);

        $tiket = TiketPlesirUser::with(['transaksi.wisata', 'transaksi.event', 'user'])
            ->where('kode_tiket', $request->kode_tiket)
            ->first();

        if (!$tiket) {
            return response()->json(['status' => 'error', 'message' => 'Tiket tidak ditemukan / Tidak Valid'], 404);
        }

        if ($tiket->status_tiket === 'terpakai') {
            return response()->json(['status' => 'error', 'message' => 'Tiket sudah pernah digunakan pada ' . $tiket->waktu_scan], 400);
        }

        if ($tiket->status_tiket === 'hangus') {
            return response()->json(['status' => 'error', 'message' => 'Tiket ini sudah hangus / kadaluarsa'], 400);
        }

        // Jika valid, ubah status jadi terpakai
        $tiket->update([
            'status_tiket' => 'terpakai',
            'waktu_scan' => now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Scan Berhasil! Tiket Valid.',
            'data' => $tiket
        ]);
    }
}
