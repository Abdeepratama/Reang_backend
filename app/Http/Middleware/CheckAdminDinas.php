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

        if (!$user) {
            return redirect()->route('admin.login');
        }

        // Superadmin bebas akses semua
        if ($user->role === 'superadmin') {
            return $next($request);
        }

        // Jika role admindinas → cek hak akses berdasarkan dinas
        if ($user->role === 'admindinas') {
            $allowedRoutesByDinas = $this->getAllowedRoutesByDinas($user->dinas);

            $routeName = $request->route()->getName();
            $allowed = false;

            foreach ($allowedRoutesByDinas as $pattern) {
                if (Str::is($pattern, $routeName)) {
                    $allowed = true;
                    break;
                }
            }

            if (!$allowed) {
                abort(403, 'Anda tidak memiliki akses ke halaman ini.');
            }
        } else {
            abort(403, 'Role tidak dikenali.');
        }

        return $next($request);
    }

    /**
     * Mapping daftar route yang boleh diakses tiap dinas
     */
    private function getAllowedRoutesByDinas(string $dinas): array
    {
        switch ($dinas) {
            case 'kesehatan':
                return [
                    'admin.dashboard',
                    'admin.sehat.tempat.*',
                    'admin.sehat.info.*',
                    'admin.sehat.olahraga.*',
                    'admin.accounts.profile',
                    'admin.setting.index',
                    'admin.kategori.*', 
                    'admin.dumas.aduan.index',
                ];

            case 'pendidikan':
                return [
                    'admin.dashboard',
                    'admin.sekolah.tempat.*',
                    'admin.sekolah.info.*',
                    'admin.accounts.profile',
                    'admin.dumas.aduan.index',
                    'admin.setting.index',
                    'admin.kategori.*'
                ];
            
            case 'perpajakan':
                return [
                    'admin.dashboard',
                    'admin.pajak.info.*',
                    'admin.accounts.profile',
                    'admin.dumas.aduan.index',
                    'admin.setting.index',
                    'admin.kategori.*'
                ];
            
            case 'perdagangan':
                return [
                    'admin.dashboard',
                    'admin.pasar.tempat.*',
                    'admin.accounts.profile',
                    'admin.dumas.aduan.index',
                    'admin.setting.index',
                    'admin.kategori.*'
                ];

            case 'kerja':
                return [
                    'admin.dashboard',
                    'admin.kerja.info.*',
                    'admin.accounts.profile',
                    'admin.dumas.aduan.index',
                    'admin.setting.index',
                    'admin.kategori.*'
                ];

            case 'pariwisata':
                return [
                    'admin.dashboard',
                    'admin.plesir.tempat.*',
                    'admin.plesir.info.*',
                    'admin.accounts.profile',
                    'admin.dumas.aduan.index',
                    'admin.setting.index',
                    'admin.kategori.*'
                ];
            
            case 'keagamaan':
                return [
                    'admin.dashboard',
                    'admin.ibadah.tempat.index',
                    'admin.ibadah.tempat.create',
                    'admin.ibadah.tempat.store',
                    'admin.ibadah.tempat.update',
                    'admin.ibadah.tempat.edit',
                    'admin.ibadah.tempat.show',
                    'admin.ibadah.tempat.map',
                    'admin.ibadah.tempat.destroy',
                    'admin.ibadah.info.index',
                    'admin.ibadah.info.map',
                    'admin.ibadah.info.create',
                    'admin.ibadah.info.store',
                    'admin.ibadah.info.update',
                    'admin.ibadah.info.edit',
                    'admin.ibadah.info.destroy',
                    'admin.ibadah.simpan-lokasi',
                    'admin.accounts.profile',
                    'admin.dumas.aduan.index',
                    'admin.setting.index',
                    'admin.kategori.*'
                ];

            case 'kependudukan':
                return [
                    'admin.dashboard',
                    'admin.adminduk.info.*',
                    'admin.accounts.profile',
                    'admin.dumas.aduan.index',
                    'admin.setting.index',
                    'admin.kategori.*'
                ];

            case 'pembangunan':
                return [
                    'admin.dashboard',
                    'admin.renbang.info.*',
                    'admin.accounts.profile',
                    'admin.dumas.aduan.index',
                    'admin.setting.index',
                    'admin.kategori.*'
                ];

            case 'perizinan':
                return [
                    'admin.dashboard',
                    'admin.izin.info.*',
                    'admin.accounts.profile',
                    'admin.dumas.aduan.index',
                    'admin.setting.index',
                    'admin.kategori.*'
                ];
            default:
                return ['admin.dashboard']; // fallback minimal
        }
    }
}
