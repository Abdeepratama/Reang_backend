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

        // 🧩 Validasi captcha
        if ($request->captcha !== session('captcha_code')) {
            return back()->withErrors(['captcha' => 'Captcha tidak sesuai'])->withInput();
        }

        $credentials = $request->only('name', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $user = Admin::find(Auth::guard('admin')->id());
            $user->load('userData.instansi');

            $instansiNama = optional($user->userData->instansi)->nama;

            if ($user->role === 'admindinas' && empty(trim($instansiNama))) {
                Auth::guard('admin')->logout();
                return back()->with('error', 'Akun Anda belum terhubung dengan instansi manapun.');
            }

            session([
                'admin_id' => $user->id,
                'name' => $user->name,
                'role' => $user->role,
                'instansi' => $instansiNama,
            ]);

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'name' => 'Nama atau password salah.',
        ])->withInput();
    }

    /**
     * Profil admin (menampilkan data + relasi instansi)
     */
    public function profile()
    {
        $admin = Auth::guard('admin')->user()->load('userData.instansi');
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
