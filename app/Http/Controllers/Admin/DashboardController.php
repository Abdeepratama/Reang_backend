<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\Slider;
use App\Models\Banner;
use App\Models\Ibadah;
use App\Models\Sehat;
use App\Models\Pasar;
use App\Models\Plesir;
use App\Models\Aktivitas;
use App\Models\Dumas;
use App\Models\TempatSekolah;
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
use App\Models\TempatOlahraga;

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
            'jumlah_sekolah' => TempatSekolah::count(),
            'jumlah_info_sekolah' => InfoSekolah::count(),
            'jumlah_sehat' => Sehat::count(),
            'jumlah_info_kesehatan' => InfoKesehatan::count(),
            'jumlah_lokasi_olahraga' => TempatOlahraga::count(),
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
    public function apiBanner()
    {
        $banners = Banner::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $banners->map(function ($banner) {
                return [
                    'id' => $banner->id,
                    'judul' => $banner->judul,
                    'foto' => asset('storage/' . $banner->foto),
                    'deskripsi' => $banner->deskripsi,
                ];
            }),
        ]);
    }

    // Tampilkan daftar banner di admin
    public function bannerIndex()
    {
        $items = Banner::latest()->get();
        return view('admin.banner.index', compact('items'));
    }

    // Form tambah banner
    public function bannerCreate()
    {
        return view('admin.banner.create');
    }

    // Simpan banner baru
    public function bannerStore(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'foto' => 'required|image|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $foto = $request->file('foto')->store('banner', 'public');

        Banner::create([
            'judul' => $request->judul,
            'foto' => $foto,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.banner.index')->with('success', 'Banner berhasil ditambahkan.');
    }

    // Form edit banner
    public function bannerEdit($id)
    {
        $item = Banner::findOrFail($id);
        return view('admin.banner.edit', compact('item'));
    }

    // Update banner
    public function bannerUpdate(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $item = Banner::findOrFail($id);

        if ($request->hasFile('foto')) {
            if (Storage::disk('public')->exists($item->foto)) {
                Storage::disk('public')->delete($item->foto);
            }
            $item->foto = $request->file('foto')->store('banner', 'public');
        }

        $item->judul = $request->judul;
        $item->deskripsi = $request->deskripsi;
        $item->save();

        return redirect()->route('admin.banner.index')->with('success', 'Banner berhasil diperbarui.');
    }

    // Hapus banner
    public function bannerDestroy($id)
    {
        $item = Banner::findOrFail($id);

        if (Storage::disk('public')->exists($item->foto)) {
            Storage::disk('public')->delete($item->foto);
        }

        $item->delete();

        return redirect()->route('admin.banner.index')->with('success', 'Banner berhasil dihapus.');
    }

    public function uploadBanner(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . preg_replace('/\s+/', '', $file->getClientOriginalName());

            // simpan ke storage/app/public/banner_uploads
            $path = $file->storeAs('banner_uploads', $filename, 'public');

            // CKEditor butuh absolute URL
            $url = request()->getSchemeAndHttpHost() . '/storage/' . $path;

            return response()->json([
                'uploaded' => true,
                'url'      => $url
            ]);
        }

        return response()->json([
            'uploaded' => false,
            'error'    => [
                'message' => 'No file uploaded'
            ]
        ], 400);
    }

    /**
     * Utility: ambil path relatif dari kolom foto
     */
    private function getStoragePathFromFoto($foto)
    {
        if (!$foto) return null;

        // Jika sudah path relatif
        if (strpos($foto, 'http://') !== 0 && strpos($foto, 'https://') !== 0) {
            return $foto;
        }

        // Jika mengandung /storage/ di URL
        if (preg_match('#/storage/(.+)$#', $foto, $matches)) {
            return $matches[1];
        }

        // Jika tidak menemukan, ambil path dari URL
        $path = parse_url($foto, PHP_URL_PATH);
        if ($path) {
            $path = ltrim($path, '/');
            if (strpos($path, 'storage/') === 0) {
                return substr($path, strlen('storage/'));
            }
            return $path;
        }

        return null;
    }

    private function buildFotoUrl($storagePath)
    {
        if (!$storagePath) return null;
        return request()->getSchemeAndHttpHost() . '/storage/' . ltrim($storagePath, '/');
    }

    /**
     * Replace semua <img src="..."> di deskripsi agar pakai base URL dinamis
     */
    private function replaceImageUrlsInHtml($content)
    {
        if (!$content) return $content;

        return preg_replace_callback('/(<img\b[^>]*\bsrc\s*=\s*[\'"])([^\'"]+)([\'"][^>]*>)/i', function ($m) {
            $prefix = $m[1];
            $src = $m[2];
            $suffix = $m[3];

            // Biarkan data URI
            if (preg_match('/^data:/i', $src)) {
                return $m[0];
            }

            // CASE 1: absolute URL dengan /storage/
            if (preg_match('#^https?://[^/]+/storage/(.+)$#i', $src, $matches)) {
                $rel = $matches[1];
                $new = request()->getSchemeAndHttpHost() . '/storage/' . ltrim($rel, '/');
                return $prefix . $new . $suffix;
            }

            // CASE 2: absolute URL dengan /uploads/, /foto_kesehatan/, /tempat_olahraga/
            if (preg_match('#^https?://[^/]+/(uploads/.+|foto_kesehatan/.+|tempat_olahraga/.+)$#i', $src, $matches)) {
                $rel = $matches[1];
                $new = request()->getSchemeAndHttpHost() . '/storage/' . ltrim($rel, '/');
                return $prefix . $new . $suffix;
            }

            // CASE 3: relative path
            if (preg_match('#^(uploads/|foto_kesehatan/|tempat_olahraga/)#i', $src)) {
                $new = request()->getSchemeAndHttpHost() . '/storage/' . ltrim($src, '/');
                return $prefix . $new . $suffix;
            }

            // CASE 4: path diawali /storage/
            if (strpos($src, '/storage/') === 0) {
                $rel = ltrim(substr($src, strlen('/storage/')), '/');
                $new = request()->getSchemeAndHttpHost() . '/storage/' . $rel;
                return $prefix . $new . $suffix;
            }

            return $m[0];
        }, $content);
    }
}
