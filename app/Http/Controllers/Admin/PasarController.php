<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CRUDHelper;
use App\Models\Pasar;

class PasarController extends Controller
{
    use CRUDHelper;

    public function __construct()
    {
        $this->model = Pasar::class;
        $this->routePrefix = 'pasar';
        $this->viewPrefix = 'pasar';
        $this->aktivitasTipe = 'Pasar';
        $this->aktivitasCreateMessage = 'Lokasi Pasar baru ditambahkan';
        $this->validationRules = [
            'name' => 'required|string',
            'address' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ];
    }

    public function tempat()
    {
        $items = Pasar::all();
        return view('admin.pasar.tempat.index', compact('items'));
    }
}
