<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CRUDHelper;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    use CRUDHelper;

    public function __construct()
    {
        $this->model = Sekolah::class;
        $this->routePrefix = 'sekolah'; // sesuai route name: admin.sekolah.aduan.index
        $this->viewPrefix = 'sekolah';  // views/admin/sekolah/aduan/
        $this->viewSubfolder = 'aduan';
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

    public function aduan()
    {
        // bisa ubah jadi view mana pun
        return view('sekolah.aduan.index');
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
    if ($item->bukti_laporan && file_exists(public_path($item->bukti_laporan))) {
        unlink(public_path($item->bukti_laporan));
    }

    $item->delete();

    // Simpan aktivitas & notifikasi jika diperlukan
    $this->logAktivitas("Menghapus Aduan Sekolah");
    $this->logNotifikasi("Aduan Sekolah telah dihapus.");

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('admin.sekolah.aduan.index')
        ->with('success', 'Aduan berhasil dihapus.');
}
}
