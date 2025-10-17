<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Aktivitas;
use App\Models\NotifikasiAktivitas;
use Illuminate\Support\Facades\Auth;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::guard('admin')->check()) {
                $admin = Auth::guard('admin')->user();

                // 🔔 Ambil notifikasi aktivitas
                $notifikasiAktivitas = NotifikasiAktivitas::query()
                    ->where('dibaca', 0) // hanya yang belum dibaca
                    ->when($admin->role !== 'superadmin', function ($q) use ($admin) {
                        if ($admin->role === 'admindinas') {
                            $q->where('id_instansi', $admin->id_instansi);
                        } elseif ($admin->role === 'adminpuskesmas') {
                            $q->where('id_puskesmas', $admin->id_puskesmas);
                        }
                    })
                    ->latest()
                    ->take(10)
                    ->get();

                // 🔐 Tentukan allowed routes berdasarkan id_instansi
                $allowedRoutes = $this->getAllowedRoutesByInstansi($admin->id_instansi ?? 0);

                // Kirim ke semua view
                $view->with([
                    'notifikasiAktivitas' => $notifikasiAktivitas,
                    'allowedRoutes' => $allowedRoutes,
                    'user' => $admin,
                ]);
            } else {
                $view->with([
                    'notifikasiAktivitas' => collect(),
                    'allowedRoutes' => [],
                    'user' => null,
                ]);
            }
        });
    }

    /**
     * 🔐 Mapping route berdasarkan id_instansi
     */
    private function getAllowedRoutesByInstansi($id_instansi)
    {
        switch ($id_instansi) {
            case 2: // 🏥 Dinas Kesehatan
                return [
                    'admin.sehat.*',
                    'admin.dumas.aduan.*',
                    'admin.kategori.*',
                ];

            case 3: // 🎓 Dinas Pendidikan
                return [
                    'admin.sekolah.*',
                    'admin.dumas.aduan.*',
                    'admin.kategori.*',
                ];

            case 1: // 🛒 Dinas Perdagangan
                return [
                    'admin.pasar.*',
                    'admin.dumas.aduan.*',
                    'admin.kategori.*',
                ];

            case 4: // 🏖️ Dinas Pariwisata
                return [
                    'admin.plesir.*',
                    'admin.dumas.aduan.*',
                    'admin.kategori.*',
                ];

            case 5: // 🕌 Dinas Keagamaan
                return [
                    'admin.ibadah.*',
                    'admin.dumas.aduan.*',
                    'admin.kategori.*',
                ];

            case 6: // 🧾 Dinas Perpajakan
                return [
                    'admin.pajak.*',
                    'admin.dumas.aduan.*',
                    'admin.kategori.*',
                ];

            case 7: // 👷 Dinas Tenaga Kerja
                return [
                    'admin.kerja.*',
                    'admin.dumas.aduan.*',
                    'admin.kategori.*',
                ];

            case 8: // 🧍 Dinas Kependudukan
                return [
                    'admin.adminduk.*',
                    'admin.dumas.aduan.*',
                    'admin.kategori.*',
                ];

            case 9: // 🏗️ Dinas Pembangunan
                return [
                    'admin.renbang.*',
                    'admin.dumas.aduan.*',
                    'admin.kategori.*',
                ];

            case 10: // 📜 Dinas Perizinan
                return [
                    'admin.izin.*',
                    'admin.dumas.aduan.*',
                    'admin.kategori.*',
                ];

            default:
                return ['admin.dashboard']; // Default minimal akses
        }
    }
}
