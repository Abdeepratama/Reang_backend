<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class AuthController extends Controller
{
    /**
     * Tampilkan form login admin
     */
    public function showLoginForm()
    {
        $code = strtoupper(substr(md5(mt_rand()), 0, 5));
        session(['captcha_code' => $code]);

        return view('admin.login');
    }

    /**
     * Proses login admin
     */
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
            'captcha' => 'required',
        ]);

        // 🧩 Validasi captcha (TIDAK sensitif huruf besar/kecil)
        if (strtolower($request->captcha) !== strtolower(session('captcha_code'))) {
            return back()->withErrors(['captcha' => 'Captcha tidak sesuai'])->withInput();
        }

        // Cek apakah akun terdaftar (Untuk membedakan error nama dan password)
        $admin = Admin::where('name', $request->name)->first();

        // JIKA NAMA TIDAK ADA DI DATABASE
        if (!$admin) {
            return back()->withErrors(['name' => 'Akun tidak terdaftar di sistem.'])->withInput();
        }

        $credentials = $request->only('name', 'password');

        // JIKA PASSWORD SALAH
        if (!Auth::guard('admin')->attempt($credentials)) {
            return back()->withErrors(['password' => 'Password yang Anda masukkan salah.'])->withInput();
        }

        // --- JIKA SUKSES MASUK ---
        $user = Admin::find(Auth::guard('admin')->id());
        $user->load('userData.instansi');

        $instansiNama = optional($user->userData->instansi)->nama;

        if ($user->role === 'admindinas' && empty(trim($instansiNama))) {
            Auth::guard('admin')->logout();
            return back()->with('error', 'Akun Anda belum terhubung dengan instansi manapun.');
        }

        session([
            'admin_id' => $user->id,
            'name'     => $user->name,
            'role'     => $user->role,
            'instansi' => $instansiNama,
        ]);

        return redirect()->route('admin.dashboard');
    }

    /**
     * Profil admin (menampilkan data + relasi instansi)
     */
    public function profile()
    {
        /** @var \App\Models\Admin $admin */
        $admin = Auth::guard('admin')->user();
        $admin->load('userData.instansi');

        return view('admin.accounts.profile', compact('admin'));
    }

    /**
     * Logout admin
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home'); // arahkan ke route home/landing
    }
}
