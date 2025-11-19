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
    $data = $request->validate([
        'id_user'   => 'required|integer|exists:users,id',
        'id_toko'   => 'required|integer|exists:toko,id',
        'id_produk' => 'required|integer|exists:produk,id',
        'id_varian' => 'required|integer|exists:produk_varian,id',
        'jumlah'    => 'required|integer|min:1',
        'variasi'   => 'nullable|string',
    ]);

    $id_user     = $data['id_user'];
    $id_produk   = $data['id_produk'];
    $id_varian   = $data['id_varian'];
    $jumlah_baru = $data['jumlah'];
    $nama_variasi = $data['variasi'] ?? null;

    // Ambil varian
    $varian = DB::table('produk_varian')
        ->where('id', $id_varian)
        ->where('id_produk', $id_produk)
        ->first();

    if (!$varian) {
        return response()->json(['message' => 'Varian produk tidak ditemukan'], 404);
    }

    // Cek item keranjang yang sama (produk + varian)
    $item_keranjang = DB::table('keranjang')
        ->where('id_user', $id_user)
        ->where('id_produk', $id_produk)
        ->where('id_varian', $id_varian)
        ->first();

    // Jika item sudah ada → Update
    if ($item_keranjang) {

        $jumlah_total = $item_keranjang->jumlah + $jumlah_baru;

        if ($jumlah_total > $varian->stok) {
            return response()->json([
                'message' => 'Jumlah melebihi stok yang tersedia (Stok: ' . $varian->stok . ')'
            ], 422);
        }

        $subtotal_baru = $varian->harga * $jumlah_total;

        DB::table('keranjang')
            ->where('id', $item_keranjang->id)
            ->update([
                'jumlah'     => $jumlah_total,
                'subtotal'   => $subtotal_baru,
                'stok'       => $varian->stok,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['message' => 'Kuantitas produk diperbarui di keranjang']);
    }

    // Jika belum ada → Insert item baru
    if ($jumlah_baru > $varian->stok) {
        return response()->json([
            'message' => 'Jumlah melebihi stok yang tersedia (Stok: ' . $varian->stok . ')'
        ], 422);
    }

    $subtotal = $varian->harga * $jumlah_baru;

    DB::table('keranjang')->insert([
        'id_toko'   => $data['id_toko'],
        'id_user'   => $id_user,
        'id_produk' => $id_produk,
        'id_varian' => $id_varian,
        'variasi'   => $nama_variasi,
        'harga'     => $varian->harga,
        'stok'      => $varian->stok,
        'jumlah'    => $jumlah_baru,
        'subtotal'  => $subtotal,
        'created_at'=> Carbon::now(),
    ]);

    return response()->json(['message' => 'Produk ditambahkan ke keranjang']);
}


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


  // =======================================================================
// --- [PERBAIKAN TOTAL] FUNGSI UPDATE (LOGIKA VARIAN) ---
// =======================================================================
public function update(Request $request, $id)
{
    // 1. Validasi jumlah
    $request->validate([
        'jumlah' => 'required|integer|min:1',
    ]);

    $id_user = $request->user()->id;

    // 2. Ambil item keranjang berdasarkan ID & user
    $item = DB::table('keranjang')
        ->where('id', $id)
        ->where('id_user', $id_user)
        ->first();

    if (!$item) {
        return response()->json([
            'message' => 'Item keranjang tidak ditemukan'
        ], 404);
    }

    // 3. Pastikan item keranjang punya varian
    if (empty($item->id_varian)) {
        return response()->json([
            'message' => 'Data keranjang lama tidak valid. Hapus dan tambahkan ulang.'
        ], 422);
    }

    // 4. Ambil varian dari tabel produk_varian
    $varian = DB::table('produk_varian')->find($item->id_varian);

    if (!$varian) {
        return response()->json([
            'message' => 'Varian produk ini sudah tidak ada'
        ], 404);
    }

    // 5. Cek stok varian
    if ($request->jumlah > $varian->stok) {
        return response()->json([
            'message' => 'Jumlah melebihi stok yang tersedia (Stok: ' . $varian->stok . ')'
        ], 422);
    }

    // 6. Hitung subtotal baru
    $subtotal = $item->harga * $request->jumlah;

    // 7. Update keranjang
    DB::table('keranjang')
        ->where('id', $id)
        ->update([
            'jumlah'      => $request->jumlah,
            'subtotal'    => $subtotal,
            'stok'        => $varian->stok, // simpan stok terbaru
            'updated_at'  => Carbon::now(),
        ]);

    return response()->json([
        'message' => 'Jumlah produk berhasil diperbarui'
    ]);
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