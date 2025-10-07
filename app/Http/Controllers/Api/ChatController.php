<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user() ?? Auth::user();

        if (!$admin) {
            return response()->json(['message' => 'Belum login atau token tidak valid'], 401);
        }

        $dokter = Dokter::where('admin_id', $admin->id)->first();

        if (!$dokter) {
            return response()->json(['message' => 'Data dokter tidak ditemukan untuk admin ini'], 404);
        }

        $messages = Message::where('dokter_id', $dokter->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    // Ambil semua chat antara user dan dokter tertentu
    public function getMessages($dokterId)
    {
        $user = Auth::user();

        $messages = Message::where(function ($q) use ($user, $dokterId) {
            $q->where('user_id', $user->id)
                ->where('dokter_id', $dokterId);
        })
            ->orWhere(function ($q) use ($user, $dokterId) {
                $q->where('user_id', $dokterId)
                    ->where('dokter_id', $user->id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    /**
     *  Menampilkan semua pesan yang masuk ke dokter (semua user)
     */
    public function getAllMessagesForDokter()
    {
        // ambil user dari sanctum
        $admin = Auth::user();

        // cari dokter berdasarkan admin login
        $dokter = Dokter::where('admin_id', $admin->id)->first();

        if (!$dokter) {
            return response()->json(['message' => 'Data dokter tidak ditemukan'], 404);
        }

        $messages = Message::where('dokter_id', $dokter->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($messages);
    }


    // Kirim pesan
    public function sendMessage(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'message' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
            'dokter_id' => 'nullable|exists:dokter,id',
        ]);

        // kalau yang login itu USER
        if ($user->getTable() === 'users') {
            $message = Message::create([
                'user_id' => $user->id,
                'dokter_id' => $request->dokter_id,
                'message' => $request->message,
                'is_read' => false,
            ]);
        }
        // kalau yang login itu ADMIN (dokter)
        else {
            $dokter = \App\Models\Dokter::where('admin_id', $user->id)->first();

            if (!$dokter) {
                return response()->json(['message' => 'Dokter tidak ditemukan'], 404);
            }

            $message = Message::create([
                'user_id' => $request->user_id,
                'dokter_id' => $dokter->id,
                'admin_id' => $user->id,
                'message' => $request->message,
                'is_read' => false,
            ]);
        }

        return response()->json([
            'message' => 'Pesan berhasil dikirim',
            'data' => $message
        ]);
    }
}
