<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CRUDHelper;
use App\Models\Renbang;
use Illuminate\Http\Request;

class RenbangController extends Controller
{
    use CRUDHelper;

    public function __construct()
    {
        $this->model = Renbang::class;
        $this->routePrefix = 'renbang.deskripsi'; // prefix untuk route resource
        $this->viewPrefix = 'renbang.deskripsi'; // resources/views/admin/renbang/deskripsi
        $this->aktivitasTipe = 'Renbang';
        $this->aktivitasCreateMessage = 'Deskripsi renbang berhasil ditambahkan.';
        $this->validationRules = [
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori' => 'required|in:Infrastruktur,Pendidikan,Kesehatan,Ekonomi',
            'gambar' => 'nullable|image|max:2048',
        ];
    }

    public function index()
    {
        return view('admin.renbang.index');
    }

    public function deskripsiIndex()
    {
        $items = Renbang::latest()->get();
        return view('admin.renbang.deskripsi.index', compact('items'));
    }
}
