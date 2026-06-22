<?php

namespace App\Http\Controllers\Api\Plesir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotifikasiPlesirUser;

class NotifikasiUserController extends Controller
{
    // Mengambil daftar notifikasi milik user
    public function getNotifikasi(Request $request)
    {
        $userId = $request->user()->id;

        $notifikasi = NotifikasiPlesirUser::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        $unreadCount = $notifikasi->where('is_read', 0)->count();

        return response()->json([
            'status' => 'success',
            'unread_count' => $unreadCount,
            'data' => $notifikasi
        ]);
    }

    // Menandai satu atau semua notifikasi telah dibaca
    public function tandaiDibaca(Request $request)
    {
        $userId = $request->user()->id;

        NotifikasiPlesirUser::where('user_id', $userId)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        return response()->json([
            'status' => 'success',
            'message' => 'Semua notifikasi ditandai dibaca'
        ]);
    }
}
