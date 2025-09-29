<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dumas;
use App\Models\UserData;
use App\Models\Kategori_dumas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DumasController extends Controller
{
    public function publicIndex()
    {
        $userId = request()->query('user_id');

        $query = Dumas::orderBy('created_at', 'desc');

        if (!is_null($userId) && $userId !== '') {
            $query->where('user_id', $userId);
        }

        $paginator = $query->paginate(10);

        $paginator->getCollection()->transform(function ($item) {
            if ($item->bukti_laporan) {
                $item->bukti_laporan = url(Storage::url($item->bukti_laporan));
            }
            return $item;
        });

        return $paginator;
    }

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
            'id_kategori'      => 'required|exists:kategori_dumas,id',
            'jenis_laporan'    => 'required',
            'lokasi_laporan'   => 'required',
            'deskripsi'        => 'required',
            'pernyataan'       => 'nullable|string',
            'bukti_laporan'    => 'nullable|image',
        ]);

        $dumas = new Dumas();
        $dumas->id_kategori    = $request->id_kategori;
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

        $dumasResponse = $dumas->load('kategori')->toArray();
        if ($dumas->bukti_laporan) {
            $dumasResponse['bukti_laporan'] = url(Storage::url($dumas->bukti_laporan));
        }

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

    public function publikShow($id)
    {
        $dumas = Dumas::find($id);

        if (!$dumas) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $data = $dumas->toArray();
        if ($dumas->bukti_laporan) {
            $data['bukti_laporan'] = url(Storage::url($dumas->bukti_laporan));
        }

        return response()->json($data);
    }
}
