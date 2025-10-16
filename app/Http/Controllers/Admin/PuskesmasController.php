<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Puskesmas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PuskesmasController extends Controller
{
    // --- Bagian Admin Panel (TIDAK DIUBAH) ---
    public function index()
    {
        $user = Auth::guard('admin')->user();

        // Superadmin: tampilkan semua
        if ($user->role === 'superadmin') {
            $puskesmas = Puskesmas::orderBy('id', 'desc')->get();
        }
        // Role puskesmas: tampilkan hanya puskesmas miliknya
        elseif ($user->role === 'puskesmas') {
            $idPuskesmas = optional($user->userData)->id_puskesmas;

            if (!$idPuskesmas) {
                abort(403, 'Akun Anda belum terhubung dengan data puskesmas.');
            }

            $puskesmas = Puskesmas::where('id', $idPuskesmas)->get();
        }
        // Role lain (misal admindinas) tidak punya akses
        else {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

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

    public function edit(Puskesmas $puskesmas)
    {
        return view('admin.sehat.puskesmas.edit', compact('puskesmas'));
    }

    public function update(Request $request, Puskesmas $puskesmas)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'jam' => 'required|string',
        ]);

        $puskesmas->update($request->all());

        return redirect()->route('admin.sehat.puskesmas.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(Puskesmas $puskesmas)
    {
        $puskesmas->delete();
        return redirect()->route('admin.sehat.puskesmas.index')->with('success', 'Data berhasil dihapus');
    }

    // --- Bagian API (DIPERBARUI) ---

    // GET /api/puskesmas
    public function apiIndex()
    {
        // --- DIPERBARUI ---
        $puskesmas = Puskesmas::withCount('dokter as dokter_tersedia')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return response()->json($puskesmas);
    }

    // GET /api/puskesmas/{id?}
    public function apiShow($id = null)
    {
        if ($id) {
            // --- DIPERBARUI ---
            $data = Puskesmas::withCount('dokter as dokter_tersedia')->find($id);
            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
            return response()->json($data);
        }

        // --- DIPERBARUI ---
        $data = Puskesmas::withCount('dokter as dokter_tersedia')->paginate(10);
        return response()->json($data);
    }

    public function apiSearch(Request $request)
    {
        $keyword = $request->query('q');

        // --- DIPERBARUI ---
        $query = Puskesmas::withCount('dokter as dokter_tersedia');

        if ($keyword) {
            $query->where('nama', 'like', "%{$keyword}%")
                ->orWhere('alamat', 'like', "%{$keyword}%")
                ->orWhere('jam', 'like', "%{$keyword}%");
        }

        $result = $query->orderBy('id', 'desc')->paginate(10);

        return response()->json($result);
    }
}
