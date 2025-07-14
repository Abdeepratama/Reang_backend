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
        $items = Dumas::all();
        return view('admin.dumas.aduan.index', compact('items'));
    }
}
