<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MitraWisata;
use App\Models\User; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MitraPlesirController extends Controller
{
public function store(Request $request)
{
    // 1. Validasi inputan dari Flutter
    $validator = Validator::make($request->all(), [
        'nama' => 'required|string|max:255',
        'alamat' => 'required|string',
        'kontak' => 'required|string|max:20',
        'deskripsi' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    // 2. Jalankan Transaksi Database
    DB::beginTransaction();

    try {
        // Langkah A: Simpan ke tabel mitra_wisata (TANPA USER_ID karena kolomnya tidak ada di DB)
        $mitra = MitraWisata::create([
            'nama_wisata' => $request->nama,
            'alamat' => $request->alamat,
            'no_whatsapp' => $request->kontak, 
            'deskripsi' => $request->deskripsi,
            'status' => 'pending', // Default status sesuai database
        ]);
        
        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran mitra berhasil! Data testing sukses masuk.',
            'data' => $mitra
        ], 201);

    } catch (\Exception $e) {
        DB::rollback();

        return response()->json([
            'success' => false,
            'message' => 'Gagal memproses pendaftaran mitra.',
            'error' => $e->getMessage() // Membantu membaca jika ada kendala lain
        ], 500);
    }
}
}