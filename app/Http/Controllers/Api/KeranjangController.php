<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KeranjangController extends Controller
{
    // (Helper formatFotoUrl tidak berubah)
    protected function formatFotoUrl($fotoPath)
    {
        if (empty($fotoPath)) return null;
        if (Str::startsWith($fotoPath, ['http://', 'https://'])) return $fotoPath;
        try {
            $storageUrl = Storage::url($fotoPath); 
            return url($storageUrl);
        } catch (\Throwable $e) {
            return $fotoPath;
        }
    }
    
    // =======================================================================
    // --- [PEROMBAKAN TOTAL] FUNGSI 'tambah' (LOGIKA SMART CART) ---
    // =======================================================================
    /**
     * 🔹 POST: /api/keranjang/create
     * Menambah/Update produk ke keranjang (Smart Logic).
     */
    public function tambah(Request $request)
    {
        $request->validate([
            'id_user' => 'required|integer|exists:users,id',
            'id_toko' => 'required|integer|exists:toko,id',
            'id_produk' => 'required|integer|exists:produk,id',
            'jumlah' => 'required|integer|min:1',
            'variasi' => 'nullable|string', // <-- [BARU] Menerima variasi
        ]);

        $id_user = $request->id_user;
        $id_produk = $request->id_produk;
        $jumlah_baru = $request->jumlah;
        $variasi = $request->variasi;

        // 1. Cek Produk & Stok
        $produk = DB::table('produk')->where('id', $id_produk)->first();
        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        // 2. Cari item yang SAMA PERSIS (produk + variasi) di keranjang
        $item_keranjang = DB::table('keranjang')
            ->where('id_user', $id_user)
            ->where('id_produk', $id_produk)
            ->where('variasi', $variasi) // <-- [BARU] Cek variasinya juga
            ->first();

        if ($item_keranjang) {
            // --- [LOGIKA UPDATE] ---
            // Barang sudah ada, kita update jumlahnya
            
            $jumlah_total = $item_keranjang->jumlah + $jumlah_baru;

            // 3. Validasi Stok (Gabungan)
            if ($jumlah_total > $produk->stok) {
                return response()->json([
                    'message' => 'Jumlah melebihi stok yang tersedia (Stok: ' . $produk->stok . ')'
                ], 422); // Error 422 Unprocessable Entity
            }

            // 4. Update Jumlah & Subtotal
            $subtotal_baru = $produk->harga * $jumlah_total;
            DB::table('keranjang')
                ->where('id', $item_keranjang->id)
                ->update([
                    'jumlah' => $jumlah_total,
                    'subtotal' => $subtotal_baru,
                    'stok' => $produk->stok, // Update info stok
                    'updated_at' => Carbon::now(),
                ]);
            
            return response()->json(['message' => 'Kuantitas produk diperbarui di keranjang']);

        } else {
            // --- [LOGIKA INSERT] ---
            // Ini barang baru (atau variasi baru), kita insert
            
            // 3. Validasi Stok (Awal)
            if ($jumlah_baru > $produk->stok) {
                return response()->json([
                    'message' => 'Jumlah melebihi stok yang tersedia (Stok: ' . $produk->stok . ')'
                ], 422);
            }

            // 4. Insert data baru
            $subtotal = $produk->harga * $jumlah_baru;
            DB::table('keranjang')->insert([
                'id_toko' => $request->id_toko,
                'id_user' => $id_user,
                'id_produk' => $id_produk,
                'variasi' => $variasi, // <-- [BARU] Simpan variasinya
                'harga' => $produk->harga,
                'stok' => $produk->stok,
                'jumlah' => $jumlah_baru,
                'subtotal' => $subtotal,
                'created_at' => Carbon::now(),
            ]);

            return response()->json(['message' => 'Produk ditambahkan ke keranjang']);
        }
    }
    // =======================================================================
    // --- [PEROMBAKAN SELESAI] ---
    // =======================================================================


    /**
     * 🔹 GET: /api/keranjang/show/{id_user}
     * (Kita tambahkan 'nama_toko' dan 'variasi' ke select)
     */
    public function lihat($id_user)
    {
        $keranjang = DB::table('keranjang')
            ->join('produk', 'keranjang.id_produk', '=', 'produk.id')
            ->join('toko', 'keranjang.id_toko', '=', 'toko.id')
            ->select(
                'keranjang.*', // Ambil semua data dari tabel keranjang
                'produk.nama as nama_produk', 
                'produk.foto',
                'toko.nama as nama_toko',
                'toko.alamat as lokasi_toko'
                // 'keranjang.variasi' sudah otomatis terambil oleh 'keranjang.*'
            )
            ->where('keranjang.id_user', $id_user)
            ->orderBy('keranjang.id_toko', 'asc')
            ->orderBy('keranjang.created_at', 'desc')
            ->get();

        $keranjang->transform(function ($item) {
            $item->foto = $this->formatFotoUrl($item->foto);
            return $item;
        });

        return response()->json($keranjang);
    }


    /**
     * 🔹 PUT: /api/keranjang/update/{id}
     * (Fungsi 'update' Anda sudah benar, tidak diubah)
     * (Validasi stok di sini sudah menangani stok jebol dari CartScreen)
     */
    public function update(Request $request, $id)
    {
        // ... (Fungsi 'update' Anda sudah benar dan aman) ...
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
        $produk = DB::table('produk')->find($item->id_produk);
        if ($request->jumlah > $produk->stok) {
            return response()->json([
                'message' => 'Jumlah melebihi stok yang tersedia (Stok: ' . $produk->stok . ')'
            ], 422);
        }
        $subtotal = $item->harga * $request->jumlah;
        DB::table('keranjang')
            ->where('id', $id)
            ->update([
                'jumlah' => $request->jumlah,
                'subtotal' => $subtotal,
                'stok' => $produk->stok,
                'updated_at' => Carbon::now(),
            ]);
        return response()->json(['message' => 'Jumlah produk diperbarui']);
    }

    /**
     * 🔹 DELETE: /api/keranjang/hapus/{id}
     * (Fungsi 'hapus' Anda sudah aman, tidak diubah)
     */
    public function hapus(Request $request, $id)
    {
        // ... (Fungsi 'hapus' Anda sudah benar) ...
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