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
        // 1. Validasi
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $id_user = $request->user()->id;

        // 2. Cek Keamanan & Ambil Data Lama
        $payment = DB::table('payment')
            ->join('transaksi', 'payment.no_transaksi', '=', 'transaksi.no_transaksi')
            ->where('payment.no_transaksi', $no_transaksi)
            ->where('transaksi.id_user', $id_user)
            ->select('payment.*') // Kita butuh data payment termasuk path file lama
            ->first();

        if (!$payment) {
            return response()->json(['message' => 'Pesanan tidak ditemukan atau bukan milik Anda.'], 404);
        }

        // 3. [PERBAIKAN UTAMA] Cek Status
        // Kita HANYA melarang upload jika statusnya 'menunggu_konfirmasi' (sedang dicek) 
        // atau 'lunas' (sudah selesai).
        // Jadi status 'ditolak' akan LOLOS dan bisa upload ulang.
        
        if ($payment->status_pembayaran == 'menunggu_konfirmasi') {
             return response()->json(['message' => 'Bukti pembayaran sedang diperiksa Admin. Harap tunggu.'], 422);
        }
        
        if ($payment->status_pembayaran == 'lunas') {
             return response()->json(['message' => 'Pesanan ini sudah lunas.'], 422);
        }

        // 4. Proses Simpan File
        $path = null;
        if ($request->hasFile('bukti_pembayaran')) {
            
            // [TAMBAHAN] Hapus file lama jika ada (agar storage tidak penuh)
            // Cek apakah ada file lama dan bukan 'ditolak' string biasa
            if ($payment->bukti_pembayaran && $payment->bukti_pembayaran != 'ditolak' && $payment->bukti_pembayaran != 'belum ada') {
                // Pastikan import Storage di atas: use Illuminate\Support\Facades\Storage;
                if (Storage::disk('public')->exists($payment->bukti_pembayaran)) {
                    Storage::disk('public')->delete($payment->bukti_pembayaran);
                }
            }

            // Upload file baru
            $file = $request->file('bukti_pembayaran');
            if ($file->isValid()) {
                $path = $file->store('bukti_bayar', 'public');
            }
        }

        if (!$path) {
            return response()->json(['message' => 'Gagal meng-upload file.'], 500);
        }

        // 5. Update Database
        // Ubah status kembali jadi 'menunggu_konfirmasi' agar masuk notif Admin lagi
        DB::table('payment')
            ->where('no_transaksi', $no_transaksi)
            ->update([
                'bukti_pembayaran' => $path,
                'status_pembayaran' => 'menunggu_konfirmasi', // <-- Reset status ke sini
                'tanggal_pembayaran' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            
        // [OPSIONAL] Update status transaksi juga jika perlu disinkronkan
        /*
        DB::table('transaksi')
            ->where('no_transaksi', $no_transaksi)
            ->update(['status' => 'menunggu_konfirmasi', 'updated_at' => Carbon::now()]);
        */

        return response()->json([
            'message' => 'Bukti pembayaran berhasil diupload. Mohon tunggu konfirmasi penjual.',
            'path' => $path
        ]);
    }

    // [DIHAPUS] Fungsi store() lama (karena TransaksiController yg urus)
    // [DIHAPUS] Fungsi show() lama
    // [DIHAPUS] Fungsi riwayat() lama (karena TransaksiController yg urus)
}