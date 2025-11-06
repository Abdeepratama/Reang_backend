<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckAdminDinas
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('admin')->user();

        // Jika belum login → arahkan ke login
        if (!$user) {
            return redirect()->route('admin.login');
        }

        // Superadmin bebas akses ke semua
        if (optional($user)->role === 'superadmin') {
    return $next($request);
}

        // Admin Dinas → cek akses berdasar id_instansi
        if ($user->role === 'admindinas') {
            $user->loadMissing('userData.instansi');

            $idInstansi = optional($user->userData->instansi)->id;

            if (empty($idInstansi)) {
                abort(403, 'Akun Anda belum terhubung dengan instansi manapun.');
            }

            $allowedRoutesByInstansi = $this->getAllowedRoutesByInstansi($idInstansi);
            $routeName = $request->route()->getName();

            foreach ($allowedRoutesByInstansi as $pattern) {
                if (Str::is($pattern, $routeName)) {
                    return $next($request);
                }
            }

            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Jika role tidak dikenali
        abort(403, 'Role tidak dikenali.');
    }

    /**
     * 🔐 Mapping route berdasarkan id_instansi
     */
    private function getAllowedRoutesByInstansi($id_instansi)
    {
        switch ($id_instansi) {
            case 2: // 🏥 Dinas Kesehatan
                return [
                    'admin.dashboard',
                    'admin.sehat.tempat.*',
                    'admin.sehat.info.*',
                    'admin.sehat.olahraga.*',
                    'admin.sehat.puskesmas.*',
                    'admin.kategori.*',
                    'admin.kategori_dumas.*',
                    'admin.accounts.profile',
                    'admin.dumas.aduan.*',
                    'admin.setting.*',
                    'admin.notifikasi.*',
                    'admin.accounts.index',
                ];

            case 3: // 🎓 Dinas Pendidikan
                return [
                    'admin.dashboard',
                    'admin.sekolah.tempat.*',
                    'admin.sekolah.info.*',
                    'admin.kategori.*',
                    'admin.accounts.profile',
                    'admin.dumas.aduan.*',
                    'admin.setting.*',
                    'admin.notifikasi.*',
                ];

            case 7: // 🛒 Dinas Perdagangan
                return [
                    'admin.dashboard',
                    'admin.pasar.tempat.*',
                    'admin.kategori.*',
                    'admin.kategori_dumas.*',
                    'admin.accounts.profile',
                    'admin.dumas.aduan.*',
                    'admin.setting.*',
                    'admin.notifikasi.*',
                ];

            case 9: // 🏖️ Dinas Pariwisata
                return [
                    'admin.dashboard',
                    'admin.plesir.tempat.*',
                    'admin.plesir.info.*',
                    'admin.kategori.*',
                    'admin.accounts.profile',
                    'admin.dumas.aduan.*',
                    'admin.setting.*',
                    'admin.notifikasi.*',
                ];

            case 10: // 🕌 Dinas Keagamaan
                return [
                    'admin.dashboard',
                    'admin.ibadah.tempat.*',
                    'admin.ibadah.info.*',
                    'admin.kategori.*',
                    'admin.accounts.profile',
                    'admin.dumas.aduan.*',
                    'admin.setting.*',
                    'admin.notifikasi.*',
                ];

            case 6: // 🧾 Dinas Perpajakan
                return [
                    'admin.dashboard',
                    'admin.pajak.info.*',
                    'admin.kategori.*',
                    'admin.accounts.profile',
                    'admin.dumas.aduan.*',
                    'admin.setting.*',
                    'admin.notifikasi.*',
                ];

            case 8: // 👷 Dinas Tenaga Kerja
                return [
                    'admin.dashboard',
                    'admin.kerja.info.*',
                    'admin.kategori.*',
                    'admin.accounts.profile',
                    'admin.dumas.aduan.*',
                    'admin.setting.*',
                    'admin.notifikasi.*',
                ];

            case 11: // 🧍 Dinas Kependudukan
                return [
                    'admin.dashboard',
                    'admin.adminduk.info.*',
                    'admin.kategori.*',
                    'admin.accounts.profile',
                    'admin.dumas.aduan.*',
                    'admin.setting.*',
                    'admin.notifikasi.*',
                ];

            case 12: // 🏗️ Dinas Pembangunan
                return [
                    'admin.dashboard',
                    'admin.renbang.info.*',
                    'admin.kategori.*',
                    'admin.accounts.profile',
                    'admin.dumas.aduan.*',
                    'admin.setting.*',
                    'admin.notifikasi.*',
                ];

            case 13: // 📜 Dinas Perizinan
                return [
                    'admin.dashboard',
                    'admin.izin.info.*',
                    'admin.kategori.*',
                    'admin.accounts.profile',
                    'admin.dumas.aduan.*',
                    'admin.setting.*',
                    'admin.notifikasi.*',
                ];

            default:
                return ['admin.dashboard']; // Default minimal akses
        }
    }

    public function sidebar()
    {
        $user = auth()->guard('admin')->user();
        $allowedRoutes = $this->getAllowedRoutesByInstansi($user->dinas ?? 0);

        return view('admin.partials.sidebar', compact('allowedRoutes', 'user'));
    }
}
