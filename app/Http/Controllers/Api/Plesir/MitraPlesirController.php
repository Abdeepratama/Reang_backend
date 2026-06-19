<?php

namespace App\Http\Controllers\Api\Plesir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// --- PERUBAHAN DI SINI: Panggil Model yang baru ---
use App\Models\MitraPlesir;
use App\Models\Role;
use Illuminate\Support\Facades\Storage;

class MitraPlesirController extends Controller
{
    public function registerMitra(Request $request)
    {
        $user = $request->user();

        // --- PERUBAHAN DI SINI: Gunakan MitraPlesir ---
        $cekPlesir = MitraPlesir::where('id_user', $user->id)->first();
        if ($cekPlesir) {
            return response()->json([
                'status' => false,
                'message' => 'Anda sudah terdaftar sebagai Mitra Plesir.'
            ], 400);
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kontak' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
        ]);

        // --- PERUBAHAN DI SINI: Gunakan MitraPlesir ---
        $mitra = MitraPlesir::create([
            'id_user' => $user->id,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'kontak' => $request->kontak,
            'deskripsi' => $request->deskripsi,
        ]);

        // Ganti 'adminplesir' dengan nama role yang ada di tabel 'roles'
        $roleMitra = Role::where('name', 'adminplesir')->first();

        if ($roleMitra && !$user->role->contains($roleMitra->id)) {
            $user->role()->attach($roleMitra->id);
        }

        return response()->json([
            'status' => true,
            'message' => 'Pendaftaran Mitra Plesir berhasil!',
            'data' => $mitra
        ], 201);
    }
    public function getProfil(Request $request)
    {
        $user = $request->user();

        // Cari data wisata milik user yang sedang login
        $mitra = MitraPlesir::where('id_user', $user->id)->first();

        if (!$mitra) {
            return response()->json([
                'status' => false,
                'message' => 'Data profil wisata tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mengambil profil wisata.',
            'data' => $mitra
        ], 200);
    }

    // =======================================================================
    // 2. UPDATE PROFIL MITRA (Bisa sekalian upload foto)
    // =======================================================================
    public function updateProfil(Request $request)
    {
        $user = $request->user();
        $mitra = MitraPlesir::where('id_user', $user->id)->first();

        if (!$mitra) {
            return response()->json([
                'status' => false,
                'message' => 'Akses ditolak atau data tidak ditemukan.'
            ], 404);
        }

        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kontak' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|max:2048', // Maksimal 2MB
        ]);

        // Cek jika user mengupload foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama di storage jika sebelumnya sudah ada
            if ($mitra->foto && Storage::disk('public')->exists($mitra->foto)) {
                Storage::disk('public')->delete($mitra->foto);
            }
            // Simpan foto baru ke folder 'mitra_plesir'
            $path = $request->file('foto')->store('mitra_plesir', 'public');
            $mitra->foto = $path; // Update path di database
        }

        // Update data teks lainnya
        $mitra->update([
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'kontak' => $validated['kontak'],
            'deskripsi' => $validated['deskripsi'] ?? $mitra->deskripsi,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Profil wisata berhasil diperbarui!',
            'data' => $mitra
        ], 200);
    }
}
