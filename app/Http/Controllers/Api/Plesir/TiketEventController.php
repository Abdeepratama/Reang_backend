<?php

namespace App\Http\Controllers\Api\Plesir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MitraPlesir;
use App\Models\TiketEvent;
use App\Models\GaleriEvent;
use App\Models\VarianTiketEvent;
use App\Models\TiketWisata;
use Illuminate\Support\Facades\Storage;

class TiketEventController extends Controller
{
    // =======================================================================
    // 1. CREATE EVENT
    // =======================================================================
    public function createEvent(Request $request)
    {
        $user = $request->user();
        $mitra = MitraPlesir::where('id_user', $user->id)->first();

        if (!$mitra) {
            return response()->json(['status' => false, 'message' => 'Akses ditolak.'], 403);
        }

        $request->validate([
            'nama_event' => 'required|string|max:255',
            'kategori_event' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string',
            'tanggal_event' => 'required|date',
            'jam_event' => 'required|string|max:100',
            'foto_utama' => 'required|image|max:2048',
            'galeri_foto.*' => 'nullable|image|max:2048',
            'detail_tiket' => 'required|string', // Dikirim dari Flutter via jsonEncode
        ]);

        try {
            // 1. Upload Foto Utama
            $fotoUtamaPath = $request->file('foto_utama')->store('tiket_event/utama', 'public');

            // 2. Insert Data Master Event
            $event = TiketEvent::create([
                'id_mitra' => $mitra->id,
                'nama_event' => $request->nama_event,
                'kategori_event' => $request->kategori_event,
                'deskripsi' => $request->deskripsi,
                'lokasi' => $request->lokasi,
                'tanggal_event' => $request->tanggal_event,
                'jam_event' => $request->jam_event,
                'foto_utama' => $fotoUtamaPath,
            ]);

            // 3. Insert Varian Tiket (Decode JSON dari request)
            $detailTiket = json_decode($request->detail_tiket, true);
            if (is_array($detailTiket)) {
                foreach ($detailTiket as $tiket) {
                    VarianTiketEvent::create([
                        'id_tiket_event' => $event->id,
                        'nama_kelas' => $tiket['nama_kelas'],
                        'harga' => $tiket['harga'],
                        'kuota' => $tiket['kuota'],
                    ]);
                }
            }

            // 4. Upload & Simpan Galeri (Jika Ada)
            if ($request->hasFile('galeri_foto')) {
                foreach ($request->file('galeri_foto') as $foto) {
                    $path = $foto->store('tiket_event/galeri', 'public');
                    GaleriEvent::create([
                        'id_tiket_event' => $event->id,
                        'foto' => $path,
                    ]);
                }
            }

            $event->load(['varians', 'galeri']);

            return response()->json([
                'status' => true,
                'message' => 'Event berhasil dibuat!',
                'data' => $event
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal membuat event.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // =======================================================================
    // 2. UPDATE EVENT
    // =======================================================================
    public function updateEvent(Request $request, $id)
    {
        $user = $request->user();
        $mitra = MitraPlesir::where('id_user', $user->id)->first();

        if (!$mitra) {
            return response()->json(['status' => false, 'message' => 'Akses ditolak.'], 403);
        }

        $event = TiketEvent::where('id', $id)->where('id_mitra', $mitra->id)->first();
        if (!$event) {
            return response()->json(['status' => false, 'message' => 'Event tidak ditemukan.'], 404);
        }

        $request->validate([
            'nama_event' => 'required|string|max:255',
            'kategori_event' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string',
            'tanggal_event' => 'required|date',
            'jam_event' => 'required|string|max:100',
            'foto_utama' => 'nullable|image|max:2048',
            'galeri_foto.*' => 'nullable|image|max:2048',
            'hapus_galeri' => 'nullable|array',
            'detail_tiket' => 'required|string',
        ]);

        try {
            // 1. Update Foto Utama
            if ($request->hasFile('foto_utama')) {
                if ($event->foto_utama && Storage::disk('public')->exists($event->foto_utama)) {
                    Storage::disk('public')->delete($event->foto_utama);
                }
                $event->foto_utama = $request->file('foto_utama')->store('tiket_event/utama', 'public');
            }

            // 2. Update Master Data
            $event->update([
                'nama_event' => $request->nama_event,
                'kategori_event' => $request->kategori_event,
                'deskripsi' => $request->deskripsi,
                'lokasi' => $request->lokasi,
                'tanggal_event' => $request->tanggal_event,
                'jam_event' => $request->jam_event,
            ]);

            // 3. Update Varian Tiket
            // Untuk amannya, kita hapus varian lama yang tidak ada transaksinya dan insert baru.
            // (Atau menghapus semuanya lalu insert ulang agar tidak duplikat)
            VarianTiketEvent::where('id_tiket_event', $event->id)->delete();
            $detailTiket = json_decode($request->detail_tiket, true);
            if (is_array($detailTiket)) {
                foreach ($detailTiket as $tiket) {
                    VarianTiketEvent::create([
                        'id_tiket_event' => $event->id,
                        'nama_kelas' => $tiket['nama_kelas'],
                        'harga' => $tiket['harga'],
                        'kuota' => $tiket['kuota'],
                    ]);
                }
            }

            // 4. Hapus Galeri Terpilih
            if ($request->has('hapus_galeri')) {
                $galeriDihapus = GaleriEvent::whereIn('id', $request->hapus_galeri)->where('id_tiket_event', $event->id)->get();
                foreach ($galeriDihapus as $foto) {
                    if (Storage::disk('public')->exists($foto->foto)) Storage::disk('public')->delete($foto->foto);
                    $foto->delete();
                }
            }

            // 5. Tambah Galeri Baru
            if ($request->hasFile('galeri_foto')) {
                foreach ($request->file('galeri_foto') as $foto) {
                    $path = $foto->store('tiket_event/galeri', 'public');
                    GaleriEvent::create([
                        'id_tiket_event' => $event->id,
                        'foto' => $path,
                    ]);
                }
            }

            $event->load(['varians', 'galeri']);

            return response()->json([
                'status' => true,
                'message' => 'Data event berhasil diperbarui!',
                'data' => $event
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui event.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // =======================================================================
    // 3. DELETE EVENT
    // =======================================================================
    public function deleteEvent(Request $request, $id)
    {
        $user = $request->user();
        $mitra = MitraPlesir::where('id_user', $user->id)->first();

        if (!$mitra) return response()->json(['status' => false, 'message' => 'Akses ditolak.'], 403);

        $event = TiketEvent::where('id', $id)->where('id_mitra', $mitra->id)->first();
        if (!$event) return response()->json(['status' => false, 'message' => 'Event tidak ditemukan.'], 404);

        try {
            // Hapus Foto Utama
            if ($event->foto_utama && Storage::disk('public')->exists($event->foto_utama)) {
                Storage::disk('public')->delete($event->foto_utama);
            }

            // Hapus Foto Galeri
            $galeris = GaleriEvent::where('id_tiket_event', $event->id)->get();
            foreach ($galeris as $galeri) {
                if (Storage::disk('public')->exists($galeri->foto)) {
                    Storage::disk('public')->delete($galeri->foto);
                }
            }

            // Hapus Data (Varian dan Galeri akan ikut terhapus otomatis jika pakai foreign key cascade, 
            // tapi kita hapus manual untuk varian agar bersih)
            VarianTiketEvent::where('id_tiket_event', $event->id)->delete();
            $event->delete();

            return response()->json([
                'status' => true,
                'message' => 'Event beserta semua tiket dan foto berhasil dihapus!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus event.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    // =======================================================================
    // 4. GET TIKET KU (WISATA & EVENT MILIK MITRA)
    // =======================================================================
    public function getTiketKu(Request $request)
    {
        $user = $request->user();

        // Cari ID mitra berdasarkan user yang login
        $mitra = MitraPlesir::where('id_user', $user->id)->first();

        if (!$mitra) {
            return response()->json([
                'status' => false,
                'message' => 'Akses ditolak. Anda belum terdaftar sebagai Mitra Wisata.'
            ], 403);
        }

        try {
            // 1. Ambil semua data Wisata milik mitra ini beserta Galerinya
            $wisata = TiketWisata::with('galeri')
                ->where('id_mitra', $mitra->id)
                ->orderBy('created_at', 'desc')
                ->get();

            // 2. Ambil semua data Event milik mitra ini beserta Varian dan Galerinya
            $event = TiketEvent::with(['varians', 'galeri'])
                ->where('id_mitra', $mitra->id)
                ->orderBy('created_at', 'desc')
                ->get();

            // 3. Gabungkan keduanya dalam satu response JSON
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengambil daftar tiket mitra',
                'data' => [
                    'wisata' => $wisata,
                    'event' => $event
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil data tiket.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
