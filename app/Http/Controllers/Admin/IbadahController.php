<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CRUDHelper;
use App\Models\Ibadah;
use Illuminate\Http\Request;

class IbadahController extends Controller
{
    use CRUDHelper;

    public function __construct()
    {
        $this->model = Ibadah::class;
        $this->routePrefix = 'ibadah';
        $this->viewPrefix = 'ibadah';
        $this->aktivitasTipe = 'Ibadah';
        $this->aktivitasCreateMessage = 'Tempat ibadah baru ditambahkan';
        $this->validationRules = [
            'name' => 'required|string',
            'address' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
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
