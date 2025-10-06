<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Puskesmas;
use App\Models\Kategori;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function index()
    {
        $dokter = Dokter::with(['puskesmas', 'kategori'])->orderBy('id', 'desc')->get();
        return view('admin.sehat.dokter.index', compact('dokter'));
    }

    public function create()
    {
        $puskesmas = Puskesmas::orderBy('nama')->get();
        $kategoriDokter = Kategori::where('fitur', 'dokter')->orderBy('nama')->get();

        return view('admin.sehat.dokter.create', compact('puskesmas', 'kategoriDokter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_puskesmas' => 'required|integer|exists:puskesmas,id',
            'nama'         => 'required|string|max:255',
            'pendidikan'   => 'required|string|max:255',
            'fitur'        => 'required|string',
            'umur'         => 'required|integer',
            'nomer'        => 'required|string|max:255',
        ]);

        Dokter::create($request->all());

        return redirect()->route('admin.sehat.dokter.index')
            ->with('success', 'Data dokter berhasil ditambahkan');
    }

    public function edit(Dokter $dokter)
    {
        $puskesmas = Puskesmas::orderBy('nama')->get();
        $kategoriDokter = Kategori::where('fitur', 'dokter')->orderBy('nama')->get();

        return view('admin.sehat.dokter.edit', compact('dokter', 'puskesmas', 'kategoriDokter'));
    }

    public function update(Request $request, Dokter $dokter)
    {
        $request->validate([
            'id_puskesmas' => 'required|integer|exists:puskesmas,id',
            'nama'         => 'required|string|max:255',
            'pendidikan'   => 'required|string|max:255',
            'fitur'        => 'required|string',
            'umur'         => 'required|integer',
            'nomer'        => 'required|string|max:255',
        ]);

        $dokter->update($request->all());

        return redirect()->route('admin.sehat.dokter.index')
            ->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(Dokter $dokter)
    {
        $dokter->delete();
        return redirect()->route('admin.sehat.dokter.index')
            ->with('success', 'Data berhasil dihapus');
    }

    // api/dokter
    public function apiIndex()
    {
        $dokter = Dokter::with('puskesmas') // tanpa kategori
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($dokter);
    }

    public function apiShow($id = null)
    {
        if ($id) {
            $dokter = Dokter::with('puskesmas')->find($id);
            if (!$dokter) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
            return response()->json($dokter);
        }

        $dokter = Dokter::with('puskesmas')->get();
        return response()->json($dokter);
    }
}
