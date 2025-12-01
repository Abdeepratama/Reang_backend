<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Notification;

class AdminPesananController extends Controller
{

    /**
     * GET: /api/admin/pesanan/{id_toko}
     * (Fungsi ini sudah benar dan tidak perlu diubah)
     */
    public function index(Request $request, $id_toko) 
    {
        $user = $request->user();

        // 1. Keamanan
        $toko = DB::table('toko')->where('id', $id_toko)->first();
        if (!$toko || $toko->id_user != $user->id) { 
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }

        // 2. Query Dasar
        $query = DB::table('transaksi')
            ->join('users', 'transaksi.id_user', '=', 'users.id')
            ->leftJoin('payment', function($join) {
                $join->on('transaksi.no_transaksi', '=', DB::raw('payment.no_transaksi COLLATE utf8mb4_unicode_ci'));
            })
            ->where('transaksi.id_toko', $id_toko);

        // 3. Filter Status
        if ($request->has('status') && !empty($request->status)) {
            $filterStatus = $request->status;

            if ($filterStatus == 'menunggu_konfirmasi') {
                $query->where('payment.status_pembayaran', 'menunggu_konfirmasi');
            } else {
                $query->where('transaksi.status', $filterStatus);
                if ($filterStatus == 'menunggu_pembayaran') {
                     $query->where(function($q) {
                        $q->where('payment.status_pembayaran', '!=', 'menunggu_konfirmasi')
                          ->orWhereNull('payment.status_pembayaran');
                     });
                }
            }
        }

        // 4. [PERBAIKAN] Gunakan Paginate, bukan Get
        $pesanan = $query->select(
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
            ->paginate(10); // <-- Ubah get() jadi paginate(10)

        // 5. Transform Data (Untuk Foto Produk)
        // Karena pakai paginate, kita akses 'getCollection()'
        $pesanan->getCollection()->transform(function ($order) {
            $first_item = DB::table('detail_transaksi')
                ->join('produk', 'detail_transaksi.id_produk', '=', 'produk.id')
                ->where('detail_transaksi.no_transaksi', $order->no_transaksi)
                ->select('produk.foto', 'produk.nama')
                ->first();

            $order->nama_produk_utama = $first_item->nama ?? 'Produk Dihapus';
            $order->foto_produk = $this->formatFotoUrl($first_item->foto ?? null);
            
            return $order;
        });

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
            ->select(
                'payment.status_pembayaran', 
                'transaksi.id_toko', 
                'transaksi.id_user' // Kita butuh ID User pembeli
            )
            ->first();

        if (!$payment) return response()->json(['message' => 'Pesanan tidak ditemukan.'], 404);
        
        $toko = DB::table('toko')->where('id', $payment->id_toko)->first();
        if (!$toko || $toko->id_user != $user->id) return response()->json(['message' => 'Akses ditolak.'], 403);

        if ($payment->status_pembayaran != 'menunggu_konfirmasi') {
             return response()->json(['message' => 'Status pesanan ini tidak sedang menunggu konfirmasi.'], 422);
        }

        DB::beginTransaction();
        try {
            DB::table('transaksi')->where('no_transaksi', $no_transaksi)->update(['status' => 'diproses', 'updated_at' => Carbon::now()]);
            DB::table('payment')->where('no_transaksi', $no_transaksi)->update(['status_pembayaran' => 'lunas', 'updated_at' => Carbon::now()]);

            // [NOTIFIKASI KONFIRMASI]
            Notification::create([
                'id_user' => $payment->id_user, 
                'title'   => 'Pembayaran Dikonfirmasi',
                'body'    => "Pembayaran pesanan #$no_transaksi berhasil diverifikasi. Penjual sedang mengemas pesanan Anda.",
                'type'    => 'transaksi',
                'data_id' => $no_transaksi,
                'is_read' => 0,
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

        // 1. Cek Transaksi & Payment
        $payment = DB::table('payment')
            ->join('transaksi', 'payment.no_transaksi', '=', 'transaksi.no_transaksi')
            ->where('payment.no_transaksi', $no_transaksi)
            ->select(
                'payment.status_pembayaran', 
                'payment.bukti_pembayaran', 
                'transaksi.id_toko',
                'transaksi.id_user' // [PENTING] Ambil ID User pembeli
            )
            ->first();

        if (!$payment) return response()->json(['message' => 'Pesanan tidak ditemukan.'], 404);

        $toko = DB::table('toko')->where('id', $payment->id_toko)->first();
        if (!$toko || $toko->id_user != $user->id) return response()->json(['message' => 'Akses ditolak.'], 403);
        
        if ($payment->status_pembayaran != 'menunggu_konfirmasi') {
             return response()->json(['message' => 'Status pesanan ini tidak sedang menunggu konfirmasi.'], 422);
        }

        DB::beginTransaction();
        try {
            $this->hapusFileStorage($payment->bukti_pembayaran);

            DB::table('transaksi')->where('no_transaksi', $no_transaksi)->update(['status' => 'menunggu_pembayaran', 'updated_at' => Carbon::now()]);
            DB::table('payment')->where('no_transaksi', $no_transaksi)->update(['status_pembayaran' => 'ditolak', 'bukti_pembayaran' => 'ditolak', 'updated_at' => Carbon::now()]);

            // [BARU] NOTIFIKASI DITOLAK
            Notification::create([
                'id_user' => $payment->id_user, // Kirim ke pembeli
                'title'   => 'Pembayaran Ditolak',
                'body'    => "Maaf, bukti pembayaran pesanan #$no_transaksi ditolak. Mohon upload ulang bukti yang valid.",
                'type'    => 'transaksi',
                'data_id' => $no_transaksi,
                'is_read' => 0,
            ]);
            // -------------------------

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
        // ... (Validasi input tidak berubah) ...
        $validated = $request->validate([
            'nomor_resi' => 'nullable|string|max:255',
            'jasa_pengiriman' => 'nullable|string|max:255',
        ]);
        
        $user = $request->user();

        $transaksi = DB::table('transaksi')->where('no_transaksi', $no_transaksi)->first();
        if (!$transaksi) return response()->json(['message' => 'Pesanan tidak ditemukan.'], 404);
        
        // ... (Cek Toko & Status tidak berubah) ...
        $toko = DB::table('toko')->where('id', $transaksi->id_toko)->first();
        if (!$toko || $toko->id_user != $user->id) return response()->json(['message' => 'Akses ditolak.'], 403);
        
        if ($transaksi->status != 'diproses') {
             return response()->json(['message' => 'Pesanan ini belum siap untuk dikirim.'], 422);
        }
        
        // 1. Update Transaksi
        DB::table('transaksi')
            ->where('no_transaksi', $no_transaksi)
            ->update([
                'status' => 'dikirim',
                'nomor_resi' => $validated['nomor_resi'] ?? '-',
                'jasa_pengiriman' => $validated['jasa_pengiriman'] ?? '-',
                'updated_at' => Carbon::now()
            ]);

        // 2. [TAMBAHAN PENTING] Buat Notifikasi
        Notification::create([
            'id_user' => $transaksi->id_user, // Kirim ke pembeli
            'title'   => 'Pesanan Sedang Dikirim',
            'body'    => "Paket untuk pesanan #$no_transaksi telah dikirim. Cek detail untuk melacak.",
            'type'    => 'transaksi',
            'data_id' => $no_transaksi,
            'is_read' => 0,
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

        $transaksi = DB::table('transaksi')->where('no_transaksi', $no_transaksi)->first();
        if (!$transaksi) return response()->json(['message' => 'Pesanan tidak ditemukan.'], 404);

        // ... (Cek Toko & Status tidak berubah) ...
        $toko = DB::table('toko')->where('id', $transaksi->id_toko)->first();
        if (!$toko || $toko->id_user != $user->id) return response()->json(['message' => 'Akses ditolak.'], 403);

        if ($transaksi->status != 'dikirim') {
             return response()->json(['message' => 'Pesanan ini belum dalam status pengiriman.'], 422);
        }
        
        // 1. Update Transaksi
        DB::table('transaksi')
            ->where('no_transaksi', $no_transaksi)
            ->update([
                'status' => 'selesai',
                'updated_at' => Carbon::now()
            ]);

        // 2. [TAMBAHAN PENTING] Buat Notifikasi
        Notification::create([
            'id_user' => $transaksi->id_user,
            'title'   => 'Pesanan Selesai',
            'body'    => "Transaksi #$no_transaksi telah selesai. Terima kasih telah berbelanja!",
            'type'    => 'transaksi',
            'data_id' => $no_transaksi,
            'is_read' => 0,
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
    public function getCounts(Request $request, $id_toko)
{
    $user = $request->user();

    // Validasi toko milik user
    $toko = DB::table('toko')->where('id', $id_toko)->first();
    if (!$toko || $toko->id_user != $user->id) {
        return response()->json([], 403);
    }

    // Hitung status pesanan
    $counts = DB::table('transaksi')
        ->leftJoin('payment', 'transaksi.no_transaksi', '=', 'payment.no_transaksi')
        ->where('transaksi.id_toko', $id_toko)
        ->select(
            DB::raw("
                CASE
                    WHEN payment.status_pembayaran = 'menunggu_konfirmasi'
                        THEN 'menunggu_konfirmasi'
                    ELSE transaksi.status
                END AS status_final
            "),
            DB::raw('COUNT(*) AS total')
        )
        ->groupBy('status_final')
        ->get();

    // Default hasil
    $result = [
        'menunggu_konfirmasi' => 0,
        'diproses'           => 0,
        'dikirim'            => 0,
        'selesai'            => 0,
        'dibatalkan'         => 0,
    ];

    // Assign result
    foreach ($counts as $c) {
        if (array_key_exists($c->status_final, $result)) {
            $result[$c->status_final] = $c->total;
        }
    }

    return response()->json($result);
}

public function batalkanPesanan(Request $request, $no_transaksi)
    {
        $user = $request->user();

        // 1. Cek Transaksi
        $transaksi = DB::table('transaksi')->where('no_transaksi', $no_transaksi)->first();
        if (!$transaksi) return response()->json(['message' => 'Pesanan tidak ditemukan.'], 404);

        // 2. Validasi Kepemilikan Toko
        $toko = DB::table('toko')->where('id', $transaksi->id_toko)->first();
        if (!$toko || $toko->id_user != $user->id) {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }

        // 3. Validasi Status
        $bolehBatal = ['menunggu_konfirmasi', 'diproses'];
        if (!in_array($transaksi->status, $bolehBatal)) {
             return response()->json(['message' => 'Pesanan sudah dikirim atau selesai, tidak bisa dibatalkan.'], 422);
        }

        DB::beginTransaction();
        try {
            // Update Status Transaksi
            DB::table('transaksi')
                ->where('no_transaksi', $no_transaksi)
                ->update([
                    'status' => 'dibatalkan',
                    'updated_at' => Carbon::now()
                ]);
            
            // Update Status Payment
            DB::table('payment')
                ->where('no_transaksi', $no_transaksi)
                ->update([
                    'status_pembayaran' => 'dibatalkan',
                    'updated_at' => Carbon::now()
                ]);

            // [TAMBAHAN PENTING] Buat Notifikasi Pembatalan
            Notification::create([
                'id_user' => $transaksi->id_user, // Kirim ke user pembeli
                'title'   => 'Pesanan Dibatalkan',
                'body'    => "Mohon maaf, pesanan #$no_transaksi telah dibatalkan oleh penjual. Silakan hubungi toko untuk info lebih lanjut.",
                'type'    => 'transaksi',
                'data_id' => $no_transaksi,
                'is_read' => 0,
            ]);
            // [SELESAI TAMBAHAN]

            DB::commit();
            return response()->json(['message' => 'Pesanan berhasil dibatalkan oleh Admin.']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal membatalkan: ' . $e->getMessage()], 500);
        }
    }
}