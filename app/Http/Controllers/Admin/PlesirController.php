<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CRUDHelper;
use App\Models\Plesir;
use Illuminate\Http\Request;

class PlesirController extends Controller
{
    use CRUDHelper;

    public function __construct()
    {
        $this->model = Plesir::class;
        $this->routePrefix = 'plesir';
        $this->viewPrefix = 'plesir';
        $this->aktivitasTipe = 'Plesir';
        $this->aktivitasCreateMessage = 'Tempat plesir baru ditambahkan';
        $this->validationRules = [
            'name' => 'required|string',
            'address' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ];
    }

    public function tempat()
    {
        $items = Plesir::all();
        return view('admin.plesir.tempat.index', compact('items'));
    }
}
