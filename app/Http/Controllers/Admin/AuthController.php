<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
{
    $code = strtoupper(substr(md5(mt_rand()), 0, 5));
    session(['captcha_code' => $code]);

    return view('admin.login');
}

public function login(Request $request)
{
    // Validasi input
    $request->validate([
        'name' => 'required',
        'password' => 'required',
        'captcha' => 'required',
    ]);

    // Cek captcha manual
    if ($request->captcha !== session('captcha_code')) {
        return back()->withErrors(['captcha' => 'Captcha tidak sesuai'])->withInput();
    }

    // Ambil hanya nama & password
    $credentials = $request->only('name', 'password');

    if (Auth::guard('admin')->attempt($credentials)) {
        return redirect()->intended('/admin/dashboard');
    }

    return back()->withErrors([
        'name' => 'nama atau password salah.',
    ])->withInput();
}

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home'); // ⬅️ arahkan ke route welcome
    }
}
