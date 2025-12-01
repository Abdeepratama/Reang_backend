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
use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;

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

    public function googleCallback(Request $request)
    {
        // 1. Validasi: Pastikan Flutter mengirim token
        $request->validate([
            'id_token' => 'required|string',
        ]);

        $idTokenString = $request->input('id_token');

        try {
            // 2. Siapkan Firebase (Arahkan ke file JSON credentials kamu)
            // Pastikan file 'firebase_credentials.json' ada di folder storage/app/
            $factory = (new Factory)->withServiceAccount(storage_path('app/firebase_credentials.json'));
            $auth = $factory->createAuth();

            // 3. Verifikasi Token ke Google
            $verifiedIdToken = $auth->verifyIdToken($idTokenString, false, 300);
            $claims = $verifiedIdToken->claims();

            // Ambil data dari Google
            $uid = $claims->get('sub');   // Google ID Unik
            $email = $claims->get('email');
            $name = $claims->get('name');

        } catch (FailedToVerifyToken $e) {
            return response()->json(['message' => 'Token Google tidak valid: ' . $e->getMessage()], 401);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan server: ' . $e->getMessage()], 500);
        }

        // 4. Cek Database: Apakah user sudah ada?
        $user = User::where('email', $email)->first();

        if ($user) {
            // --- SKENARIO A: USER SUDAH ADA (LOGIN) ---
            
            // Jika kolom google_id masih kosong, kita isi sekalian (link account)
            if (empty($user->google_id)) {
                $user->update(['google_id' => $uid]);
            }

        } else {
            // --- SKENARIO B: USER BARU (REGISTER OTOMATIS) ---
            
            $user = User::create([
                'name'      => $name,
                'email'     => $email,
                'google_id' => $uid,
                'password'  => null, // Tidak punya password
                'phone'     => null, // Nanti diisi di Flutter
                'no_ktp'    => null, // Nanti diisi di Flutter
            ]);

            // Beri role default 'user' (ID 1)
            $user->role()->attach(1);
        }

        // 5. Proses Login Akhir (Sama untuk kedua skenario)
        
        // Refresh data user & load role
        $user = $user->fresh(['role']);
        
        // Panggil helper toko yang sudah ada di kodingan Mas
        $user = $this->attachTokoId($user);

        // Buat Token Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'      => 'Login Google berhasil',
            'user'         => $user,
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ]);
    }

    

    /**
     * LOGIN USER
     */
    public function signin(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // 2. Cek apakah Email ada di database?
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Jika user tidak ditemukan
            return response()->json([
                'status' => false, // Tambahkan status false biar enak di cek di flutter
                'message' => 'Email belum terdaftar' 
            ], 404); // 404 Not Found
        }

        // 3. Cek apakah Password benar?
        // Gunakan Hash::check untuk membandingkan input dengan password di DB
        if (!Hash::check($request->password, $user->password)) {
            // Jika password salah
            return response()->json([
                'status' => false,
                'message' => 'Password salah'
            ], 401); // 401 Unauthorized
        }

        // 4. Jika Login Sukses
        $user->load('role');

        // Tambah id_toko saat login (Helper Anda)
        $user = $this->attachTokoId($user);

        // Buat Token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'       => true,
            'message'      => 'Login successful!',
            'user'         => $user,
            'access_token' => $token,
            'token_type'   => 'Bearer',
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

        // Validasi (Pastikan no_ktp ada di sini seperti perbaikan sebelumnya)
        $validated = $request->validate([
            'name'     => 'nullable|string|max:255',
            'email'    => 'nullable|email|unique:users,email,' . $user->id,
            'alamat'   => 'nullable|string|max:255',
            'phone'    => 'nullable|string|max:20',
            'no_ktp'   => 'nullable|string|max:20', 
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        // Update profile
        $user->update($validated);

        // Tambahkan id_toko kembali
        $user = $this->attachTokoId($user);

        // --- PERBAIKAN UTAMA: Generate Token Baru/Kirim Balik ---
        // Kita buat token baru agar format responnya sama dengan login/register
        // Sehingga Flutter tidak error "Token null"
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'      => 'Profile updated successfully!',
            'user'         => $user,
            'access_token' => $token,  // <--- INI YANG TADI HILANG
            'token_type'   => 'Bearer',
        ]);
    }
    // GET: /api/check-email?email=xxx@gmail.com
    public function checkEmail(Request $request)
    {
        $exists = User::where('email', $request->email)->exists();
        return response()->json(['exists' => $exists]);
    }
}