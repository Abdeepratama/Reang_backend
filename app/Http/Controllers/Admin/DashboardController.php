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
use App\Models\NotifikasiAktivitas;


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
            'jumlah_dumas' => Dumas::count(),
            'jumlah_sekolah' => Sekolah::count(),
        ];

        $aktivitas = Aktivitas::latest()->take(10)->get();
        $notifications = NotifikasiAktivitas::unread()->latest()->take(10)->get();
        $jumlahNotifikasi = NotifikasiAktivitas::unread()->count();
        $sliders = Slider::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stats',
            'aktivitas',
            'notifications',
            'jumlahNotifikasi',
            'sliders' 
        ));
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
}
