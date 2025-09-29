<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori_dumas;
use App\Models\Instansi;
use Illuminate\Http\Request;

class KategoriDumasController extends Controller
{
    public function index()
    {
        $kategoris = Kategori_dumas::with('instansi')->get();
        return view('admin.kategori_dumas.index', compact('kategoris'));
    }

    public function create()
    {
        $instansis = Instansi::all();
        return view('admin.kategori_dumas.create', compact('instansis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_instansi'   => 'required|exists:instansi,id',
            'nama_kategori' => 'required|string|max:255',
        ]);

        Kategori_dumas::create($request->only('id_instansi', 'nama_kategori'));

        return redirect()->route('admin.kategori_dumas.index')
                         ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kategori = Kategori_dumas::findOrFail($id);
        $instansis = Instansi::all();
        return view('admin.kategori_dumas.edit', compact('kategori', 'instansis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_instansi'   => 'required|exists:instansi,id',
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori = Kategori_dumas::findOrFail($id);
        $kategori->update($request->only('id_instansi', 'nama_kategori'));

        return redirect()->route('admin.kategori_dumas.index')
                         ->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kategori = Kategori_dumas::findOrFail($id);
        $kategori->delete();

        return redirect()->route('admin.kategori_dumas.index')
                         ->with('success', 'Kategori berhasil dihapus!');
    }
}
