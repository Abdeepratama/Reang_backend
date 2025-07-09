<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ibadah;
use App\Models\Sehat;
use App\Models\Pasar;
use App\Models\Plesir;
use App\Models\Aktivitas;
use App\Models\Pengaduan;

class DashboardController extends Controller
{
    public function index()
{
    $stats = [
        'total_users' => User::count(),
        'jumlah_ibadah' => Ibadah::count(),
        'terbaru_ibadah' => Ibadah::latest()->first(),
        'jumlah_sehat' => Sehat::count(),
        'jumlah_pasar' => Pasar::count(),
        'jumlah_plesir' => Plesir::count(),
        'jumlah_dumas' => Pengaduan::count(),


    ];

    $aktivitas = Aktivitas::latest()->take(10)->get();
    $notifikasiAktivitas = Aktivitas::latest()->take(5)->get();

    // Kirim kedua variabel ke view
    return view('admin.dashboard', compact('stats', 'aktivitas', 'notifikasiAktivitas'));
}
}
