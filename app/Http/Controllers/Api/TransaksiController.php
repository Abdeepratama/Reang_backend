<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function riwayat($id_user)
    {
        $transaksi = DB::table('transaksi')
            ->where('id_user', $id_user)
            ->orderByDesc('created_at')
            ->get();

        foreach ($transaksi as $trx) {
            $trx->detail = DB::table('detail_transaksi')
                ->join('produk', 'detail_transaksi.id_produk', '=', 'produk.id')
                ->where('detail_transaksi.no_transaksi', $trx->no_transaksi)
                ->select('produk.nama', 'produk.foto', 'detail_transaksi.*')
                ->get();

            $trx->payment = DB::table('payment')
                ->where('no_transaksi', $trx->no_transaksi)
                ->first();
        }

        return response()->json($transaksi);
    }
}
