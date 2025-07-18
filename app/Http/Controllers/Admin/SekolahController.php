<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CRUDHelper;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class SekolahController extends Controller
{
    use CRUDHelper;

    public function __construct()
    {
        $this->model = Sekolah::class;
        $this->routePrefix = 'sekolah'; // sesuai route name: admin.sekolah.aduan.index
        $this->viewPrefix = 'sekolah';  // views/admin/sekolah/aduan/
        $this->aktivitasTipe = 'Aduan Sekolah';
        $this->aktivitasCreateMessage = 'Aduan sekolah baru telah ditambahkan';

        $this->validationRules = [
            'jenis_laporan'     => 'required',
            'kategori_laporan'  => 'required',
            'lokasi_laporan'    => 'nullable|string',
            'bukti_laporan'     => 'nullable|image|max:2048',
            'deskripsi'         => 'required',
        ];
    }
    public function index()
    {
        return view('admin.sekolah.index');
    }

    public function aduanIndex()
    {
        $items = Sekolah::latest()->get();
        return view('admin.sekolah.aduan.index', compact('items'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules);

        if ($request->hasFile('bukti_laporan')) {
            $validated['bukti_laporan'] = $request->file('bukti_laporan')->store('bukti_sekolah', 'public');
        }

        $aduan = Sekolah::create($validated);

        // Catat aktivitas jika perlu
        $this->logAktivitas($this->aktivitasTipe, $this->aktivitasCreateMessage);

        return response()->json([
            'message' => 'Aduan sekolah berhasil ditambahkan.',
            'data' => $aduan
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validasi hanya status (jika hanya ubah status)
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
        ]);

        // Ambil data berdasarkan ID
        $dumas = Sekolah::findOrFail($id);

        // Update status
        $dumas->status = $request->status;
        $dumas->save();

        // Redirect balik ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Status aduan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = Sekolah::findOrFail($id);

        // Hapus file bukti jika ada
        if ($item->bukti_laporan && Storage::disk('public')->exists($item->bukti_laporan)) {
            Storage::disk('public')->delete($item->bukti_laporan);
        }

        $item->delete();

        // Simpan aktivitas & notifikasi jika diperlukan
        $this->logAktivitas("Menghapus Aduan Sekolah");
        $this->logNotifikasi("Aduan Sekolah telah dihapus.");

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.sekolah.index')
            ->with('success', 'Aduan berhasil dihapus.');
    }
}
