<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PanikButton;
use Illuminate\Http\Request;

class PanikButtonController extends Controller
{
    public function index()
    {
        $panikButtons = PanikButton::all();
        return view('admin.panik.index', compact('panikButtons'));
    }

    public function create()
    {
        return view('admin.panik.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nomer' => 'required|string|max:20',
        ]);

        PanikButton::create($request->only(['name', 'nomer']));

        return redirect()->route('admin.panik.index')
            ->with('success', 'Data Panik Button berhasil ditambahkan.');
    }

    public function edit(PanikButton $panik)
    {
        return view('admin.panik.edit', compact('panik'));
    }

    public function update(Request $request, PanikButton $panik)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nomer' => 'required|string|max:20',
        ]);

        $panik->update($request->only(['name', 'nomer']));

        return redirect()->route('admin.panik.index')
            ->with('success', 'Data Panik Button berhasil diperbarui.');
    }

    public function destroy(PanikButton $panik)
    {
        $panik->delete();

        return redirect()->route('admin.panik.index')
            ->with('success', 'Data Panik Button berhasil dihapus.');
    }

    // ========== API SECTION ==========
    // GET /api/panik
    public function apiIndex()
    {
        $panikButtons = PanikButton::orderBy('id', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Panik Button',
            'data' => $panikButtons
        ]);
    }

    // GET /api/panik/{id}
    public function apiShow($id)
    {
        $panik = PanikButton::find($id);

        if (!$panik) {
            return response()->json([
                'success' => false,
                'message' => 'Data Panik Button tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Panik Button',
            'data' => $panik
        ]);
    }
}
