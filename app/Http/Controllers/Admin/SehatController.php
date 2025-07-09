<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sehat;
use Illuminate\Http\Request;
use App\Models\Aktivitas;


class SehatController extends Controller
{
    public function index()
    {
        $sehat = Sehat::latest()->get();
        return view('admin.sehat.index', compact('sehat'));
    }

    public function create()
    {
        return view('admin.sehat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Aktivitas::create([
        'keterangan' => 'Menambahkan Lokasi Rumah Sakit ' . $request->nama,
        'tipe' => 'sehat',
        ]);

        Sehat::create($request->all());
        return redirect()->route('admin.sehat.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit(Sehat $sehat)
    {
        return view('admin.sehat.edit', compact('sehat'));
    }

    public function update(Request $request, Sehat $sehat)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $sehat->update($request->all());
        return redirect()->route('admin.sehat.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Sehat $sehat)
    {
        $sehat->delete();
        return redirect()->route('admin.sehat.index')->with('success', 'Data berhasil dihapus.');
    }
}
