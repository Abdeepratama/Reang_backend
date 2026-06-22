<?php

namespace App\Http\Controllers\Api\Plesir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MetodePembayaranPlesir;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MetodePembayaranPlesirController extends Controller
{
    /**
     * Helper untuk mengambil ID Profil Mitra berdasarkan User yang sedang login.
     * Mengambil nilai 'id' (contoh: 2), bukan 'id_user' (contoh: 21).
     */
    private function getMitraIdFromLogin(Request $request)
    {
        // Pastikan nama tabel 'mitra_plesir' ini sudah sesuai dengan nama tabel profil mitra di database kamu
        $mitra = DB::table('mitra_plesir')->where('id_user', $request->user()->id)->first();
        return $mitra ? $mitra->id : null;
    }

    // --- 1. AMBIL SEMUA METODE PEMBAYARAN MITRA (DASHBOARD ADMIN) ---
    public function index(Request $request)
    {
        $idMitra = $this->getMitraIdFromLogin($request);

        if (!$idMitra) {
            return response()->json(['status' => 'success', 'data' => []]);
        }

        $metode = MetodePembayaranPlesir::where('id_mitra', $idMitra)
            ->orderBy('created_at', 'desc')
            ->get();

        $metode->transform(function ($item) {
            if ($item->foto_qris) {
                $item->foto_qris_url = url('storage/' . $item->foto_qris);
            } else {
                $item->foto_qris_url = null;
            }
            return $item;
        });

        return response()->json(['status' => 'success', 'data' => $metode]);
    }

    // --- 2. TAMBAH METODE BARU ---
    public function store(Request $request)
    {
        $idMitra = $this->getMitraIdFromLogin($request);

        if (!$idMitra) {
            return response()->json([
                'status' => 'error',
                'message' => 'Profil mitra tidak ditemukan. Silakan lengkapi profil terlebih dahulu.'
            ], 404);
        }

        $request->validate([
            'nama_metode' => 'required|string|max:255',
            'jenis_metode' => 'required|in:Transfer Bank,QRIS,COD',
            'nama_penerima' => 'nullable|string|max:255',
            'nomor_rekening' => 'nullable|string|max:100',
            'file_qris' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['nama_metode', 'jenis_metode', 'nama_penerima', 'nomor_rekening']);
        $data['id_mitra'] = $idMitra; // 👈 SEKARANG OTOMATIS MENYIMPAN ID MITRA (CONTOH: 2)

        if ($request->jenis_metode === 'QRIS' && $request->hasFile('file_qris')) {
            $path = $request->file('file_qris')->store('plesir/qris', 'public');
            $data['foto_qris'] = $path;
        }

        $metode = MetodePembayaranPlesir::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Metode pembayaran berhasil ditambahkan',
            'data' => $metode
        ]);
    }

    // --- 3. UBAH METODE (EDIT) ---
    public function update(Request $request, $id)
    {
        $idMitra = $this->getMitraIdFromLogin($request);

        if (!$idMitra) {
            return response()->json(['status' => 'error', 'message' => 'Akses ditolak.'], 403);
        }

        $metode = MetodePembayaranPlesir::where('id_mitra', $idMitra)->findOrFail($id);

        $request->validate([
            'nama_metode' => 'required|string|max:255',
            'jenis_metode' => 'required|in:Transfer Bank,QRIS,COD',
            'nama_penerima' => 'nullable|string|max:255',
            'nomor_rekening' => 'nullable|string|max:100',
            'file_qris' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['nama_metode', 'jenis_metode', 'nama_penerima', 'nomor_rekening']);

        if ($request->jenis_metode !== 'QRIS') {
            if ($metode->foto_qris) {
                Storage::disk('public')->delete($metode->foto_qris);
            }
            $data['foto_qris'] = null;
        } else if ($request->hasFile('file_qris')) {
            if ($metode->foto_qris) {
                Storage::disk('public')->delete($metode->foto_qris);
            }
            $data['foto_qris'] = $request->file('file_qris')->store('plesir/qris', 'public');
        }

        $metode->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Metode pembayaran berhasil diperbarui',
            'data' => $metode
        ]);
    }

    // --- 4. HAPUS METODE ---
    public function destroy(Request $request, $id)
    {
        $idMitra = $this->getMitraIdFromLogin($request);

        if (!$idMitra) {
            return response()->json(['status' => 'error', 'message' => 'Akses ditolak.'], 403);
        }

        $metode = MetodePembayaranPlesir::where('id_mitra', $idMitra)->findOrFail($id);

        if ($metode->foto_qris) {
            Storage::disk('public')->delete($metode->foto_qris);
        }

        $metode->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Metode pembayaran berhasil dihapus'
        ]);
    }

    // --- 5. AMBIL METODE PEMBAYARAN UNTUK CHECKOUT PEMBELI ---
    public function getMetodeForCheckout(Request $request)
    {
        $kategori = $request->query('kategori');
        $targetId = $request->query('target_id');

        $mitraId = null;

        if ($kategori == 'wisata') {
            $wisata = DB::table('tiket_wisata')->where('id', $targetId)->first();
            if ($wisata) {
                $mitraId = $wisata->id_mitra;
            }
        } elseif ($kategori == 'event') {
            $event = DB::table('tiket_event')->where('id', $targetId)->first();
            if ($event) {
                $mitraId = $event->id_mitra;
            }
        }

        if (!$mitraId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data mitra penjual tidak ditemukan.'
            ], 404);
        }

        $metode = MetodePembayaranPlesir::where('id_mitra', $mitraId)
            ->where('is_active', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        $metode->transform(function ($item) {
            if ($item->foto_qris) {
                $item->foto_qris_url = url('storage/' . $item->foto_qris);
            } else {
                $item->foto_qris_url = null;
            }
            return $item;
        });

        return response()->json([
            'status' => 'success',
            'data' => $metode
        ]);
    }
}
