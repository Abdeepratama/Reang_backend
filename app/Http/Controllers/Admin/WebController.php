<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ibadah;

class WebController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Pemetaan',
        ];
        return view('admin.layouts.v_web', $data);
    }

    public function map()
    {
        $lokasiIbadah = Ibadah::all(); // Ambil semua data dari tabel 'tempat_ibadah'
        return view('admin.ibadah.tempat.map', compact('lokasiIbadah'));
    }
}
