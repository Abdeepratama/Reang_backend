<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Puskesmas;
use Illuminate\Http\Request;

class PuskesmasController extends Controller
{
    public function index()
    {
        $puskesmas = Puskesmas::orderBy('id', 'desc')->get();
        return view('admin.sehat.puskesmas.index', compact('puskesmas'));
    }

    public function create()
    {
        return view('admin.sehat.puskesmas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'jam' => 'required|string',
        ]);

        Puskesmas::create($request->only(['nama', 'alamat', 'jam']));

        return redirect()->route('admin.sehat.puskesmas.index')
            ->with('success', 'Data puskesmas berhasil ditambahkan');
    }

    public function edit(Puskesmas $puskesma)
    {
        return view('admin.sehat.puskesmas.edit', compact('puskesma'));
    }

    public function update(Request $request, Puskesmas $puskesma)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'jam' => 'required|string',
        ]);

        $puskesma->update($request->all());

        return redirect()->route('admin.sehat.puskesmas.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(Puskesmas $puskesma)
    {
        $puskesma->delete();
        return redirect()->route('admin.sehat.puskesmas.index')->with('success', 'Data berhasil dihapus');
    }

    // GET /api/puskesmas
    public function apiIndex()
    {
        $puskesmas = Puskesmas::orderBy('id', 'desc')->paginate(10);
        return response()->json($puskesmas);
    }

    // GET /api/puskesmas/{id?}
    public function apiShow($id = null)
    {
        if ($id) {
            $data = Puskesmas::find($id);
            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
            return response()->json($data);
        }

        $data = Puskesmas::paginate(10);
        return response()->json($data);
    }

    public function apiSearch(Request $request)
    {
        $keyword = $request->query('q'); // ambil query ?q=

        $query = Puskesmas::query();

        if ($keyword) {
            $query->where('nama', 'like', "%{$keyword}%")
                ->orWhere('alamat', 'like', "%{$keyword}%")
                ->orWhere('jam', 'like', "%{$keyword}%");
        }

        $result = $query->orderBy('id', 'desc')->paginate(10);

        if ($result->isEmpty()) {
            return response()->json([
                'message' => 'Tidak ada hasil untuk pencarian "' . $keyword . '"',
                'data' => []
            ], 404);
        }

        return response()->json($result);
    }
}
