<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JasaPengiriman;
use Illuminate\Http\Request;

class JasaPengirimanController extends Controller
{
    public function index()
    {
        $jasa = JasaPengiriman::latest()->get();

        return view('admin.jasa.index', compact('jasa'));
    }

    public function create()
    {
        return view('admin.jasa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:jasa_pengiriman,nama',
        ]);

        JasaPengiriman::create([
            'nama' => $request->nama
        ]);

        return redirect()->route('admin.jasa.index')
            ->with('success', 'Jasa pengiriman berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jasa = JasaPengiriman::findOrFail($id);

        return view('admin.jasa.edit', compact('jasa'));
    }

    public function update(Request $request, $id)
    {
        $jasa = JasaPengiriman::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255|unique:jasa_pengiriman,nama,' . $jasa->id,
        ]);

        $jasa->update([
            'nama' => $request->nama
        ]);

        return redirect()->route('admin.jasa.index')
            ->with('success', 'Jasa pengiriman berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $jasa = JasaPengiriman::findOrFail($id);
        $jasa->delete();

        return redirect()->route('admin.jasa.index')
            ->with('success', 'Jasa pengiriman berhasil dihapus!');
    }

    // =======================================================================
    // API ENDPOINT
    // =======================================================================
    public function apiIndex()
    {
        $data = JasaPengiriman::select('id', 'nama', 'created_at', 'updated_at')
            ->orderBy('nama', 'ASC')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Data Jasa Pengiriman',
            'data' => $data
        ], 200);
    }
}
