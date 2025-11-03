<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TokoController extends Controller
{
    // GET /api/toko — Ambil semua data toko
    public function index()
    {
        $toko = Toko::orderBy('created_at', 'desc')->get();

        return response()->json([
            'status' => true,
            'message' => 'Daftar toko berhasil diambil',
            'data' => $toko
        ]);
    }

    // GET /api/toko/{id} — Ambil detail toko
    public function show($id)
    {
        $toko = Toko::find($id);

        if (!$toko) {
            return response()->json([
                'status' => false,
                'message' => 'Data toko tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail toko berhasil diambil',
            'data' => $toko
        ]);
    }

    // POST /api/toko — Tambah toko baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('toko', 'public');
        }

        // 🔹 Simpan data toko
        $toko = Toko::create($data);

        // 🔹 Ambil user yang sedang login
        $user = $request->user();

        // 🔹 Cari role admin_umkm
        $adminUmkmRole = \App\Models\Role::where('name', 'admin_umkm')->first();

        // 🔹 Jika belum punya role admin_umkm, tambahkan
        if ($adminUmkmRole && !$user->role->contains($adminUmkmRole->id)) {
            $user->role()->attach($adminUmkmRole->id);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data toko berhasil ditambahkan & role admin_umkm diberikan',
            'data' => $toko
        ], 201);
    }

    // PUT /api/toko/{id} — Update data toko
    public function update(Request $request, $id)
    {
        $toko = Toko::find($id);

        if (!$toko) {
            return response()->json([
                'status' => false,
                'message' => 'Data toko tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($toko->foto && Storage::disk('public')->exists($toko->foto)) {
                Storage::disk('public')->delete($toko->foto);
            }
            $data['foto'] = $request->file('foto')->store('toko', 'public');
        }

        $toko->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Data toko berhasil diperbarui',
            'data' => $toko
        ]);
    }

    // DELETE /api/toko/{id} — Hapus toko
    public function destroy($id)
    {
        $toko = Toko::find($id);

        if (!$toko) {
            return response()->json([
                'status' => false,
                'message' => 'Data toko tidak ditemukan'
            ], 404);
        }

        if ($toko->foto && Storage::disk('public')->exists($toko->foto)) {
            Storage::disk('public')->delete($toko->foto);
        }

        $toko->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data toko berhasil dihapus'
        ]);
    }
}
