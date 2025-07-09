<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Aktivitas;

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
        // Untuk semua view di dalam folder admin/layouts/*
        View::composer('admin.layouts.*', function ($view) {
            $notifikasiAktivitas = Aktivitas::latest()->take(5)->get();
            $jumlahNotifikasi = Aktivitas::where('dibaca', false)->count();

            $view->with('notifikasiAktivitas', $notifikasiAktivitas)
                ->with('jumlahNotifikasi', $jumlahNotifikasi);
        });
    }
}
