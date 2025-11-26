<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MetodePembayaran;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MetodePembayaranController extends Controller
{
    public function index()
    {
        $data = MetodePembayaran::orderBy('id', 'asc')->get();

        // Tambahkan URL lengkap untuk foto
        $data->transform(function ($item) {
            if ($item->foto_qris) {
                $item->foto_qris = asset('storage/' . $item->foto_qris);
            }
            return $item;
        });

        return response()->json([
            'status' => true,
            'message' => 'Daftar metode pembayaran berhasil diambil',
            'data' => $data
        ]);
    }

    public function show($id_toko)
    {
        $metode = MetodePembayaran::where('id_toko', $id_toko)
            ->orderBy('id', 'asc')
            ->get();

        // Ubah URL foto jadi full URL
        $metode->transform(function ($item) {
            if ($item->foto_qris) {
                $item->foto_qris = asset('storage/' . $item->foto_qris);
            }
            return $item;
        });

        return response()->json([
            'status' => true,
            'message' => 'Metode pembayaran toko berhasil diambil',
            'data' => $metode // Jika kosong, ini akan berisi [], dan Flutter akan senang.
        ]);
    }

    // 🔹 POST /api/toko/{id_toko}/metode
    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user->hasRole('umkm') && !$user->hasRole('superadmin')) {
            return response()->json(['status' => false, 'message' => 'Akses ditolak!'], 403);
        }

        $validated = $request->validate([
            'id_toko' => 'required|integer',
            'nama_metode' => 'required|string|max:255',
            'jenis' => 'required|in:bank,qris,cod',
            'nama_penerima' => 'nullable|string|max:255',
            'nomor_tujuan' => 'nullable|string|max:255',
            'foto_qris' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        if ($request->hasFile('foto_qris')) {
            $validated['foto_qris'] = $request->file('foto_qris')->store('qris', 'public');
        }

        $metode = MetodePembayaran::create($validated);

        if ($metode->foto_qris) {
            $metode->foto_qris = asset('storage/' . $metode->foto_qris);
        }

        return response()->json([
            'status' => true,
            'message' => 'Metode pembayaran berhasil ditambahkan',
            'data' => $metode
        ], 201);
    }

    // 🔹 PUT /api/toko/{id_toko}/metode/{id}
    public function update(Request $request, $id_toko, $id)
    {
        $user = $request->user();

        if (!$user->hasRole('umkm') && !$user->hasRole('superadmin')) {
            return response()->json(['status' => false, 'message' => 'Akses ditolak!'], 403);
        }

        $metode = MetodePembayaran::where('id_toko', $id_toko)->find($id);
        if (!$metode) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'nama_metode' => 'sometimes|required|string|max:255',
            'jenis' => 'sometimes|required|in:bank,qris,cod',
            'nama_penerima' => 'nullable|string|max:255',
            'nomor_tujuan' => 'nullable|string|max:255',
            'foto_qris' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        if ($request->hasFile('foto_qris')) {
            if ($metode->foto_qris && Storage::disk('public')->exists($metode->foto_qris)) {
                Storage::disk('public')->delete($metode->foto_qris);
            }
            $path = $request->file('foto_qris')->store('qris', 'public');
            $validated['foto_qris'] = $path;
        }

        $metode->update($validated);

        if ($metode->foto_qris) {
            $metode->foto_qris = asset('storage/' . $metode->foto_qris);
        }

        return response()->json([
            'status' => true,
            'message' => 'Metode pembayaran berhasil diperbarui',
            'data' => $metode
        ]);
    }

    // 🔹 DELETE /api/toko/{id_toko}/metode/{id}
    public function destroy(Request $request, $id_toko, $id)
    {
        $user = $request->user();

        if (!$user->hasRole('umkm') && !$user->hasRole('superadmin')) {
            return response()->json(['status' => false, 'message' => 'Akses ditolak!'], 403);
        }

        $metode = MetodePembayaran::where('id_toko', $id_toko)->find($id);
        if (!$metode) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        if ($metode->foto_qris && Storage::disk('public')->exists($metode->foto_qris)) {
            Storage::disk('public')->delete($metode->foto_qris);
        }

        $metode->delete();

        return response()->json(['status' => true, 'message' => 'Metode pembayaran berhasil dihapus']);
    }
}