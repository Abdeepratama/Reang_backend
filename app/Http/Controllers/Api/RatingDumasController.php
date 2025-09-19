<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dumas;
use App\Models\DumasRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- penting!

class RatingDumasController extends Controller
{
    // Simpan atau update rating
    public function store(Request $request, $id)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $dumas = Dumas::findOrFail($id);

        // hanya bisa kasih rating kalau status sudah selesai
        if ($dumas->status !== 'selesai') {
            return response()->json([
                'message' => 'Aduan belum selesai, belum bisa diberi rating'
            ], 403);
        }

        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $rating = DumasRating::updateOrCreate(
            [
                'user_id'  => $user->id,
                'dumas_id' => $id,
            ],
            [
                'rating'  => $request->rating,
                'comment' => $request->comment,
            ]
        );

        return response()->json([
            'message' => 'Rating berhasil disimpan',
            'data'    => $rating,
        ]);
    }

    // Ambil semua rating + rata-rata
    public function show($id)
    {
        $dumas = Dumas::with('ratings')->findOrFail($id);

        return response()->json([
            'dumas_id'        => $dumas->id,
            'average_rating'  => round($dumas->ratings->avg('rating'), 2),
            'ratings'         => $dumas->ratings,
        ]);
    }
}
