<?php

namespace App\Http\Controllers\Api\Plesir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TiketWisata;
use App\Models\TiketEvent;

class UserPlesirController extends Controller
{
    // =======================================================================
    // GET EXPLORE PLESIR (UNTUK HALAMAN USER PEMBELI)
    // =======================================================================
    public function explore(Request $request)
    {
        try {
            // Tangkap parameter pencarian dari URL (Contoh: /api/plesir/explore?search=pantai)
            $search = $request->query('search');

            // 1. Query Wisata
            // Ambil yang is_active = 1, jika ada $search, cari berdasarkan nama atau kategori
            $wisata = TiketWisata::with('galeri')
                ->where('is_active', 1)
                ->when($search, function ($query, $search) {
                    return $query->where(function ($q) use ($search) {
                        $q->where('nama_wisata', 'like', "%{$search}%")
                            ->orWhere('kategori_wisata', 'like', "%{$search}%")
                            ->orWhere('alamat', 'like', "%{$search}%");
                    });
                })
                ->orderBy('created_at', 'desc')
                ->get();

            // 2. Query Event
            $event = TiketEvent::with(['varians', 'galeri'])
                ->where('is_active', 1)
                // 👇 INI DIA KUNCI RAHASIANYA: Hanya ambil event yang belum lewat tanggalnya!
                ->whereDate('tanggal_event', '>=', now())
                ->when($search, function ($query, $search) {
                    return $query->where(function ($q) use ($search) {
                        $q->where('nama_event', 'like', "%{$search}%")
                            ->orWhere('kategori_event', 'like', "%{$search}%")
                            ->orWhere('lokasi', 'like', "%{$search}%");
                    });
                })
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengambil data explore Plesir',
                'data' => [
                    'wisata' => $wisata,
                    'event' => $event
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil data explore.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
