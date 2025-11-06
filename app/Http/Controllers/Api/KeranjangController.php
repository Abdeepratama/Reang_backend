<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage; // <-- [PERBAIKAN] TAMBAHKAN INI
use Illuminate\Support\Str; // <-- [PERBAIKAN] TAMBAHKAN INI

class KeranjangController extends Controller
{

    protected function formatFotoUrl($fotoPath)
    {
        if (empty($fotoPath)) {
            return null;
        }
        if (Str::startsWith($fotoPath, ['http://', 'https://'])) {
            return $fotoPath;
        }
        try {
            $storageUrl = Storage::url($fotoPath); 
            return url($storageUrl);
        } catch (\Throwable $e) {
            return $fotoPath;
        }
    }
  

    public function tambah(Request $request)
    {
        $request->validate([
            'id_user' => 'required|integer',
            'id_toko' => 'required|integer',
            'id_produk' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
        ]);

        $produk = DB::table('produk')->where('id', $request->id_produk)->first();
        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        // --- [PERBAIKAN 2] VALIDASI STOK ---
        if ($request->jumlah > $produk->stok) {
            return response()->json([
                'message' => 'Jumlah melebihi stok yang tersedia (Stok: ' . $produk->stok . ')'
            ], 422); // 422 Unprocessable Entity
        }
        // --- [PERBAIKAN 2 SELESAI] ---

        $subtotal = $produk->harga * $request->jumlah;

        DB::table('keranjang')->insert([
            'id_toko' => $request->id_toko,
            'id_user' => $request->id_user,
            'id_produk' => $request->id_produk,
            'harga' => $produk->harga,
            'stok' => $produk->stok, // Simpan stok saat ini
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
            ->join('toko', 'keranjang.id_toko', '=', 'toko.id') // <-- [PERBAIKAN] JOIN TOKO
            ->select(
                'keranjang.*', 
                'produk.nama', 
                'produk.foto',
                'toko.alamat as lokasi' // <-- [PERBAIKAN] Ambil lokasi
            )
            ->where('keranjang.id_user', $id_user)
            ->orderBy('keranjang.created_at', 'desc') // <-- Lebih baik diurutkan
            ->get();

        // --- [PERBAIKAN 1] Format URL Foto ---
        $keranjang->transform(function ($item) {
            $item->foto = $this->formatFotoUrl($item->foto);
            return $item;
        });
        // --- [PERBAIKAN 1 SELESAI] ---

        return response()->json($keranjang);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $id_user = $request->user()->id;
        $item = DB::table('keranjang')
            ->where('id', $id)
            ->where('id_user', $id_user)
            ->first();

        if (!$item) {
            return response()->json(['message' => 'Item keranjang tidak ditemukan'], 404);
        }

        // --- [PERBAIKAN 2] VALIDASI STOK ---
        // Cek stok terbaru dari tabel 'produk'
        $produk = DB::table('produk')->find($item->id_produk);
        
        if ($request->jumlah > $produk->stok) {
            return response()->json([
                'message' => 'Jumlah melebihi stok yang tersedia (Stok: ' . $produk->stok . ')'
            ], 422);
        }
        // --- [PERBAIKAN 2 SELESAI] ---

        $subtotal = $item->harga * $request->jumlah;

        DB::table('keranjang')
            ->where('id', $id)
            ->update([
                'jumlah' => $request->jumlah,
                'subtotal' => $subtotal,
                'stok' => $produk->stok, // Update stok terbaru di keranjang
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['message' => 'Jumlah produk diperbarui']);
    }


    public function hapus(Request $request, $id)
    {
        // ... (Fungsi 'hapus' Anda sudah aman, tidak perlu diubah) ...
        $id_user = $request->user()->id;
        $item = DB::table('keranjang')
            ->where('id', $id)
            ->where('id_user', $id_user)
            ->first();
            
        if (!$item) {
            return response()->json(['message' => 'Item keranjang tidak ditemukan'], 404);
        }

        DB::table('keranjang')->where('id', $id)->delete();

        return response()->json(['message' => 'Produk dihapus dari keranjang']);
    }
}