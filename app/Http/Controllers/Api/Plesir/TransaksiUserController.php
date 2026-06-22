<?php

namespace App\Http\Controllers\Api\Plesir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiPlesir;
use App\Models\TiketPlesirUser;
use App\Models\TiketWisata;
use App\Models\TiketEvent;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TransaksiUserController extends Controller
{
    // =========================================================================
    // 1. PROSES CHECKOUT (SIMPAN METODE PEMBAYARAN)
    // =========================================================================
    public function checkout(Request $request)
    {
        $request->validate([
            'kategori_tiket' => 'required|in:wisata,event',
            'jumlah_tiket' => 'required|integer|min:1',
            'total_harga' => 'required|integer',
            'wisata_id' => 'required_if:kategori_tiket,wisata',
            'tanggal_kunjungan' => 'required_if:kategori_tiket,wisata|nullable|date',
            'event_id' => 'required_if:kategori_tiket,event',
            'varian_id' => 'required_if:kategori_tiket,event',
            'metode_pembayaran_id' => 'required|integer', // WAJIB DIISI DARI FLUTTER
        ]);

        $user = $request->user();
        $kodeInvoice = 'INV-PLSR-' . strtoupper(Str::random(8));

        // Cari ID Mitra (Penjual)
        $idMitra = null;
        if ($request->kategori_tiket == 'wisata') {
            $wisata = TiketWisata::find($request->wisata_id);
            if ($wisata) {
                $idMitra = $wisata->id_mitra;
            }
        } elseif ($request->kategori_tiket == 'event') {
            $event = TiketEvent::find($request->event_id);
            if ($event) {
                $idMitra = $event->id_mitra;
            }
        }

        if (!$idMitra) {
            return response()->json(['status' => 'error', 'message' => 'Data mitra penjual tidak ditemukan.'], 404);
        }

        // Simpan Transaksi Lengkap
        $transaksi = TransaksiPlesir::create([
            'user_id' => $user->id,
            'id_mitra' => $idMitra,
            'metode_pembayaran_id' => $request->metode_pembayaran_id,
            'kode_invoice' => $kodeInvoice,
            'kategori_tiket' => $request->kategori_tiket,
            'wisata_id' => $request->wisata_id,
            'event_id' => $request->event_id,
            'varian_id' => $request->varian_id,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'jumlah_tiket' => $request->jumlah_tiket,
            'total_harga' => $request->total_harga,
            'status_pembayaran' => 'pending'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Checkout berhasil, silakan lakukan pembayaran',
            'data' => $transaksi
        ]);
    }

    // =========================================================================
    // 2. UPLOAD BUKTI PEMBAYARAN
    // =========================================================================
    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $transaksi = TransaksiPlesir::where('id', $id)->where('user_id', $request->user()->id)->firstOrFail();

        if ($request->hasFile('bukti_pembayaran')) {
            $path = $request->file('bukti_pembayaran')->store('bukti_plesir', 'public');
            $transaksi->update([
                'bukti_pembayaran' => $path,
                'status_pembayaran' => 'menunggu_konfirmasi'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Bukti berhasil diupload, menunggu konfirmasi admin',
            'data' => $transaksi
        ]);
    }

    // =========================================================================
    // 3. TAMPILKAN SEMUA TIKET SAYA (5 TAB DI FLUTTER)
    // =========================================================================
    // --- 3. TAMPILKAN SEMUA TIKET SAYA (5 TAB DI FLUTTER) ---
    public function getSemuaTiketKu(Request $request)
    {
        $userId = $request->user()->id;

        // 👇 KITA HANYA MENGGUNAKAN SATU QUERY DARI TransaksiPlesir
        $queryTransaksi = TransaksiPlesir::with(['wisata', 'event', 'varian', 'metodePembayaran'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc');

        return response()->json([
            'status' => 'success',
            'data' => [
                'pending' => (clone $queryTransaksi)->where('status_pembayaran', 'pending')->get(),
                'menunggu_verifikasi' => (clone $queryTransaksi)->where('status_pembayaran', 'menunggu_konfirmasi')->get(),
                'ditolak' => (clone $queryTransaksi)->where('status_pembayaran', 'ditolak')->get(),

                // 👇 PERBAIKAN: Gunakan status_pembayaran dari tabel TransaksiPlesir
                'aktif' => (clone $queryTransaksi)->where('status_pembayaran', 'aktif')->get(),
                'terpakai' => (clone $queryTransaksi)->where('status_pembayaran', 'terpakai')->get(),
            ]
        ]);
    }

    // =========================================================================
    // 4. AMBIL DAFTAR METODE PEMBAYARAN MITRA (UNTUK CHECKOUT/GANTI METODE)
    // =========================================================================
    public function getMetodeForCheckout(Request $request)
    {
        $kategori = $request->query('kategori');
        $targetId = $request->query('target_id');

        $idMitra = null;
        if ($kategori == 'wisata') {
            $wisata = \App\Models\TiketWisata::find($targetId);
            $idMitra = $wisata ? $wisata->id_mitra : null;
        } elseif ($kategori == 'event') {
            $event = \App\Models\TiketEvent::find($targetId);
            $idMitra = $event ? $event->id_mitra : null;
        }

        if (!$idMitra) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data mitra penjual tidak ditemukan'
            ], 404);
        }

        $metode = \App\Models\MetodePembayaranPlesir::where('id_mitra', $idMitra)
            ->where('is_active', 1)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $metode
        ]);
    }

    // =========================================================================
    // 5. GANTI METODE PEMBAYARAN (DARI BOTTOM SHEET FLUTTER)
    // =========================================================================
    public function gantiMetodePembayaran(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran_id' => 'required|integer'
        ]);

        $transaksi = TransaksiPlesir::find($id);

        if (!$transaksi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaksi tidak ditemukan.'
            ], 404);
        }

        if ($transaksi->user_id != $request->user()->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaksi ini bukan milik Anda.'
            ], 403);
        }

        $transaksi->update([
            'metode_pembayaran_id' => $request->metode_pembayaran_id
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Metode berhasil diperbarui',
            'data' => $transaksi->load('metodePembayaran')
        ]);
    }
}
