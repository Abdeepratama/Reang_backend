<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; // <-- [PENTING] Untuk upload file
use Carbon\Carbon;

class PaymentController extends Controller
{

    public function uploadBukti(Request $request, $no_transaksi)
    {
        // 1. Validasi: Pastikan 'bukti_pembayaran' adalah file gambar
        $request->validate([
            // [PERBAIKAN] Mengganti 'string' menjadi 'image'
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048', // Maks 2MB
        ]);

        // 2. Dapatkan ID user yang sedang login (Keamanan)
        $id_user = $request->user()->id;

        // 3. Cek Keamanan:
        // Pastikan 'no_transaksi' ini ada, dan BENAR-BENAR milik user yang login
        $payment = DB::table('payment')
            ->join('transaksi', 'payment.no_transaksi', '=', 'transaksi.no_transaksi')
            ->where('payment.no_transaksi', $no_transaksi)
            ->where('transaksi.id_user', $id_user)
            ->select('payment.*')
            ->first();

        if (!$payment) {
            return response()->json(['message' => 'Pesanan tidak ditemukan atau bukan milik Anda.'], 404);
        }

        // 4. Cek apakah sudah lunas
        if ($payment->status_pembayaran != 'menunggu') {
             return response()->json(['message' => 'Pembayaran ini sudah dikonfirmasi atau sedang diproses.'], 422);
        }

        // 5. Simpan File Bukti Bayar
        $path = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            if ($file->isValid()) {
                // Simpan di: storage/app/public/bukti_bayar
                $path = $file->store('bukti_bayar', 'public');
            }
        }

        if (!$path) {
            return response()->json(['message' => 'Gagal meng-upload file.'], 500);
        }

        // 6. Update Database
        DB::table('payment')
            ->where('no_transaksi', $no_transaksi)
            ->update([
                'bukti_pembayaran' => $path, // Simpan path filenya
                'status_pembayaran' => 'menunggu_konfirmasi', // Status baru
                'tanggal_pembayaran' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        return response()->json([
            'message' => 'Upload bukti pembayaran berhasil. Pesanan akan segera diproses.',
            'path' => $path
        ]);
    }

    // [DIHAPUS] Fungsi store() lama (karena TransaksiController yg urus)
    // [DIHAPUS] Fungsi show() lama
    // [DIHAPUS] Fungsi riwayat() lama (karena TransaksiController yg urus)
}