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
    $request->validate([
        'recipient_id' => 'required|string',
        'recipient_role' => 'required|string|in:user,puskesmas', // Validasi role
        'message_text' => 'required|string',
    ]);

    $sender = $request->user();
    $recipientId = $request->recipient_id;
    $recipientRole = $request->recipient_role;

    // --- LOGIKA BARU: Cari penerima di tabel yang benar ---
    $recipient = null;
    if ($recipientRole === 'user') {
        $recipient = User::find($recipientId);
    } else if ($recipientRole === 'puskesmas') {
        $recipient = \App\Models\Admin::find($recipientId);
    }
    // ----------------------------------------------------

    if (!$recipient) {
        return response()->json(['message' => 'Penerima tidak ditemukan.']);
    }

    $fcmToken = $recipient->fcm_token;
    if (!$fcmToken) {
        return response()->json(['message' => 'Penerima tidak memiliki FCM token.']);
    }

    // Tentukan nama pengirim
    $senderName = 'Seseorang';
    if ($sender instanceof \App\Models\Admin) {
        $puskesmasId = optional($sender->userData)->id_puskesmas;
        $puskesmas = $puskesmasId ? \App\Models\Puskesmas::find($puskesmasId) : null;
        $senderName = $puskesmas ? $puskesmas->nama : 'Admin Puskesmas';
    } else {
        $senderName = $sender->name;
    }

    // Siapkan Firebase
    $factory = (new Factory)->withServiceAccount(storage_path('app/firebase_credentials.json'));
    $messaging = $factory->createMessaging();

    // Buat notifikasi
    $notification = Notification::create(
        $senderName,
        $request->message_text
    );

    $notificationTag = 'chat_' . (string) $sender->id;

    $message = CloudMessage::withTarget('token', $fcmToken)
        ->withNotification($notification)
        ->withData([
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            'sender_id' => (string) $sender->id,
            'type' => 'CHAT',
        ])
        ->withAndroidConfig([
            'notification' => [
                'channel_id' => 'high_importance_channel',
                'tag' => $notificationTag,
            ],
        ]);

    try {
        $messaging->send($message);
        return response()->json(['message' => 'Notification sent successfully.']);
    } catch (\Exception $e) {
        Log::error('FCM Send Error: ' . $e->getMessage());
        return response()->json(['message' => 'Failed to send notification'], 500);
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