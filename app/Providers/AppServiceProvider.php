<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Aktivitas;
use App\Models\NotifikasiAktivitas;


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
            if (auth('admin')->check()) {
                $admin = auth('admin')->user();

                $notifikasiAktivitas = NotifikasiAktivitas::query()
                    ->when($admin->role !== 'superadmin', function ($q) use ($admin) {
                        $q->where('role', $admin->role)
                            ->where('dinas', $admin->dinas);
                    })
                    ->latest()
                    ->take(10)
                    ->get();

                $view->with('notifikasiAktivitas', $notifikasiAktivitas);
            } else {
                $view->with('notifikasiAktivitas', collect());
            }
        });
    }
}
