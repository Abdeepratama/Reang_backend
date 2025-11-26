<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Ongkir; 
use App\Models\MetodePembayaran;


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

        // 🔹 Ambil user yang sedang login
        $user = $request->user();

        // 🔹 Siapkan data dengan id_user otomatis
        $data = $request->only(['nama', 'deskripsi', 'alamat', 'no_hp']);
        $data['id_user'] = $user->id;

        // 🔹 Upload foto jika ada
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('toko', 'public');
        }

        // 🔹 Simpan data toko
        $toko = Toko::create($data);

        // 🔹 Ubah role user dari 1 (user biasa) menjadi 2 (umkm)
        $adminUmkmRole = \App\Models\Role::where('name', 'umkm')->first();

        if ($adminUmkmRole && !$user->role->contains($adminUmkmRole->id)) {
            $user->role()->attach($adminUmkmRole->id);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data toko berhasil ditambahkan & role umkm diberikan',
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

    public function cekKelengkapan(Request $request, $id_toko)
    {
        $user = $request->user();

        // 1. Validasi Pemilik Toko
        // Menggunakan Model Toko
        $toko = Toko::where('id', $id_toko)->first();
        
        if (!$toko || $toko->id_user != $user->id) {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }

        // 2. Cek apakah sudah ada Ongkir?
        // Menggunakan Model Ongkir
        $hasOngkir = Ongkir::where('id_toko', $id_toko)->exists();

        // 3. Cek apakah sudah ada Metode Pembayaran?
        // Menggunakan Model MetodePembayaran
        $hasMetode = MetodePembayaran::where('id_toko', $id_toko)->exists();

        return response()->json([
            'status' => true,
            'data' => [
                'has_ongkir' => $hasOngkir,
                'has_metode' => $hasMetode,
                // Toko siap JIKA ongkir ada DAN metode ada
                'is_ready' => $hasOngkir && $hasMetode 
            ]
        ]);
    }
}