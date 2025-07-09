<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ibadah;
use App\Models\Aktivitas;

class IbadahController extends Controller
{
    public function index()
    {
        $ibadah = Ibadah::latest()->get();
        return view('admin.ibadah.index', compact('ibadah'));
    }

    public function create()
    {
        return view('admin.ibadah.create');
    }

    public function show(Ibadah $ibadah)
    {
        return view('admin.ibadah.show', compact('ibadah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $ibadah = Ibadah::create($request->all());

        Aktivitas::create([
            'keterangan' => 'Tempat ibadah baru ditambahkan',
            'tipe' => 'Ibadah',
            'url' => route('admin.ibadah.index', $ibadah->id), 
            'dibaca' => false, 
        ]);

        return redirect()->route('admin.ibadah.index')->with('success', 'Tempat ibadah berhasil ditambahkan.');
    }

    public function edit(Ibadah $ibadah)
    {
        return view('admin.ibadah.edit', compact('ibadah'));
    }

    public function update(Request $request, Ibadah $ibadah)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $ibadah->update($request->all());

        return redirect()->route('admin.ibadah.index')->with('success', 'Tempat ibadah berhasil diperbarui.');
    }

    public function destroy(Ibadah $ibadah)
    {
        $ibadah->delete();

        return redirect()->route('admin.ibadah.index')->with('success', 'Tempat ibadah berhasil dihapus.');
    }

    public function api()
    {
        return response()->json([
            'status' => 'success',
            'data' => Ibadah::select('id', 'name', 'address', 'latitude', 'longitude')->get()
        ]);
    }
}
