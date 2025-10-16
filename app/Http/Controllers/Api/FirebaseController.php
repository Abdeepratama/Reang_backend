<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

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
}