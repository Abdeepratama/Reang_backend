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
            'pernyataan'        => 'nullable|boolean',
        ];
    }

    public function aduan()
    {
        // bisa ubah jadi view mana pun
        return view('sekolah.aduan.index');
    }
}
