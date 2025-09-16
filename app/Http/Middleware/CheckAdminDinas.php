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

            default:
                return ['admin.dashboard']; // fallback minimal
        }
    }
}
