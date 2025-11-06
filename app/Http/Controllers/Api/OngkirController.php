<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ongkir;
use Illuminate\Http\Request;

class OngkirController extends Controller
{
    // GET /api/ongkir/{id_toko}
    public function index($id_toko)
    {
        $data = Ongkir::where('id_toko', $id_toko)
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Daftar ongkir berhasil diambil',
            'data' => $data
        ]);
    }

    // GET /api/ongkir/detail/{id}
    public function show($id)
    {
        $ongkir = Ongkir::find($id);
        if (!$ongkir) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json(['status' => true, 'data' => $ongkir]);
    }

    // POST /api/ongkir
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_toko' => 'required|integer',
            'daerah' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        $ongkir = Ongkir::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Data ongkir berhasil ditambahkan',
            'data' => $ongkir
        ], 201);
    }

    // PUT /api/ongkir/{id}
    public function update(Request $request, $id)
    {
        $ongkir = Ongkir::find($id);
        if (!$ongkir) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'daerah' => 'sometimes|required|string|max:255',
            'harga' => 'sometimes|required|numeric|min:0',
        ]);

        $ongkir->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Data ongkir berhasil diperbarui',
            'data' => $ongkir
        ]);
    }

    // DELETE /api/ongkir/{id}
    public function destroy($id)
    {
        $ongkir = Ongkir::find($id);
        if (!$ongkir) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $ongkir->delete();

        return response()->json(['status' => true, 'message' => 'Data ongkir berhasil dihapus']);
    }
}