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

    public function tempat()
    {
        $items = Ibadah::all();
        return view('admin.ibadah.tempat.index', compact('items'));
    }

    public function map()
    {
        $items = Ibadah::all();
        $center = $items->isNotEmpty()
            ? [$items->first()->latitude, $items->first()->longitude]
            : [-6.3274, 108.3270]; // Default center: Indramayu

        return view('admin.ibadah.tempat.map', compact('items', 'center'));
    }
}
