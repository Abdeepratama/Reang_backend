<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plesir;
use Illuminate\Http\Request;
use App\Models\Aktivitas;


class PlesirController extends Controller
{
    public function index()
    {
        $data = Plesir::latest()->get();
        return view('admin.plesir.index', compact('data'));
    }

    public function create()
    {
        return view('admin.plesir.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        Aktivitas::create([
        'keterangan' => 'Menambahkan Tempat Plesir ' . $request->nama,
        'tipe' => 'plesir',
        ]);

        Plesir::create($request->all());

        return redirect()->route('admin.plesir.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(Plesir $plesir)
    {
        return view('admin.plesir.edit', compact('plesir'));
    }

    public function update(Request $request, Plesir $plesir)
    {
        $request->validate([
            'name' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $plesir->update($request->all());

        return redirect()->route('admin.plesir.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(Plesir $plesir)
    {
        $plesir->delete();
        return redirect()->route('admin.plesir.index')->with('success', 'Data berhasil dihapus');
    }
}
