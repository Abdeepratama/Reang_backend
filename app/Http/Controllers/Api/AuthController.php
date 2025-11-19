<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Helper: Menyisipkan id_toko ke user jika role UMKM.
     */
    protected function attachTokoId($user)
    {
        $user->id_toko = null;

        // Jika user adalah UMKM, ambil tokonya
        if ($user->hasRole('umkm')) {
            $toko = DB::table('toko')->where('id_user', $user->id)->first();
            if ($toko) {
                $user->id_toko = $toko->id;
            }
        }
        return $user;
    }

    /**
     * REGISTER USER
     */
    public function signup(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'alamat'   => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'phone'    => 'nullable|string|max:20',
            'noKtp'    => 'nullable|string|max:20|unique:users,no_ktp',
        ]);

        // Buat user
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'alamat'   => $validated['alamat'] ?? null,
            'password' => Hash::make($validated['password']),
            'phone'    => $validated['phone'] ?? null,
            'no_ktp'   => $validated['noKtp'] ?? null,
        ]);

        // Role default = user
        $user->role()->attach(1);

        // Refresh data & role
        $user = $user->fresh(['role']);

        // Tambah id_toko
        $user = $this->attachTokoId($user);

        // Generate token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return response
        return response()->json([
            'message'       => 'User registered successfully!',
            'user'          => $user->load('role'),
            'access_token'  => $token,
            'token_type'    => 'Bearer',
        ], 201);
    }

    /**
     * LOGIN USER
     */
    public function signin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Auth::user();
        $user->load('role');

        // Tambah id_toko saat login
        $user = $this->attachTokoId($user);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'       => 'Login successful!',
            'user'          => $user,
            'access_token'  => $token,
            'token_type'    => 'Bearer',
        ]);
    }

    /**
     * GET AUTHENTICATED USER
     */
    public function user(Request $request)
    {
        $user = $request->user()->load('role');

        // Tambah id_toko
        $user = $this->attachTokoId($user);

        return response()->json([
            'message' => 'Profile retrieved successfully!',
            'user'    => $user
        ]);
    }

    /**
     * LOGOUT
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully!'
        ]);
    }

    /**
     * FORGOT PASSWORD
     */
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Reset link sent to your email!'])
            : response()->json(['message' => 'Unable to send reset link.'], 400);
    }

    /**
     * RESET PASSWORD
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => 'Password reset successful!'])
            : response()->json(['message' => 'Reset failed. Invalid token or email.'], 400);
    }

    /**
     * UPDATE PROFILE
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name'     => 'nullable|string|max:255',
            'email'    => 'nullable|email|unique:users,email,' . $user->id,
            'alamat'   => 'nullable|string|max:255',
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        // Update profile
        $user->update($validated);

        // Tambahkan id_toko kembali
        $user = $this->attachTokoId($user);

        return response()->json([
            'message' => 'Profile updated successfully!',
            'user'    => $user
        ]);
    }
}
