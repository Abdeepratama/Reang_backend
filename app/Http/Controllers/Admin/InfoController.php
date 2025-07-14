<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CRUDHelper;
use App\Models\Info;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    use CRUDHelper;

    public function __construct()
    {
        $this->model = Info::class;
        $this->routePrefix = 'info'; // route name: admin.info.*
        $this->viewPrefix = 'info';  // folder: resources/views/admin/info/
        $this->viewSubfolder = '';   // tidak pakai subfolder
        $this->aktivitasTipe = 'Informasi';
        $this->aktivitasCreateMessage = 'Informasi baru telah ditambahkan';

        $this->validationRules = [
            'judul' => 'required|string|max:255',
            'isi'   => 'required|string',
        ];
    }

    public function dashboard()
{
    $items = Info::latest()->take(10)->get(); // Ambil 10 info terbaru
    return view('admin.info.index', compact('items'));
}

}
