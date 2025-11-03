<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    // 🔹 GET: /api/produk
    public function index()
    {
        $produk = DB::table('produk')->get();
        return response()->json($produk);
    }

    // 🔹 GET: /api/produk/{id}
    public function show($id)
    {
        $produk = DB::table('produk')->where('id', $id)->first();

        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        return response()->json($produk);
    }

    public function showByToko($id_toko)
    {
        $produk = DB::table('produk')
            ->where('id_toko', $id_toko)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($produk->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada produk untuk toko ini'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Daftar produk berdasarkan toko',
            'data' => $produk
        ]);
    }

    // 🔹 POST: /api/produk
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_toko' => 'required|integer|exists:toko,id',
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|string',
            'harga' => 'required|numeric',
            'variasi' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'spesifikasi' => 'nullable|string',
            'lokasi' => 'nullable|string',
            'fitur' => 'nullable|string',
            'stok' => 'required|integer',
        ]);

        $data['created_at'] = now();
        $data['updated_at'] = now();

        $id = DB::table('produk')->insertGetId($data);

        return response()->json([
            'message' => 'Produk berhasil ditambahkan',
            'id' => $id
        ]);
    }

    // 🔹 PUT: /api/produk/{id}
    public function update(Request $request, $id)
    {
        $produk = DB::table('produk')->where('id', $id)->first();

        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        $data = $request->validate([
            'id_toko' => 'required|integer|exists:toko,id',
            'nama' => 'sometimes|string|max:255',
            'foto' => 'nullable|string',
            'harga' => 'sometimes|numeric',
            'variasi' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'spesifikasi' => 'nullable|string',
            'lokasi' => 'nullable|string',
            'fitur' => 'nullable|string',
            'stok' => 'sometimes|integer',
        ]);

        $data['updated_at'] = now();

        DB::table('produk')->where('id', $id)->update($data);

        return response()->json(['message' => 'Produk berhasil diperbarui']);
    }

    // 🔹 DELETE: /api/produk/{id}
    public function destroy($id)
    {
        $produk = DB::table('produk')->where('id', $id)->first();

        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        DB::table('produk')->where('id', $id)->delete();

        return response()->json(['message' => 'Produk berhasil dihapus']);
    }
}
