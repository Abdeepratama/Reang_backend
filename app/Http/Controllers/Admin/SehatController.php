<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CRUDHelper;
use App\Models\Sehat;
use Illuminate\Http\Request;

class SehatController extends Controller
{
    use CRUDHelper;

    public function __construct()
    {
        $this->model = Sehat::class;
        $this->routePrefix = 'sehat';
        $this->viewPrefix = 'sehat';
        $this->aktivitasTipe = 'Sehat';
        $this->aktivitasCreateMessage = 'Tempat sehat baru ditambahkan';
        $this->validationRules = [
            'name' => 'required|string',
            'address' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ];
    }

    public function tempat()
    {
        $items = Sehat::all();
        return view('admin.sehat.tempat.index', compact('items'));
    }
}
