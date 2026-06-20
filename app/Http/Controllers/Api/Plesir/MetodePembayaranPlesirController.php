<?php

namespace App\Http\Controllers\Api\Plesir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MetodePembayaranPlesir;
use Illuminate\Support\Facades\Storage;

class MetodePembayaranPlesirController extends Controller
{
    // --- 1. AMBIL SEMUA METODE PEMBAYARAN MITRA ---
    public function index(Request $request)
    {
        $metode = MetodePembayaranPlesir::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Manipulasi URL gambar agar bisa dibaca langsung oleh Flutter
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
        $request->validate([
            'nama_metode' => 'required|string|max:255',
            'jenis_metode' => 'required|in:Transfer Bank,QRIS,COD',
            'nama_penerima' => 'nullable|string|max:255',
            'nomor_rekening' => 'nullable|string|max:100',
            'file_qris' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        $data = $request->only(['nama_metode', 'jenis_metode', 'nama_penerima', 'nomor_rekening']);
        $data['user_id'] = $request->user()->id;

        // Tangani upload gambar jika jenisnya QRIS dan file dikirim
        if ($request->jenis_metode === 'QRIS' && $request->hasFile('file_qris')) {
            $path = $request->file('file_qris')->store('plesir/qris', 'public');
            $data['foto_qris'] = $path;
        }

        $metode = MetodePembayaranPlesir::create($data);

        return response()->json(['status' => 'success', 'message' => 'Metode pembayaran berhasil ditambahkan', 'data' => $metode]);
    }

    // --- 3. UBAH METODE (EDIT) ---
    public function update(Request $request, $id)
    {
        $metode = MetodePembayaranPlesir::where('user_id', $request->user()->id)->findOrFail($id);

        $request->validate([
            'nama_metode' => 'required|string|max:255',
            'jenis_metode' => 'required|in:Transfer Bank,QRIS,COD',
            'nama_penerima' => 'nullable|string|max:255',
            'nomor_rekening' => 'nullable|string|max:100',
            'file_qris' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['nama_metode', 'jenis_metode', 'nama_penerima', 'nomor_rekening']);

        // Jika metode diubah menjadi SELAIN QRIS, hapus gambar lama agar storage tidak penuh
        if ($request->jenis_metode !== 'QRIS') {
            if ($metode->foto_qris) {
                Storage::disk('public')->delete($metode->foto_qris);
            }
            $data['foto_qris'] = null;
        }
        // Jika ada upload gambar QRIS baru, hapus yang lama lalu simpan yang baru
        else if ($request->hasFile('file_qris')) {
            if ($metode->foto_qris) {
                Storage::disk('public')->delete($metode->foto_qris);
            }
            $data['foto_qris'] = $request->file('file_qris')->store('plesir/qris', 'public');
        }

        $metode->update($data);

        return response()->json(['status' => 'success', 'message' => 'Metode pembayaran berhasil diperbarui', 'data' => $metode]);
    }

    // --- 4. HAPUS METODE ---
    public function destroy(Request $request, $id)
    {
        $metode = MetodePembayaranPlesir::where('user_id', $request->user()->id)->findOrFail($id);

        // Bersihkan gambar di storage jika ada
        if ($metode->foto_qris) {
            Storage::disk('public')->delete($metode->foto_qris);
        }

        $metode->delete();

        return response()->json(['status' => 'success', 'message' => 'Metode pembayaran berhasil dihapus']);
    }
}
