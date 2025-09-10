<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Renbang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RenbangController extends Controller
{
    /**
     * INDEX DESKRIPSI
     */
    public function deskripsiIndex()
    {
        $items = Renbang::latest()->get();
        return view('admin.renbang.deskripsi.index', compact('items'));
    }

    /**
     * CREATE FORM
     */
    public function deskripsiCreate()
    {
        return view('admin.renbang.deskripsi.create');
    }

    /**
     * STORE DATA
     */
    public function deskripsiStore(Request $request)
    {
        $validated = $request->validate([
            'judul'    => 'required|string|max:255',
            'isi'      => 'required|string',
            'kategori' => 'required|in:Infrastruktur,Pendidikan,Kesehatan,Ekonomi',
            'gambar'   => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('renbang', 'public');
        }

        Renbang::create($validated);

        return redirect()->route('admin.renbang.deskripsi.index')
            ->with('success', 'Deskripsi Renbang berhasil ditambahkan.');
    }

    /**
     * EDIT FORM
     */
    public function deskripsiEdit($id)
    {
        $item = Renbang::findOrFail($id);
        return view('admin.renbang.deskripsi.edit', compact('item'));
    }

    /**
     * UPDATE DATA
     */
    public function deskripsiUpdate(Request $request, $id)
    {
        $item = Renbang::findOrFail($id);

        $validated = $request->validate([
            'judul'    => 'required|string|max:255',
            'isi'      => 'required|string',
            'kategori' => 'required|in:Infrastruktur,Pendidikan,Kesehatan,Ekonomi',
            'gambar'   => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // hapus gambar lama
            if ($item->gambar && Storage::disk('public')->exists($item->gambar)) {
                Storage::disk('public')->delete($item->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('renbang', 'public');
        }

        $item->update($validated);

        return redirect()->route('admin.renbang.deskripsi.index')
            ->with('success', 'Deskripsi Renbang berhasil diperbarui.');
    }

    /**
     * DELETE DATA
     */
    public function deskripsiDestroy($id)
    {
        $item = Renbang::findOrFail($id);

        // hapus file gambar jika ada
        if ($item->gambar && Storage::disk('public')->exists($item->gambar)) {
            Storage::disk('public')->delete($item->gambar);
        }

        $item->delete();

        return redirect()->route('admin.renbang.deskripsi.index')
            ->with('success', 'Deskripsi Renbang berhasil dihapus.');
    }
}
