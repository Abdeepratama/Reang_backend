<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    public function index()
    {
        return response()->json(Umkm::with('produk')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'foto' => 'nullable|string',
        ]);

        $umkm = Umkm::create($data);
        return response()->json($umkm);
    }

    public function show($id)
    {
        $umkm = Umkm::with('produk')->findOrFail($id);
        return response()->json($umkm);
    }

    public function update(Request $request, $id)
    {
        $umkm = Umkm::findOrFail($id);
        $umkm->update($request->all());
        return response()->json($umkm);
    }

    public function destroy($id)
    {
        Umkm::destroy($id);
        return response()->json(['message' => 'UMKM deleted']);
    }
}
