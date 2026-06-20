<?php

namespace App\Http\Controllers\Api\Plesir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiPlesir;
use App\Models\TiketPlesirUser;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TransaksiUserController extends Controller
{
    // 1. Proses Checkout
    public function checkout(Request $request)
    {
        $request->validate([
            'kategori_tiket' => 'required|in:wisata,event',
            'jumlah_tiket' => 'required|integer|min:1',
            'total_harga' => 'required|integer',
            // Field khusus wisata
            'wisata_id' => 'required_if:kategori_tiket,wisata',
            'tanggal_kunjungan' => 'required_if:kategori_tiket,wisata|date',
            // Field khusus event
            'event_id' => 'required_if:kategori_tiket,event',
            'varian_id' => 'required_if:kategori_tiket,event',
        ]);

        $user = $request->user();
        $kodeInvoice = 'INV-PLSR-' . strtoupper(Str::random(8));

        $transaksi = TransaksiPlesir::create([
            'user_id' => $user->id,
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

    // 2. Upload Bukti Pembayaran
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

    // 3. Tampilkan Tiket Saya (Hanya yang lunas & aktif)
    public function tiketSaya(Request $request)
    {
        $tiket = TiketPlesirUser::with(['transaksi.wisata', 'transaksi.event'])
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['status' => 'success', 'data' => $tiket]);
    }
    public function getSemuaTiketKu(Request $request)
    {
        $userId = $request->user()->id;

        // A. Ambil data dari tabel TRANSAKSI (untuk Tab 1, 2, 3)
        // Load relasi wisata/event/varian agar nama destinasi muncul
        $queryTransaksi = TransaksiPlesir::with(['wisata', 'event', 'varian'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc');

        // B. Ambil data dari tabel TIKET DIGITAL (untuk Tab 4, 5)
        // Load relasi transaksi agar bisa ambil data wisata/event-nya
        $queryTiketDigital = TiketPlesirUser::with(['transaksi.wisata', 'transaksi.event', 'transaksi.varian'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc');

        // Kelompokkan data berdasarkan status
        return response()->json([
            'status' => 'success',
            'data' => [
                // Tab 1: Menunggu Pembayaran (Status Pembayaran: pending)
                'pending' => (clone $queryTransaksi)->where('status_pembayaran', 'pending')->get(),

                // Tab 2: Menunggu Verifikasi (Status Pembayaran: menunggu_konfirmasi)
                'menunggu_verifikasi' => (clone $queryTransaksi)->where('status_pembayaran', 'menunggu_konfirmasi')->get(),

                // Tab 3: Ditolak (Status Pembayaran: ditolak)
                'ditolak' => (clone $queryTransaksi)->where('status_pembayaran', 'ditolak')->get(),

                // Tab 4: Tiket Aktif (Status Tiket: aktif)
                'aktif' => (clone $queryTiketDigital)->where('status_tiket', 'aktif')->get(),

                // Tab 5: Sudah Digunakan (Status Tiket: terpakai)
                'terpakai' => (clone $queryTiketDigital)->where('status_tiket', 'terpakai')->get(),
            ]
        ]);
    }
}
