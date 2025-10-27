<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KeranjangController extends Controller
{
    public function tambah(Request $request)
    {
        $request->validate([
            'id_user' => 'required|integer',
            'id_umkm' => 'required|integer',
            'id_produk' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
        ]);

        $produk = DB::table('produk')->where('id', $request->id_produk)->first();
        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        $subtotal = $produk->harga * $request->jumlah;

        DB::table('keranjang')->insert([
            'id_umkm' => $request->id_umkm,
            'id_user' => $request->id_user,
            'id_produk' => $request->id_produk,
            'harga' => $produk->harga,
            'stok' => $produk->stok,
            'jumlah' => $request->jumlah,
            'subtotal' => $subtotal,
            'created_at' => Carbon::now(),
        ]);

        return response()->json(['message' => 'Produk ditambahkan ke keranjang']);
    }

    public function lihat($id_user)
    {
        $keranjang = DB::table('keranjang')
            ->join('produk', 'keranjang.id_produk', '=', 'produk.id')
            ->select('keranjang.*', 'produk.nama', 'produk.foto')
            ->where('keranjang.id_user', $id_user)
            ->get();

        return response()->json($keranjang);
    }
}
