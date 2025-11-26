<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use App\Models\User;
use Kreait\Firebase\Messaging\AndroidConfig;
use Illuminate\Support\Facades\Log;

class FirebaseController extends Controller
{
    public function createCustomToken(Request $request)
    {
        // Dapatkan user yang sudah login via Sanctum (bisa User atau Admin)
        $user = $request->user();
        $uid = (string) $user->id;

        $factory = (new Factory)->withServiceAccount(storage_path('app/firebase_credentials.json'));
        $auth = $factory->createAuth();

        // Buat custom token untuk UID tersebut
        $customToken = $auth->createCustomToken($uid);

        return response()->json([
            'firebase_custom_token' => $customToken->toString(),
        ]);
    }
    public function saveFcmToken(Request $request)
{
    $request->validate([
        'fcm_token' => 'required|string',
    ]);

    $user = $request->user();
    
    // Simpan token ke user yang sedang login
    $user->fcm_token = $request->fcm_token;
    $user->save();

    return response()->json(['message' => 'FCM token saved successfully.']);
}

 public function sendChatNotification(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'recipient_id'   => 'required|string',
            'recipient_role' => 'required|string|in:user,puskesmas,umkm',
            'message_text'   => 'required|string',
        ]);

        try {
            $sender = $request->user();
            $recipientId = $request->recipient_id;
            $recipientRole = $request->recipient_role;

            // 2. Cari Penerima
            $recipient = null;
            if ($recipientRole === 'user' || $recipientRole === 'umkm') {
                $recipient = User::find($recipientId);
            } else if ($recipientRole === 'puskesmas') {
                $recipient = \App\Models\Admin::find($recipientId);
            }

            if (!$recipient) {
                return response()->json(['message' => 'Penerima tidak ditemukan.'], 404);
            }

            $fcmToken = $recipient->fcm_token;
            if (!$fcmToken) {
                return response()->json(['message' => 'Penerima tidak memiliki FCM token.'], 400);
            }

            // 3. Tentukan Nama Pengirim (LOGIC INI YANG DIPERBAIKI)
            $senderName = $sender->name ?? 'Seseorang'; // Default

            // Cek A: Apakah Pengirim adalah Admin Puskesmas?
            if ($sender instanceof \App\Models\Admin) {
                // Coba ambil ID Puskesmas (Cek 2 kemungkinan: kolom langsung atau relasi)
                $puskesmasId = $sender->id_puskesmas ?? optional($sender->userData)->id_puskesmas;
                
                if ($puskesmasId) {
                    $puskesmas = \App\Models\Puskesmas::find($puskesmasId);
                    // Jika puskesmas ketemu, pakai namanya. Jika tidak, pakai nama admin.
                    $senderName = $puskesmas ? $puskesmas->nama : $sender->name;
                }
            } 
            // Cek B: Apakah Pengirim adalah UMKM?
            else if ($sender instanceof User && $sender->hasRole('umkm')) {
                $toko = \App\Models\Toko::where('id_user', $sender->id)->first();
                if ($toko) {
                    $senderName = $toko->nama;
                }
            }

            // 4. Siapkan Firebase
            $factory = (new Factory)->withServiceAccount(storage_path('app/firebase_credentials.json'));
            $messaging = $factory->createMessaging();

            // 5. Buat Notifikasi
            $notification = Notification::create(
                $senderName, 
                $request->message_text
            );

            $notificationTag = 'chat_' . (string) $sender->id;

            $message = CloudMessage::withTarget('token', $fcmToken)
                ->withNotification($notification)
                ->withData([
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                    'sender_id'    => (string) $sender->id,
                    'sender_role'  => ($sender instanceof \App\Models\Admin) ? 'puskesmas' : 'user',
                    'type'         => 'CHAT',
                ])
                ->withAndroidConfig([
                    'notification' => [
                        'channel_id' => 'high_importance_channel',
                        'tag'        => $notificationTag,
                    ],
                ]);

            $messaging->send($message);
            return response()->json(['message' => 'Notification sent successfully.']);

        } catch (\Exception $e) {
            // TANGKAP ERROR BIAR KETAHUAN PENYEBABNYA
            Log::error('FCM Chat Error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Server Error saat kirim notifikasi',
                'error' => $e->getMessage() // Kirim pesan error asli ke Flutter (buat debug)
            ], 500);
        }
    }

public function deleteFcmToken(Request $request)
{
    $user = $request->user();

    // Hapus token dari user yang sedang login
    $user->fcm_token = null;
    $user->save();

    return response()->json(['message' => 'FCM token deleted successfully.']);
}
}