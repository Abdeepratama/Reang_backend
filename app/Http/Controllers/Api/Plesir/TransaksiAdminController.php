<?php

namespace App\Http\Controllers\Api\Plesir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiPlesir;
use App\Models\NotifikasiPlesirUser; // 👇 IMPORT MODEL NOTIFIKASI USER
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TransaksiAdminController extends Controller
{
    // =========================================================================
    // 👇 FUNGSI HELPER UNTUK MENGAMBIL ID MITRA
    // =========================================================================
    private function getMitraIdFromLogin(Request $request)
    {
        // Sesuaikan 'mitra_plesir' jika nama tabel profil mitra kamu berbeda
        $mitra = DB::table('mitra_plesir')->where('id_user', $request->user()->id)->first();
        return $mitra ? $mitra->id : null;
    }

    // =========================================================================
    // 1. API SAKTI: AMBIL SEMUA PESANAN MASUK (KHUSUS MILIK MITRA YANG LOGIN)
    // =========================================================================
    public function pesananMasuk(Request $request)
    {
        $mitraId = $this->getMitraIdFromLogin($request);

        if (!$mitraId) {
            return response()->json([
                'status' => 'success',
                'unread_notif_count' => 0,
                'data' => [
                    'pending' => [],
                    'menunggu_verifikasi' => [],
                    'ditolak' => [],
                    'aktif' => [],
                    'terpakai' => []
                ]
            ]);
        }

        // Hanya butuh 1 query utama
        $queryTransaksi = TransaksiPlesir::with(['user', 'wisata', 'event', 'varian', 'metodePembayaran'])
            ->where('id_mitra', $mitraId)
            ->orderBy('updated_at', 'desc');

        // MENGHITUNG JUMLAH NOTIFIKASI BELUM DIBACA
        $unreadCount = (clone $queryTransaksi)
            ->where('status_pembayaran', 'menunggu_konfirmasi')
            ->where('is_read_admin', 0)
            ->count();

        return response()->json([
            'status' => 'success',
            'unread_notif_count' => $unreadCount, // Kunci lonceng merah admin
            'data' => [
                'pending' => (clone $queryTransaksi)->where('status_pembayaran', 'pending')->get(),
                'menunggu_verifikasi' => (clone $queryTransaksi)->where('status_pembayaran', 'menunggu_konfirmasi')->get(),
                'ditolak' => (clone $queryTransaksi)->where('status_pembayaran', 'ditolak')->get(),
                'aktif' => (clone $queryTransaksi)->where('status_pembayaran', 'aktif')->get(),
                'terpakai' => (clone $queryTransaksi)->where('status_pembayaran', 'terpakai')->get(),
            ]
        ]);
    }

    // =========================================================================
    // 2. FUNGSI KONFIRMASI PEMBAYARAN (GENERATE KODE TIKET & KIRIM NOTIF)
    // =========================================================================
    public function konfirmasiPembayaran(Request $request, $id)
    {
        $idMitra = $this->getMitraIdFromLogin($request);

        if (!$idMitra) {
            return response()->json(['status' => 'error', 'message' => 'Akses ditolak.'], 403);
        }

        $transaksi = TransaksiPlesir::where('id_mitra', $idMitra)->findOrFail($id);

        $request->validate([
            'status' => 'required|in:aktif,ditolak',
            'keterangan' => 'nullable|string',
        ]);

        $transaksi->status_pembayaran = $request->status;
        $transaksi->keterangan_admin = $request->keterangan;

        $judulNotif = '';
        $pesanNotif = '';

        // JIKA DITERIMA
        if ($request->status === 'aktif') {
            if (empty($transaksi->kode_tiket)) {
                $transaksi->kode_tiket = 'PLS-' . strtoupper(substr(uniqid(), -6) . rand(100, 999));
            }
            $judulNotif = 'Pembayaran Berhasil! 🎉';
            $pesanNotif = "Hore! Pembayaran untuk Invoice {$transaksi->kode_invoice} telah diverifikasi. Silakan cek halaman 'Tiket Saya' untuk melihat kode QR tiketmu.";
        }
        // JIKA DITOLAK
        else if ($request->status === 'ditolak') {
            $judulNotif = 'Pembayaran Ditolak ⚠️';
            $pesanNotif = "Mohon maaf, bukti pembayaran untuk Invoice {$transaksi->kode_invoice} ditolak oleh admin. Alasan: {$request->keterangan}. Silakan unggah ulang bukti pembayaranmu.";
        }

        $transaksi->save();

        // 👇 MENGIRIM NOTIFIKASI KE USER
        NotifikasiPlesirUser::create([
            'user_id' => $transaksi->user_id,
            'transaksi_id' => $transaksi->id,
            'judul' => $judulNotif,
            'pesan' => $pesanNotif,
            'is_read' => 0,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Status pembayaran berhasil diubah & Notifikasi terkirim.',
            'data' => $transaksi
        ]);
    }

    // =========================================================================
    // 3. FUNGSI SCAN TIKET (UBAH STATUS JADI 'TERPAKAI')
    // =========================================================================
    public function scanTiket(Request $request)
    {
        $idMitra = $this->getMitraIdFromLogin($request);

        if (!$idMitra) {
            return response()->json(['status' => 'error', 'message' => 'Akses ditolak.'], 403);
        }

        $request->validate([
            'kode_tiket' => 'required|string'
        ]);

        // Cari transaksi berdasarkan kode tiket dan milik mitra yang sedang login
        $transaksi = TransaksiPlesir::where('id_mitra', $idMitra)
            ->where('kode_tiket', $request->kode_tiket)
            ->first();

        // 1. Cek apakah tiketnya ada
        if (!$transaksi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tiket tidak ditemukan atau bukan milik wisata/event Anda!'
            ], 404);
        }

        // 2. Cek apakah tiket sudah pernah di-scan sebelumnya
        if ($transaksi->status_pembayaran === 'terpakai') {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal! Tiket ini SUDAH DIGUNAKAN sebelumnya.'
            ], 400);
        }

        // 3. Cek apakah status tiket belum 'aktif' (mungkin dihack/bypass)
        if ($transaksi->status_pembayaran !== 'aktif') {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal! Tiket tidak valid atau belum lunas.'
            ], 400);
        }

        // 4. Jika semua aman, ganti statusnya jadi 'terpakai'
        $transaksi->status_pembayaran = 'terpakai';
        $transaksi->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Scan Berhasil! Tiket valid dan pengunjung dipersilakan masuk.',
            'data' => [
                'kode_tiket' => $transaksi->kode_tiket,
                'jumlah_tiket' => $transaksi->jumlah_tiket,
                'nama_pembeli' => $transaksi->user->name ?? 'User',
            ]
        ]);
    }

    // =========================================================================
    // 4. FUNGSI ANALITIK BISNIS UMKM PLESIR
    // =========================================================================
    public function getAnalitik(Request $request)
    {
        $idMitra = $this->getMitraIdFromLogin($request);

        if (!$idMitra) {
            return response()->json(['status' => 'error', 'message' => 'Akses ditolak.'], 403);
        }

        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        // 1. PENDAPATAN & TIKET TERJUAL (BULAN INI)
        $transaksiBulanIni = TransaksiPlesir::where('id_mitra', $idMitra)
            ->whereIn('status_pembayaran', ['aktif', 'terpakai'])
            ->where('created_at', '>=', $startOfMonth)
            ->get();

        $pendapatanBulanIni = $transaksiBulanIni->sum('total_harga');
        $tiketTerjualBulanIni = $transaksiBulanIni->sum('jumlah_tiket');

        // 2. MENGHITUNG PERSENTASE TREN (Dibanding Bulan Lalu)
        $pendapatanBulanLalu = TransaksiPlesir::where('id_mitra', $idMitra)
            ->whereIn('status_pembayaran', ['aktif', 'terpakai'])
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->sum('total_harga');

        $persentase = 0;
        if ($pendapatanBulanLalu > 0) {
            $persentase = (($pendapatanBulanIni - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100;
        } elseif ($pendapatanBulanIni > 0) {
            $persentase = 100; // Jika bulan lalu kosong dan sekarang ada pemasukan
        }

        // 3. PESANAN MENUNGGU VERIFIKASI
        $menungguVerifikasi = TransaksiPlesir::where('id_mitra', $idMitra)
            ->where('status_pembayaran', 'menunggu_konfirmasi')
            ->count();

        // 4. GRAFIK MINGGUAN (Senin s.d Minggu ini)
        $startOfWeek = $now->copy()->startOfWeek();
        $grafikMingguan = [];
        $maxPendapatan = 0;
        $hariMap = [1 => 'SEN', 2 => 'SEL', 3 => 'RAB', 4 => 'KAM', 5 => 'JUM', 6 => 'SAB', 0 => 'MIN'];

        // Ambil total per hari
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $dailyRev = TransaksiPlesir::where('id_mitra', $idMitra)
                ->whereIn('status_pembayaran', ['aktif', 'terpakai'])
                ->whereDate('created_at', $date->toDateString())
                ->sum('total_harga');

            if ($dailyRev > $maxPendapatan) $maxPendapatan = $dailyRev;

            $grafikMingguan[] = [
                'nama_hari' => $hariMap[$date->dayOfWeek],
                'pendapatan' => $dailyRev,
                'is_today' => $date->isToday()
            ];
        }

        // Kalkulasi tinggi batang grafik (0.0 sampai 1.0)
        foreach ($grafikMingguan as &$hari) {
            $hari['height_percentage'] = $maxPendapatan > 0 ? ($hari['pendapatan'] / $maxPendapatan) : 0;
        }

        // 5. INSIGHT BISNIS (Destinasi Paling Laris)
        $insight = [
            'judul' => 'Belum Ada Penjualan',
            'deskripsi' => 'Ayo tingkatkan promosi destinasi Anda bulan ini!',
            'foto' => 'https://ui-avatars.com/api/?name=Promo&background=0D5691&color=fff'
        ];

        $terlaris = TransaksiPlesir::with(['wisata', 'event'])
            ->where('id_mitra', $idMitra)
            ->whereIn('status_pembayaran', ['aktif', 'terpakai'])
            ->selectRaw('wisata_id, event_id, sum(jumlah_tiket) as total_terjual')
            ->groupBy('wisata_id', 'event_id')
            ->orderBy('total_terjual', 'desc')
            ->first();

        if ($terlaris) {
            if ($terlaris->wisata_id && $terlaris->wisata) {
                $insight = [
                    'judul' => $terlaris->wisata->nama_wisata,
                    'deskripsi' => 'Destinasi wisata ini menyumbang penjualan tiket terbanyak Anda.',
                    'foto' => $terlaris->wisata->foto_utama ?? $insight['foto']
                ];
            } elseif ($terlaris->event_id && $terlaris->event) {
                $insight = [
                    'judul' => $terlaris->event->nama_event,
                    'deskripsi' => 'Event ini mendominasi penjualan tiket Anda bulan ini.',
                    'foto' => $terlaris->event->foto_utama ?? $insight['foto']
                ];
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_pendapatan' => $pendapatanBulanIni,
                'persentase_tren' => round($persentase, 1),
                'tiket_terjual' => $tiketTerjualBulanIni,
                'menunggu_verifikasi' => $menungguVerifikasi,
                'max_pendapatan' => $maxPendapatan,
                'grafik_mingguan' => $grafikMingguan,
                'insight' => $insight
            ]
        ]);
    }

    // =========================================================================
    // 5. FUNGSI TANDAI NOTIFIKASI DIBACA
    // =========================================================================
    public function tandaiNotifDibaca(Request $request)
    {
        $idMitra = $this->getMitraIdFromLogin($request);

        if (!$idMitra) {
            return response()->json(['status' => 'error', 'message' => 'Akses ditolak.'], 403);
        }

        // Ubah semua pesanan yang 'menunggu_konfirmasi' menjadi sudah dibaca (1)
        TransaksiPlesir::where('id_mitra', $idMitra)
            ->where('status_pembayaran', 'menunggu_konfirmasi')
            ->where('is_read_admin', 0)
            ->update(['is_read_admin' => 1]);

        return response()->json([
            'status' => 'success',
            'message' => 'Notifikasi berhasil ditandai dibaca'
        ]);
    }
}
