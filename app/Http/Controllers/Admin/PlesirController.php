<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CRUDHelper;
use App\Models\Plesir;

class PlesirController extends Controller
{
    use CRUDHelper;

    public function __construct()
    {
        $this->model = Plesir::class;
        $this->routePrefix = 'plesir';
        $this->viewPrefix = 'plesir';
        $this->aktivitasTipe = 'Lokasi Plesir';
        $this->aktivitasCreateMessage = 'Lokasi Plesir telah ditambahkan';
        $this->validationRules = [
            'name' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ];
    }

    public function edit($id)
    {
        $item = ($this->model)::findOrFail($id);
        $varName = strtolower(class_basename($this->model)); // ibadah, pasar, dll
        return view("admin.{$this->viewPrefix}.edit", [
            $varName => $item,
        ]);
    }
}
