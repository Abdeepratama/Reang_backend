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
        $this->routePrefix = 'dumas.aduan';
        $this->viewPrefix = 'dumas.aduan';
        $this->aktivitasTipe = 'dumas';
        $this->aktivitasCreateMessage = 'Pengaduan baru telah ditambahkan';
        $this->validationRules = [
            'jenis_laporan' => 'required',
            'bukti_laporan' => 'nullable|image',
            'lokasi_laporan' => 'required',
            'kategori_laporan' => 'required',
            'deskripsi' => 'required',
        ];
    }

    public function index()
    {
        return view('admin.dumas.index');
    }

    public function aduanIndex()
    {
        $items = Dumas::latest()->get();
        return view('admin.dumas.aduan.index', compact('items'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
        ]);

        $dumas = Dumas::findOrFail($id);
        $dumas->status = $request->status;
        $dumas->save();

        return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui.');
    } 
}
