<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dumas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DumasController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'jenis_laporan'    => 'required',
            'lokasi_laporan'   => 'required',
            'kategori_laporan' => 'required',
            'deskripsi'        => 'required',
            'bukti_laporan'    => 'nullable|image',
        ]);

        $dumas = new Dumas();
        $dumas->jenis_laporan    = $request->jenis_laporan;
        $dumas->lokasi_laporan   = $request->lokasi_laporan;
        $dumas->kategori_laporan = $request->kategori_laporan;
        $dumas->deskripsi        = $request->deskripsi;

        // Mapping kategori -> dinas
        $mapKategori = [
            'kesehatan'     => 'kesehatan',
            'pendidikan'    => 'pendidikan',
            'perpajakan'    => 'perpajakan',
            'perdagangan'   => 'perdagangan',
            'pariwisata'    => 'pariwisata',
            'kerja'         => 'kerja',
            'pariwisata'    => 'pariwisata',
            'keagamaan'     => 'keagamaan',
            'kependudukan'  => 'kependudukan',
            'pembangunan'   => 'pembangunan',
            'perizinan'     => 'perizinan'
        ];

        // jika admin dinas login, ambil langsung dari profil admin
        $user = Auth::guard('admin')->user();
        if ($user && $user->role === 'admindinas') {
            $dumas->dinas = $user->dinas;
        } else {
            // kalau dari kategori
            $dumas->dinas = $mapKategori[strtolower($request->kategori_laporan)] ?? 'lainnya';
        }

        // simpan file kalau ada
        if ($request->hasFile('bukti_laporan')) {
            $path = $request->file('bukti_laporan')->store('bukti_laporan', 'public');
            $dumas->bukti_laporan = $path;
        }

        $dumas->status = 'menunggu';
        $dumas->save();

        return response()->json([
            'message' => 'Pengaduan berhasil ditambahkan',
            'data'    => $dumas,
        ], 201);
    }

    public function index(Request $request)
    {
        $user = Auth::guard('admin')->user();

        if ($user->role === 'superadmin') {
            $items = Dumas::orderByRaw("CASE 
                WHEN status = 'selesai' THEN 2 
                ELSE 1 END")
                ->orderBy('created_at', 'desc') // data baru tetap di atas, kecuali selesai selalu di bawah
                ->get();
        } elseif ($user->role === 'admindinas') {
            $items = Dumas::where('dinas', $user->dinas)
                ->orderByRaw("CASE 
                WHEN status = 'selesai' THEN 2 
                ELSE 1 END")
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $items = collect();
        }

        return view('admin.dumas.aduan.index', compact('items'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak'
        ]);

        $dumas = Dumas::findOrFail($id);
        $dumas->status = $request->status;
        $dumas->save();

        return back()->with('success', 'Status berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $dumas = Dumas::findOrFail($id);

        if ($dumas->bukti_laporan && Storage::disk('public')->exists($dumas->bukti_laporan)) {
            Storage::disk('public')->delete($dumas->bukti_laporan);
        }

        $dumas->delete();

        return back()->with('success', 'Data berhasil dihapus!');
    }
}
