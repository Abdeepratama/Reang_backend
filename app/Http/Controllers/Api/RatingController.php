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
        ]);

        // user bisa update rating jika sudah pernah kasih rating
        $rating = Rating::updateOrCreate(
            ['info_plesir_id' => $data['info_plesir_id'], 'user_id' => $data['user_id']],
            ['rating' => $data['rating']]
        );

        // hitung rata-rata baru
        $avg = Rating::where('info_plesir_id', $data['info_plesir_id'])->avg('rating');

        // simpan rata-rata ke info_plesir (cache)
        $info = InfoPlesir::find($data['info_plesir_id']);
        $info->rating = $avg;
        $info->save();

        return response()->json([
            'success' => true,
            'avg_rating' => round($avg, 1)
        ]);
    }

    public function topPlesir()
    {
        $topPlesir = InfoPlesir::orderByDesc('rating')->take(5)->get();

        return response()->json($topPlesir);
    }

    public function show($info_plesir_id)
{
    // cek apakah tempat plesir ada
    $info = InfoPlesir::findOrFail($info_plesir_id);

    // ambil semua rating tempat ini
    $ratings = $info->ratings()->with('user:id,name')->get();

    return response()->json([
        'success' => true,
        'info_plesir_id' => $info->id,
        'judul' => $info->judul,
        'avg_rating' => $info->avg_rating,   // dari accessor di model
        'ratings' => $ratings,               // list rating tiap user
    ]);
}
}
