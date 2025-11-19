<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminPesananController extends Controller
{

    /**
     * GET: /api/admin/pesanan/{id_toko}
     * (Fungsi ini sudah benar dan tidak perlu diubah)
     */
    public function index(Request $request, $id_toko) 
    {
        $user = $request->user();

        $toko = DB::table('toko')->where('id', $id_toko)->first();
        if (!$toko || $toko->id_user != $user->id) { 
            return response()->json(['message' => 'Akses ditolak. Anda bukan pemilik toko ini.'], 403);
        }

        $pesanan = DB::table('transaksi')
            ->join('users', 'transaksi.id_user', '=', 'users.id')
            ->leftJoin('payment', 'transaksi.no_transaksi', '=', 'payment.no_transaksi')
            ->where('transaksi.id_toko', $id_toko)
            ->select(
                'transaksi.no_transaksi',
                DB::raw("CASE 
                    WHEN payment.status_pembayaran = 'menunggu_konfirmasi' THEN 'menunggu_konfirmasi'
                    WHEN payment.status_pembayaran = 'ditolak' THEN 'menunggu_pembayaran' 
                    ELSE transaksi.status 
                END as status"),
                'transaksi.total',
                'transaksi.jumlah',
                'transaksi.created_at',
                'transaksi.jasa_pengiriman',
                'transaksi.nomor_resi',
                'users.name as nama_pemesan',
                'payment.status_pembayaran',
                'payment.metode_pembayaran'
            )
            ->orderBy('transaksi.created_at', 'desc')
            ->get();

        if ($pesanan->isEmpty()) {
            return response()->json([], 200); 
        }

        foreach ($pesanan as $order) {
            $first_item = DB::table('detail_transaksi')
                ->join('produk', 'detail_transaksi.id_produk', '=', 'produk.id')
                ->where('detail_transaksi.no_transaksi', $order->no_transaksi)
                ->select('produk.foto', 'produk.nama')
                ->first();

            $order->nama_produk_utama = $first_item->nama ?? 'Produk Dihapus';
            $order->foto_produk = $this->formatFotoUrl($first_item->foto ?? null);
        }

        return response()->json($pesanan);
    }
    
    // =========================================================================
    // [PERBAIKAN LOGIKA DI FUNGSI AKSI]
    // =========================================================================

    /**
     * [PERBAIKAN 1 - FUNGSI KONFIRMASI]
     * POST: /api/admin/pesanan/konfirmasi/{no_transaksi}
     */
    public function konfirmasiPembayaran(Request $request, $no_transaksi)
    {
        $user = $request->user();

        // 1. Cek Transaksi & Payment (Gabung)
        $payment = DB::table('payment')
            ->join('transaksi', 'payment.no_transaksi', '=', 'transaksi.no_transaksi')
            ->where('payment.no_transaksi', $no_transaksi)
            ->select('payment.status_pembayaran', 'transaksi.id_toko')
            ->first();

        if (!$payment) {
            return response()->json(['message' => 'Pesanan tidak ditemukan.'], 404);
        }

        // 2. Validasi Kepemilikan Toko
        $toko = DB::table('toko')->where('id', $payment->id_toko)->first();
        if (!$toko || $toko->id_user != $user->id) {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }

        // 3. [PERBAIKAN UTAMA] Cek status dari tabel 'payment', bukan 'transaksi'
        if ($payment->status_pembayaran != 'menunggu_konfirmasi') {
             return response()->json(['message' => 'Status pesanan ini tidak sedang menunggu konfirmasi.'], 422);
        }

        DB::beginTransaction();
        try {
            // 1. Update status transaksi -> 'diproses' (Siap Dikemas)
            DB::table('transaksi')
                ->where('no_transaksi', $no_transaksi)
                ->update([
                    'status' => 'diproses',
                    'updated_at' => Carbon::now()
                ]);
            
            // 2. Update status payment -> 'lunas'
            DB::table('payment')
                ->where('no_transaksi', $no_transaksi)
                ->update([
                    'status_pembayaran' => 'lunas',
                    'updated_at' => Carbon::now()
                ]);

            DB::commit();
            return response()->json(['message' => 'Pembayaran berhasil dikonfirmasi. Pesanan siap dikemas.']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal mengonfirmasi pembayaran: ' . $e->getMessage()], 500);
        }
    }

    /**
     * [PERBAIKAN 2 - FUNGSI TOLAK]
     * POST: /api/admin/pesanan/tolak/{no_transaksi}
     */
    public function tolakPembayaran(Request $request, $no_transaksi)
    {
        $user = $request->user();

        // 1. Cek Transaksi & Payment (Gabung)
        $payment = DB::table('payment')
            ->join('transaksi', 'payment.no_transaksi', '=', 'transaksi.no_transaksi')
            ->where('payment.no_transaksi', $no_transaksi)
            ->select('payment.status_pembayaran', 'payment.bukti_pembayaran', 'transaksi.id_toko')
            ->first();

        if (!$payment) {
            return response()->json(['message' => 'Pesanan tidak ditemukan.'], 404);
        }

        // 2. Validasi Kepemilikan Toko
        $toko = DB::table('toko')->where('id', $payment->id_toko)->first();
        if (!$toko || $toko->id_user != $user->id) {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }
        
        // 3. [PERBAIKAN UTAMA] Cek status dari tabel 'payment'
        if ($payment->status_pembayaran != 'menunggu_konfirmasi') {
             return response()->json(['message' => 'Status pesanan ini tidak sedang menunggu konfirmasi.'], 422);
        }

        DB::beginTransaction();
        try {
            $this->hapusFileStorage($payment->bukti_pembayaran);

            DB::table('transaksi')
                ->where('no_transaksi', $no_transaksi)
                ->update([
                    'status' => 'menunggu_pembayaran',
                    'updated_at' => Carbon::now()
                ]);
            
            DB::table('payment')
                ->where('no_transaksi', $no_transaksi)
                ->update([
                    'status_pembayaran' => 'ditolak',
                    'bukti_pembayaran' => 'ditolak', 
                    'updated_at' => Carbon::now()
                ]);

            DB::commit();
            return response()->json(['message' => 'Bukti pembayaran ditolak. Menunggu pelanggan mengupload ulang.']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal menolak pembayaran: ' . $e->getMessage()], 500);
        }
    }

    /**
     * [PERBAIKAN 3 - FUNGSI KIRIM]
     * POST: /api/admin/pesanan/kirim/{no_transaksi}
     */
    public function kirimPesanan(Request $request, $no_transaksi)
    {
        $validated = $request->validate([
            'nomor_resi' => 'required|string|max:255'
        ]);
        
        $user = $request->user();

        // 1. Cek Transaksi
        $transaksi = DB::table('transaksi')
            ->where('no_transaksi', $no_transaksi)
            ->first();

        if (!$transaksi) {
            return response()->json(['message' => 'Pesanan tidak ditemukan.'], 404);
        }

        // 2. Validasi Kepemilikan Toko
        $toko = DB::table('toko')->where('id', $transaksi->id_toko)->first();
        if (!$toko || $toko->id_user != $user->id) {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }
        
        // 3. Lanjutkan Logika (Sudah benar)
        if ($transaksi->status != 'diproses') {
             return response()->json(['message' => 'Pesanan ini belum siap untuk dikirim (status: '.$transaksi->status.').'], 422);
        }
        
        DB::table('transaksi')
            ->where('no_transaksi', $no_transaksi)
            ->update([
                'status' => 'dikirim',
                'nomor_resi' => $validated['nomor_resi'],
                'updated_at' => Carbon::now()
            ]);

        return response()->json(['message' => 'Pesanan telah ditandai sebagai "Dikirim".']);
    }

    /**
     * [PERBAIKAN 4 - FUNGSI SELESAI]
     * POST: /api/admin/pesanan/selesai/{no_transaksi}
     */
    public function tandaiSelesai(Request $request, $no_transaksi)
    {
        $user = $request->user();

        // 1. Cek Transaksi
        $transaksi = DB::table('transaksi')
            ->where('no_transaksi', $no_transaksi)
            ->first();

        if (!$transaksi) {
            return response()->json(['message' => 'Pesanan tidak ditemukan.'], 404);
        }

        // 2. Validasi Kepemilikan Toko
        $toko = DB::table('toko')->where('id', $transaksi->id_toko)->first();
        if (!$toko || $toko->id_user != $user->id) {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }

        // 3. Lanjutkan Logika (Sudah benar)
        if ($transaksi->status != 'dikirim') {
             return response()->json(['message' => 'Pesanan ini belum dalam status pengiriman.'], 422);
        }
        
        DB::table('transaksi')
            ->where('no_transaksi', $no_transaksi)
            ->update([
                'status' => 'selesai',
                'updated_at' => Carbon::now()
            ]);

        return response()->json(['message' => 'Pesanan telah ditandai "Selesai".']);
    }


    /*
    |--------------------------------------------------------------------------
    | FUNGSI HELPER (TIDAK BERUBAH)
    |--------------------------------------------------------------------------
    */
    protected function formatFotoUrl($fotoPath)
    {
        if (empty($fotoPath)) return null;
        if (Str::startsWith($fotoPath, ['http://', 'httpsS://'])) return $fotoPath;
        try {
            $storageUrl = Storage::url($fotoPath); 
            return url($storageUrl);
        } catch (\Throwable $e) {
            return $fotoPath;
        }
    }
    
    protected function hapusFileStorage($path)
    {
        if (empty($path) || $path == 'ditolak' || $path == 'belum ada') {
            return;
        }
        try {
            if (Str::contains($path, '/storage/')) {
                $relativePath = preg_replace('#^https?://[^/]+/storage/#', '', $path);
                Storage::disk('public')->delete($relativePath);
            } else {
                Storage::disk('public')->delete($path);
            }
        } catch (\Exception $e) {
            // Abaikan error
        }
    }
}