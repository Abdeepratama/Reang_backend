<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasar;
use App\Models\Aktivitas;


class PasarController extends Controller
{
    public function index()
    {
        $pasar = Pasar::latest()->get();
        return view('admin.pasar.index', compact('pasar'));
    }

    public function create()
    {
        return view('admin.pasar.create');
    }

    public function store(Request $request)
    {
        Pasar::create($request->validate([
            'name' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]));

       $data = $request->all();

        $ibadah = Pasar::create($data);

        Aktivitas::create([
            'keterangan' => 'Lokasi Pasar telah ditambahkan',
            'tipe' => 'Pasar',
            'url' => route('admin.ibadah.index', $ibadah->id),
        ]);

        return redirect()->route('admin.pasar.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pasar = Pasar::findOrFail($id);
        return view('admin.pasar.edit', compact('pasar'));
    }

    public function update(Request $request, $id)
    {
        $pasar = Pasar::findOrFail($id);
        $pasar->update($request->validate([
            'name' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]));

        return redirect()->route('admin.pasar.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Pasar::destroy($id);
        return back()->with('success', 'Data berhasil dihapus.');
    }
}
