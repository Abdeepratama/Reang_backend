<?php

namespace App\Http\Controllers\Api\Plesir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MitraPlesir;
use App\Models\TiketWisata;
use App\Models\GaleriWisata;
use Illuminate\Support\Facades\Storage;

class TiketWisataController extends Controller
{
    public function createWisata(Request $request)
    {
        $user = $request->user();

        // 1. KUNCI KEAMANAN: Cari id_mitra dari user yang sedang login
        $mitra = MitraPlesir::where('id_user', $user->id)->first();

        if (!$mitra) {
            return response()->json([
                'status' => false,
                'message' => 'Akses ditolak. Anda belum terdaftar sebagai Mitra Wisata.'
            ], 403);
        }

        // 2. Validasi Input
        $request->validate([
            'nama_wisata' => 'required|string|max:255',
            'kategori_wisata' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'fasilitas' => 'nullable|array', // Di Flutter kita kirim sebagai array
            'alamat' => 'required|string',
            'jam_operasional' => 'required|string|max:100',
            'harga_tiket' => 'required|integer|min:0',
            'kuota_per_hari' => 'required|integer|min:1',
            'foto_utama' => 'required|image|max:2048',
            'galeri_foto.*' => 'nullable|image|max:2048', // Validasi setiap foto di array galeri
        ]);

        try {
            // 3. Upload Foto Utama
            $fotoUtamaPath = null;
            if ($request->hasFile('foto_utama')) {
                $fotoUtamaPath = $request->file('foto_utama')->store('tiket_wisata/utama', 'public');
            }

            // 4. Simpan Data Utama ke database `tiket_wisata`
            $tiket = TiketWisata::create([
                'id_mitra' => $mitra->id, // <--- TERKUNCI DENGAN ID MITRA
                'nama_wisata' => $request->nama_wisata,
                'kategori_wisata' => $request->kategori_wisata,
                'deskripsi' => $request->deskripsi,
                'fasilitas' => $request->fasilitas,
                'alamat' => $request->alamat,
                'jam_operasional' => $request->jam_operasional,
                'harga_tiket' => $request->harga_tiket,
                'kuota_per_hari' => $request->kuota_per_hari,
                'foto_utama' => $fotoUtamaPath,
            ]);

            // 5. Upload & Simpan Galeri Foto (Jika Ada)
            if ($request->hasFile('galeri_foto')) {
                foreach ($request->file('galeri_foto') as $foto) {
                    $path = $foto->store('tiket_wisata/galeri', 'public');
                    GaleriWisata::create([
                        'id_tiket_wisata' => $tiket->id,
                        'foto' => $path,
                    ]);
                }
            }

            // Load data galeri agar ikut tampil di respons JSON
            $tiket->load('galeri');

            return response()->json([
                'status' => true,
                'message' => 'Tiket destinasi wisata berhasil dibuat!',
                'data' => $tiket
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    // =======================================================================
    // 2. UPDATE TIKET WISATA
    // =======================================================================
    public function updateWisata(Request $request, $id)
    {
        $user = $request->user();
        $mitra = MitraPlesir::where('id_user', $user->id)->first();

        if (!$mitra) {
            return response()->json(['status' => false, 'message' => 'Akses ditolak.'], 403);
        }

        // Cari tiket dan pastikan tiket ini milik mitra yang sedang login
        $tiket = TiketWisata::where('id', $id)->where('id_mitra', $mitra->id)->first();

        if (!$tiket) {
            return response()->json(['status' => false, 'message' => 'Tiket tidak ditemukan atau Anda tidak memiliki akses.'], 404);
        }

        $request->validate([
            'nama_wisata' => 'required|string|max:255',
            'kategori_wisata' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'fasilitas' => 'nullable|array',
            'alamat' => 'required|string',
            'jam_operasional' => 'required|string|max:100',
            'harga_tiket' => 'required|integer|min:0',
            'kuota_per_hari' => 'required|integer|min:1',
            'foto_utama' => 'nullable|image|max:2048', // Boleh kosong kalau tidak ganti foto
            'galeri_foto.*' => 'nullable|image|max:2048',
            'hapus_galeri' => 'nullable|array', // Array ID foto galeri yang mau dihapus
        ]);

        try {
            // 1. Update Foto Utama (Jika ada upload baru)
            if ($request->hasFile('foto_utama')) {
                // Hapus foto lama dari storage
                if ($tiket->foto_utama && Storage::disk('public')->exists($tiket->foto_utama)) {
                    Storage::disk('public')->delete($tiket->foto_utama);
                }
                // Simpan foto baru
                $tiket->foto_utama = $request->file('foto_utama')->store('tiket_wisata/utama', 'public');
            }

            // 2. Update Data Teks
            $tiket->update([
                'nama_wisata' => $request->nama_wisata,
                'kategori_wisata' => $request->kategori_wisata,
                'deskripsi' => $request->deskripsi,
                'fasilitas' => $request->fasilitas,
                'alamat' => $request->alamat,
                'jam_operasional' => $request->jam_operasional,
                'harga_tiket' => $request->harga_tiket,
                'kuota_per_hari' => $request->kuota_per_hari,
            ]);

            // 3. Hapus Foto Galeri yang dipilih user (lewat array hapus_galeri)
            if ($request->has('hapus_galeri')) {
                $galeriDihapus = GaleriWisata::whereIn('id', $request->hapus_galeri)
                    ->where('id_tiket_wisata', $tiket->id)
                    ->get();
                foreach ($galeriDihapus as $foto) {
                    if (Storage::disk('public')->exists($foto->foto)) {
                        Storage::disk('public')->delete($foto->foto); // Hapus file fisik
                    }
                    $foto->delete(); // Hapus dari database
                }
            }

            // 4. Tambah Foto Galeri Baru (Jika ada)
            if ($request->hasFile('galeri_foto')) {
                foreach ($request->file('galeri_foto') as $foto) {
                    $path = $foto->store('tiket_wisata/galeri', 'public');
                    GaleriWisata::create([
                        'id_tiket_wisata' => $tiket->id,
                        'foto' => $path,
                    ]);
                }
            }

            $tiket->load('galeri');

            return response()->json([
                'status' => true,
                'message' => 'Data wisata berhasil diperbarui!',
                'data' => $tiket
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // =======================================================================
    // 3. DELETE TIKET WISATA
    // =======================================================================
    public function deleteWisata(Request $request, $id)
    {
        $user = $request->user();
        $mitra = MitraPlesir::where('id_user', $user->id)->first();

        if (!$mitra) {
            return response()->json(['status' => false, 'message' => 'Akses ditolak.'], 403);
        }

        // Pastikan tiket milik mitra yang sedang login
        $tiket = TiketWisata::where('id', $id)->where('id_mitra', $mitra->id)->first();

        if (!$tiket) {
            return response()->json(['status' => false, 'message' => 'Tiket tidak ditemukan.'], 404);
        }

        try {
            // 1. Hapus Foto Utama dari storage
            if ($tiket->foto_utama && Storage::disk('public')->exists($tiket->foto_utama)) {
                Storage::disk('public')->delete($tiket->foto_utama);
            }

            // 2. Hapus semua foto Galeri dari storage
            $galeris = GaleriWisata::where('id_tiket_wisata', $tiket->id)->get();
            foreach ($galeris as $galeri) {
                if (Storage::disk('public')->exists($galeri->foto)) {
                    Storage::disk('public')->delete($galeri->foto);
                }
            }

            // 3. Hapus data dari database (Galeri akan ikut terhapus otomatis kalau pakai Eloquent relasi, 
            // tapi amannya kita delete tiketnya, karena database akan cascade jika disetting)
            $tiket->delete();

            return response()->json([
                'status' => true,
                'message' => 'Tiket destinasi wisata beserta semua fotonya berhasil dihapus!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus tiket.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
