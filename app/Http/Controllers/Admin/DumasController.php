<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CRUDHelper;
use App\Models\Dumas;
use Illuminate\Http\Request;


class DumasController extends Controller
{
    use CRUDHelper;

    public function __construct()
    {
        $this->model = Dumas::class;
        $this->routePrefix = 'dumas';
        $this->viewPrefix = 'dumas';
        $this->viewSubfolder = 'aduan';
        $this->aktivitasTipe = 'Pengaduan Masyarakat';
        $this->aktivitasCreateMessage = 'Pengaduan baru telah ditambahkan';
        $this->validationRules = [
            'jenis_laporan' => 'required',
            'bukti_laporan' => 'nullable|image',
            'lokasi_laporan' => 'required',
            'kategori_laporan' => 'required',
            'deskripsi' => 'required',
        ];
    }

    public function aduan()
    {
        $items = Dumas::latest()->get(); // Atau sesuai kebutuhanmu
        return view('dumas.aduan.index', compact('items'));
    }

    public function update(Request $request, $id)
    {
        // Validasi hanya status (jika hanya ubah status)
        $request->validate([
            'status' => 'required|in:masuk,diproses,selesai,ditolak',
        ]);

        // Ambil data berdasarkan ID
        $dumas = Dumas::findOrFail($id);

        // Update status
        $dumas->status = $request->status;
        $dumas->save();

        // Redirect balik ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Status aduan berhasil diperbarui.');
    }
}
