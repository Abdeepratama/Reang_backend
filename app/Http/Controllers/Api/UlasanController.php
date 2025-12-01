<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Ulasan;

class UlasanController extends Controller
{
    // GET: /api/ulasan/{id_produk}?page=1
    // Mengambil list ulasan per produk (Public)
   public function index($id_produk)
    {
        try {
            // 1. Ambil List Ulasan (Pagination)
            $ulasan = DB::table('ulasan')
                ->join('users', 'ulasan.id_user', '=', 'users.id')
                ->where('ulasan.id_produk', $id_produk)
                ->select('ulasan.*', 'users.name as nama_user')
                ->orderBy('ulasan.created_at', 'desc')
                ->paginate(10);

            // Format Foto Ulasan
            $ulasan->getCollection()->transform(function ($item) {
                if ($item->foto) {
                    $item->foto = asset('storage/' . $item->foto);
                }
                // Avatar default
                $item->foto_user = 'https://ui-avatars.com/api/?name=' . urlencode($item->nama_user);
                return $item;
            });

            // 2. [LOGIKA BARU] Hitung Rata-rata Rating
            // Mengambil rata-rata kolom 'rating' dari tabel ulasan khusus produk ini
            $averageRating = DB::table('ulasan')
                ->where('id_produk', $id_produk)
                ->avg('rating'); // Hasilnya misal: 4.33333

            // 3. Hitung Total Ulasan
            $totalReviews = DB::table('ulasan')
                ->where('id_produk', $id_produk)
                ->count();

            // 4. Masukkan ke Response JSON
            // Kita convert pagination ke array dulu biar bisa disisipkan data tambahan
            $response = $ulasan->toArray();
            
            // Tambahkan data statistik ke root JSON
            $response['average_rating'] = round($averageRating, 1); // Bulatkan 1 desimal (4.3)
            $response['total_reviews'] = $totalReviews;

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // POST: /api/ulasan/store
    // Menyimpan ulasan baru (Wajib Login)
    public function store(Request $request)
    {
        $request->validate([
            'id_produk'    => 'required|integer',
            'no_transaksi' => 'required|string',
            'rating'       => 'required|integer|min:1|max:5',
            'komentar'     => 'nullable|string',
            'foto'         => 'nullable|image|max:2048',
        ]);

        $user = $request->user();

        // 1. Cari data lama dulu (untuk handle foto)
        $ulasanLama = Ulasan::where('no_transaksi', $request->no_transaksi)
            ->where('id_produk', $request->id_produk)
            ->where('id_user', $user->id)
            ->first();

        // 2. Logika Upload Foto
        $path = null;
        
        if ($request->hasFile('foto')) {
            // A. Jika user upload foto baru
            
            // Hapus foto lama dari server jika ada
            if ($ulasanLama && $ulasanLama->foto) {
                Storage::disk('public')->delete($ulasanLama->foto);
            }
            // Simpan foto baru
            $path = $request->file('foto')->store('ulasan_produk', 'public');
        } else {
            // B. Jika user TIDAK upload foto baru
            // Gunakan path foto lama (agar tidak hilang/jadi null)
            $path = $ulasanLama ? $ulasanLama->foto : null;
        }

        // 3. [PERBAIKAN UTAMA] Gunakan updateOrCreate
        // Laravel akan mengecek array pertama. 
        // Jika ketemu -> Update. Jika tidak ketemu -> Create.
        Ulasan::updateOrCreate(
            [
                // KONDISI PENCARIAN (WHERE)
                'no_transaksi' => $request->no_transaksi,
                'id_produk'    => $request->id_produk,
                'id_user'      => $user->id,
            ],
            [
                // DATA YANG DISIMPAN/DIUPDATE
                'rating'   => $request->rating,
                'komentar' => $request->komentar,
                'foto'     => $path, // Path baru atau lama
            ]
        );

        return response()->json([
            'status' => true, 
            'message' => 'Ulasan berhasil disimpan.'
        ]);
    }
    // GET: /api/ulasan/cek/{no_transaksi}
    public function showByTransaksi(Request $request, $no_transaksi)
    {
        $user = $request->user();
        
        $ulasan = Ulasan::where('no_transaksi', $no_transaksi)
            ->where('id_user', $user->id)
            ->first();

        if (!$ulasan) {
            return response()->json(['status' => false, 'data' => null]);
        }

        if ($ulasan->foto) {
            $ulasan->foto = asset('storage/' . $ulasan->foto);
        }

        return response()->json(['status' => true, 'data' => $ulasan]);
    }
}