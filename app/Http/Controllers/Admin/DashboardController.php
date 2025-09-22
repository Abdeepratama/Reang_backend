<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\Slider;
use App\Models\Ibadah;
use App\Models\Sehat;
use App\Models\Pasar;
use App\Models\Plesir;
use App\Models\Aktivitas;
use App\Models\Dumas;
use App\Models\Sekolah;
use App\Models\Renbang;
use App\Models\InfoSekolah;
use App\Models\InfoKesehatan;
use App\Models\InfoKeagamaan;
use App\Models\InfoAdminduk;
use App\Models\InfoPajak;
use App\Models\InfoKerja;
use App\Models\InfoPerizinan;
use App\Models\InfoPlesir;
use App\Models\NotifikasiAktivitas;
use App\Models\Tempat_olahraga;

class DashboardController extends Controller
{
    public function index()
{
    $stats = [
        'total_users' => User::count(),
        'jumlah_lokasi_pasar' => Pasar::count(),
        'jumlah_lokasi_plesir' => Plesir::count(),
        'jumlah_info_plesir' => InfoPlesir::count(),
        'jumlah_dumas' => Dumas::count(),
        'jumlah_sekolah' => Sekolah::count(),
        'jumlah_info_sekolah' => InfoSekolah::count(),
        'jumlah_sehat' => Sehat::count(),
        'jumlah_info_kesehatan' => InfoKesehatan::count(),
        'jumlah_lokasi_olahraga' => Tempat_olahraga::count(),
        'jumlah_info_pajak' => InfoPajak::count(),
        'jumlah_info_kerja' => InfoKerja::count(),
        'jumlah_lokasi_ibadah' => Ibadah::count(),
        'jumlah_info_keagamaan' => InfoKeagamaan::count(),
        'jumlah_info_kependudukan' => InfoAdminduk::count(),
        'jumlah_info_pembangunan' => Renbang::count(),
        'jumlah_info_perizinan' => InfoPerizinan::count(),
    ];

    $user = auth()->guard('admin')->user();

    // 🔹 Filter aktivitas
    $aktivitas = Aktivitas::query()
        ->when($user->role === 'admindinas', function ($q) use ($user) {
            $q->where('role', 'admindinas')
              ->where('dinas', $user->dinas);
        })
        ->latest()
        ->take(10)
        ->get();

    // 🔹 Filter notifikasi
    $notifications = NotifikasiAktivitas::query()
        ->unread()
        ->when($user->role === 'admindinas', function ($q) use ($user) {
            $q->where('role', 'admindinas')
              ->where('dinas', $user->dinas);
        })
        ->latest()
        ->take(10)
        ->get();

    $jumlahNotifikasi = NotifikasiAktivitas::query()
        ->unread()
        ->when($user->role === 'admindinas', function ($q) use ($user) {
            $q->where('role', 'admindinas')
              ->where('dinas', $user->dinas);
        })
        ->count();

    $sliders = Slider::latest()->take(5)->get();

    return view('admin.dashboard1', compact(
        'stats',
        'aktivitas',
        'notifications',
        'jumlahNotifikasi',
        'sliders'
    ));
}

    public function apiSlider()
    {
        $sliders = Slider::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $sliders->map(function ($slider) {
                return [
                    'id' => $slider->id,
                    'gambar' => asset('storage/' . $slider->gambar),
                ];
            }),
        ]);
    }

    public function sliderIndex()
    {
        $items = Slider::latest()->get();
        return view('admin.slider.index', compact('items'));
    }

    public function sliderCreate()
    {
        return view('admin.slider.create');
    }

    public function sliderStore(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|max:2048',
        ]);

        $gambar = $request->file('gambar')->store('slider', 'public');

        Slider::create(['gambar' => $gambar]);

        return redirect()->route('admin.slider.index')->with('success', 'Slider berhasil ditambahkan.');
    }

    public function sliderEdit($id)
    {
        $item = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('item'));
    }

    public function sliderUpdate(Request $request, $id)
    {
        $request->validate([
            'gambar' => 'nullable|image|max:2048',
        ]);

        $item = Slider::findOrFail($id);

        if ($request->hasFile('gambar')) {
            if (Storage::disk('public')->exists($item->gambar)) {
                Storage::disk('public')->delete($item->gambar);
            }
            $item->gambar = $request->file('gambar')->store('slider', 'public');
            $item->save();
        }

        return redirect()->route('admin.slider.index')->with('success', 'Slider berhasil diperbarui.');
    }

    public function sliderDestroy($id)
    {
        $item = Slider::findOrFail($id);

        if (Storage::disk('public')->exists($item->gambar)) {
            Storage::disk('public')->delete($item->gambar);
        }

        $item->delete();

        return redirect()->route('admin.slider.index')->with('success', 'Slider berhasil dihapus.');
    }

    //bannner
}
