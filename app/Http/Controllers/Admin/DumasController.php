<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dumas;
use App\Models\DumasRating;
use App\Models\UserData;
use App\Models\Kategori_dumas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DumasController extends Controller
{
    // =======================================================================
    // API ENDPOINTS (UNTUK FLUTTER)
    // =======================================================================

    public function publicIndex()
    {
        $userId = request()->query('user_id');

        // PERBAIKAN: Eager load relasi 'kategori' untuk efisiensi
        $query = Dumas::with('kategori')->orderBy('created_at', 'desc');

        if (!is_null($userId) && $userId !== '') {
            $query->where('user_id', $userId);
        }

        $paginator = $query->paginate(10);

        $paginator->getCollection()->transform(function ($item) {
            if ($item->bukti_laporan) {
                $item->bukti_laporan = url(Storage::url($item->bukti_laporan));
            }
            // PERBAIKAN: Menambahkan nama kategori dari relasi
            $item->kategori_laporan = $item->kategori->nama_kategori ?? 'Umum';
            return $item;
        });

        return $paginator;
    }

    public function publikShow(Request $request, $id)
    {
        // Eager load relasi 'ratings' dan 'kategori'
        $dumas = Dumas::with(['ratings', 'kategori'])->find($id);

        if (!$dumas) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $data = $dumas->toArray();
        if ($dumas->bukti_laporan) {
            $data['bukti_laporan'] = url(Storage::url($dumas->bukti_laporan));
        }

        // Ambil ulasan pertama (dan satu-satunya) yang ada untuk laporan ini.
        $rating = $dumas->ratings->first();
        
        // Selalu sertakan data ulasan dalam respons jika ada
        $data['user_rating'] = $rating ? $rating->rating : null;
        $data['user_comment'] = $rating ? $rating->comment : null;

        // Hapus relasi mentah agar respons JSON bersih.
        unset($data['ratings']);

        return response()->json($data);
    }

    // --- PENAMBAHAN: Endpoint baru untuk mengambil daftar kategori ---
    public function getKategori()
    {
        // Ambil semua nama kategori unik dan urutkan berdasarkan nama
        $kategori = Kategori_dumas::orderBy('nama_kategori', 'asc')->pluck('nama_kategori');

        return response()->json($kategori, 200);
    }

    // =======================================================================
    // ADMIN PANEL & API STORE (LOGIKA BARU ANDA)
    // =======================================================================

    public function index()
    {
        $user = Auth::guard('admin')->user();

        if ($user->role === 'superadmin') {
            // Superadmin lihat semua aduan
            $items = Dumas::with(['kategori.instansi', 'ratings'])->get();
        } else {
            // Admin dinas, ambil id_instansi dari user_data
            $userData = UserData::where('id_admins', $user->id)->first();
            $idInstansi = $userData?->id_instansi;

            $items = Dumas::with(['kategori.instansi', 'ratings'])
                ->whereHas('kategori', function ($q) use ($idInstansi) {
                    $q->where('id_instansi', $idInstansi);
                })
                ->get();
        }

        return view('admin.dumas.aduan.index', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori'   => 'required|exists:kategori_dumas,nama_kategori',
            'jenis_laporan'   => 'required',
            'lokasi_laporan'  => 'required',
            'deskripsi'       => 'required',
            'pernyataan'      => 'nullable|string',
            'bukti_laporan'   => 'nullable|image',
        ]);

        // Cari kategori berdasarkan nama
        $kategori = Kategori_dumas::where('nama_kategori', $request->nama_kategori)->first();

        $dumas = new Dumas();
        $dumas->id_kategori    = $kategori->id; // simpan id hasil pencarian
        $dumas->jenis_laporan  = $request->jenis_laporan;
        $dumas->lokasi_laporan = $request->lokasi_laporan;
        $dumas->pernyataan     = $request->pernyataan;
        $dumas->deskripsi      = $request->deskripsi;

        if ($request->user()) {
            $dumas->user_id = $request->user()->id;
        }

        if ($request->hasFile('bukti_laporan')) {
            $path = $request->file('bukti_laporan')->store('bukti_laporan', 'public');
            $dumas->bukti_laporan = $path;
        }

        $dumas->status = 'menunggu';
        $dumas->save();

        // Load relasi 'kategori' untuk disertakan dalam respons
        $dumasResponse = $dumas->load('kategori')->toArray();
        if ($dumas->bukti_laporan) {
            $dumasResponse['bukti_laporan'] = url(Storage::url($dumas->bukti_laporan));
        }
        // Tambahkan nama kategori secara manual untuk konsistensi
        $dumasResponse['kategori_laporan'] = $kategori->nama_kategori;


        return response()->json([
            'message' => 'Pengaduan berhasil ditambahkan',
            'data'    => $dumasResponse,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $dumas = Dumas::findOrFail($id);

        $request->validate([
            'status'     => 'nullable|in:menunggu,diproses,selesai,ditolak',
            'tanggapan'  => 'nullable|string',
        ]);

        if ($request->filled('status')) {
            $dumas->status = $request->status;
            $dumas->tanggapan = null;
        }

        if ($request->filled('tanggapan')) {
            $dumas->tanggapan = $request->tanggapan;
        }

        $dumas->save();

        return back()->with('success', 'Data berhasil diperbarui!');
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