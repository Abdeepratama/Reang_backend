<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    /**
     * Login admin
     */
    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');

        if (!Auth::guard('admin')->attempt($credentials)) {
            return response()->json(['message' => 'Login gagal'], 401);
        }

        $admin = Auth::guard('admin')->user();
        $token = $admin->createToken('AdminToken')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
            'admin' => $admin
        ]);
    }

    /**
     * Get authenticated admin
     */
    public function profile(Request $request)
    {
        return response()->json($request->user()); // harus pakai sanctum middleware
    }

    /**
     * Logout admin
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }
}
