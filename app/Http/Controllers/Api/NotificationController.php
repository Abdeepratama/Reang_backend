<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    // GET: Ambil semua notifikasi milik user
    public function index(Request $request)
    {
        $user_id = $request->user()->id;

        $notifications = Notification::where('id_user', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $notifications
        ]);
    }

    // POST: Tandai satu notifikasi sudah dibaca
    public function markAsRead($id)
    {
        $notif = Notification::find($id);
        if ($notif) {
            $notif->update(['is_read' => 1]);
        }
        return response()->json(['status' => true, 'message' => 'Ditandai dibaca']);
    }

    // POST: Tandai SEMUA sudah dibaca
    public function markAllRead(Request $request)
    {
        $user_id = $request->user()->id;
        
        Notification::where('id_user', $user_id)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        return response()->json(['status' => true, 'message' => 'Semua ditandai dibaca']);
    }
    // GET: /api/notifications/unread-count
    public function countUnread(Request $request)
    {
        $user_id = $request->user()->id;

        // Hitung langsung di database (Sangat Cepat)
        $count = Notification::where('id_user', $user_id)
            ->where('is_read', 0)
            ->count();

        return response()->json([
            'status' => true,
            'count' => $count
        ]);
    }

    // POST: Hapus SEMUA notifikasi user
    public function deleteAll(Request $request)
    {
        $user_id = $request->user()->id;
        
        // Hapus semua data milik user ini
        Notification::where('id_user', $user_id)->delete();

        return response()->json(['status' => true, 'message' => 'Semua notifikasi berhasil dihapus']);
    }
}