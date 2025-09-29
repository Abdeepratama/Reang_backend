<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\InfoPlesir;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'info_plesir_id' => 'required|exists:info_plesir,id',
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // user bisa update rating & comment jika sudah pernah kasih rating
        $rating = Rating::updateOrCreate(
            ['info_plesir_id' => $data['info_plesir_id'], 'user_id' => $data['user_id']],
            ['rating' => $data['rating'], 'comment' => $data['comment'] ?? null]
        );

        // hitung rata-rata baru
        $avg = Rating::where('info_plesir_id', $data['info_plesir_id'])->avg('rating');

        // simpan rata-rata ke info_plesir (cache)
        $info = InfoPlesir::find($data['info_plesir_id']);
        $info->rating = $avg;
        $info->save();

        // load relasi user agar front-end bisa menampilkan nama user jika perlu
        $rating->load('user:id,name');

        return response()->json([
            'success' => true,
            'avg_rating' => round($avg, 1),
            'rating' => $rating,
        ]);
    }

    /**
     * Update an existing rating/ulasan.
     * - menerima rating (optional) dan/atau comment (optional)
     * - recalculates avg rating for the related info_plesir
     */
    public function update(Request $request, $id)
    {
        $rating = Rating::findOrFail($id);

        $data = $request->validate([
            'rating' => 'nullable|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // prepare hanya fields yang diberikan
        $updateData = [];
        if ($request->has('rating')) {
            $updateData['rating'] = $data['rating'];
        }
        if ($request->has('comment')) {
            $updateData['comment'] = $data['comment'];
        }

        // jika tidak ada field yg diupdate, kembalikan 422
        if (empty($updateData)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada data untuk diperbarui.'
            ], 422);
        }

        $rating->update($updateData);

        // hitung ulang rata-rata untuk info_plesir terkait
        $avg = Rating::where('info_plesir_id', $rating->info_plesir_id)->avg('rating');

        // simpan rata-rata ke info_plesir (cache)
        $info = InfoPlesir::find($rating->info_plesir_id);
        $info->rating = $avg;
        $info->save();

        // reload relasi user
        $rating->load('user:id,name');

        return response()->json([
            'success' => true,
            'message' => 'Ulasan berhasil diperbarui.',
            'avg_rating' => round($avg, 1),
            'rating' => $rating,
        ]);
    }

    /**
     * Endpoint lama / existing:
     * Tampilkan info_plesir + semua rating (non-paginated).
     */
    public function show($info_plesir_id)
    {
        // cek apakah tempat plesir ada
        $info = InfoPlesir::findOrFail($info_plesir_id);

        // ambil semua rating tempat ini (termasuk user dan komentar)
        $ratings = $info->ratings()->with('user:id,name')->get();

        return response()->json([
            'success' => true,
            'info_plesir_id' => $info->id,
            'judul' => $info->judul,
            'avg_rating' => $info->avg_rating,
            'ratings' => $ratings,
        ]);
    }

    /**
     * Endpoint BARU:
     * Tampilkan daftar rating untuk sebuah info_plesir_id,
     * dengan paginasi — FIXED 20 per page.
     *
     * Query params:
     * - page (handled by paginator)
     */
    public function ratingsByInfo(Request $request, $info_plesir_id)
    {
        // pastikan tempat plesir ada
        $info = InfoPlesir::findOrFail($info_plesir_id);

        // paginasi fixed 20 per page
        $ratings = Rating::where('info_plesir_id', $info_plesir_id)
            ->with('user:id,name')
            ->orderByDesc('created_at')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'info_plesir_id' => $info->id,
            'judul' => $info->judul,
            'avg_rating' => $info->avg_rating,
            'ratings' => $ratings, // termasuk meta pagination
        ]);
    }

    public function topPlesir()
    {
        $topPlesir = InfoPlesir::orderByDesc('rating')->take(3)->get();

        // convert foto path -> absolute URL sesuai domain/ip saat aplikasi dijalankan
        $topPlesir->transform(function ($item) {
            // pastikan ada field foto, dan hanya konversi jika bukan URL penuh
            if (!empty($item->foto) && !preg_match('#^https?://#i', $item->foto)) {
                // bersihkan leading slash kalau ada
                $foto = ltrim($item->foto, '/');

                // jika sudah termasuk 'storage/' maka langsung gunakan url($foto)
                if (stripos($foto, 'storage/') === 0) {
                    $item->foto = url($foto);
                } else {
                    // default: foto disimpan di storage/app/public/... dan diakses lewat /storage/...
                    $item->foto = url('storage/' . $foto);
                }
            }
            return $item;
        });

        return response()->json($topPlesir);
    }

    /**
     * Destroy (hapus) sebuah rating berdasarkan id.
     * - menghapus record rating
     * - menghitung ulang avg rating untuk info_plesir terkait
     * - mengembalikan avg_rating terbaru
     */
    public function destroy($id)
    {
        $rating = Rating::findOrFail($id);

        $infoId = $rating->info_plesir_id;

        // hapus rating
        $rating->delete();

        // hitung ulang rata-rata setelah penghapusan
        $avg = Rating::where('info_plesir_id', $infoId)->avg('rating');

        // jika tidak ada rating tersisa, avg akan null -> kita set null (atau 0 jika mau)
        $info = InfoPlesir::find($infoId);
        $info->rating = $avg;
        $info->save();

        return response()->json([
            'success' => true,
            'message' => 'Rating berhasil dihapus.',
            'avg_rating' => $avg !== null ? round($avg, 1) : null,
        ]);
    }
}
