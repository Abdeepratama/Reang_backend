<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'id_user' => 'required|integer',
            'id_umkm' => 'required|integer',
            'id_produk' => 'required|integer',
            'alamat' => 'required|string',
            'metode_pembayaran' => 'required|string',
            'jasa_pengiriman' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            $keranjang = DB::table('keranjang')->where('id_user', $request->id_user)->get();
            if ($keranjang->isEmpty()) {
                return response()->json(['message' => 'Keranjang kosong'], 400);
            }

            $no_transaksi = 'TRX' . strtoupper(uniqid());
            $total = $keranjang->sum('subtotal');

            // Simpan transaksi utama
            DB::table('transaksi')->insert([
                'id_umkm' => $request->id_umkm,
                'id_user' => $request->id_user,
                'no_transaksi' => $no_transaksi,
                'id_produk' => $request->id_produk,
                'alamat' => $request->alamat,
                'jumlah' => $keranjang->count(),
                'harga' => $total,
                'total' => $total,
                'subtotal' => $total,
                'catatan' => $request->catatan ?? 'Tidak ada catatan',
                'status' => 'menunggu',
                'jasa_pengiriman' => $request->jasa_pengiriman,
                'created_at' => Carbon::now(),
            ]);

            // Simpan ke detail_transaksi
            foreach ($keranjang as $item) {
                DB::table('detail_transaksi')->insert([
                    'no_transaksi' => $no_transaksi,
                    'id_produk' => $item->id_produk,
                    'jumlah' => $item->jumlah,
                    'harga' => $item->harga,
                    'subtotal' => $item->subtotal,
                    'created_at' => Carbon::now(),
                ]);
            }

            // Tambahkan ke payment
            DB::table('payment')->insert([
                'no_transaksi' => $no_transaksi,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status_pembayaran' => 'proses',
                'bukti_pembayaran' => 'belum ada',
                'tanggal_pembayaran' => Carbon::now()->format('Y-m-d'),
                'created_at' => Carbon::now(),
            ]);

            // Kosongkan keranjang
            DB::table('keranjang')->where('id_user', $request->id_user)->delete();

            DB::commit();

            return response()->json([
                'message' => 'Checkout berhasil',
                'no_transaksi' => $no_transaksi,
                'total' => $total
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
