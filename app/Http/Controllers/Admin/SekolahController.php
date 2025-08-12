<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sekolah;
use App\Models\Kategori;
use App\Models\Tempat_sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SekolahController extends Controller
{
    /**
     * LIST TEMPAT SEKOLAH
     */
    public function indexTempat()
{
    $kategoriSekolah = Kategori::where('fitur', 'sekolah')->orderBy('nama')->get();
    $items = Tempat_sekolah::all(); // ini yang dikirim ke blade sebagai $items

    return view('admin.sekolah.tempat.index', compact('items', 'kategoriSekolah'));
}

    /**
     * FORM TAMBAH TEMPAT SEKOLAH
     */
    Public function createTempat()
{
    $kategoriSekolah = Kategori::where('fitur', 'sekolah')->orderBy('nama')->get();
     $lokasi = Tempat_sekolah::all(); // untuk peta

    return view('admin.sekolah.tempat.create', compact('kategoriSekolah', 'lokasi'));
}

    /**
     * SIMPAN TEMPAT SEKOLAH
     */
    Public function storeTempat(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string',
            'address'   => 'required|string',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto'      => 'nullable|image|max:2048',
            'fitur' => 'required|string',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('sekolah_foto', 'public');
        }

        Tempat_sekolah::create($validated);

        return redirect()->route('admin.sekolah.tempat.index')
            ->with('success', 'Tempat sekolah berhasil ditambahkan.');
    }

    /**
     * FORM EDIT TEMPAT SEKOLAH
     */
    Public function editTempat($id)
    {
        $item = Tempat_sekolah::findOrFail($id);
        $kategoriSekolah = Kategori::where('fitur', 'sekolah')->get();
        return view('admin.sekolah.tempat.edit', compact('item', 'kategoriSekolah'));
    }

    /**
     * UPDATE TEMPAT SEKOLAH
     */
    Public function updateTempat(Request $request, $id)
    {
        $sekolah = Tempat_sekolah::findOrFail($id);

        $validated = $request->validate([
            'name'      => 'required|string',
            'address'   => 'required|string',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto'      => 'nullable|image|max:2048',
            'fitur' => 'required|string',
        ]);

        if ($request->hasFile('foto')) {
            if ($sekolah->foto && Storage::disk('public')->exists($sekolah->foto)) {
                Storage::disk('public')->delete($sekolah->foto);
            }
            $validated['foto'] = $request->file('foto')->store('sekolah_foto', 'public');
        }

        $sekolah->update($validated);

        return redirect()->route('admin.sekolah.tempat.index')
            ->with('success', 'Tempat sekolah berhasil diperbarui.');
    }

    /**
     * MAP TEMPAT SEKOLAH
     */
    public function mapTempat()
{
    $lokasi = Tempat_sekolah::all()->map(function ($loc) {
        return [
            'name' => $loc->name,
            'address' => $loc->address,
            'latitude' => $loc->latitude,
            'longitude' => $loc->longitude,
            'foto' => $loc->foto ? asset('storage/' . $loc->foto) : null,
        ];
    });

    return view('admin.sekolah.tempat.map', compact('lokasi'));
}

    // ======================= ADUAN SEKOLAH =======================

    /**
     * LIST ADUAN SEKOLAH
     */
    Public function aduanindex()
    {
        $items = Sekolah::whereNotNull('jenis_laporan')->get();
        return view('admin.sekolah.aduan.index', compact('items'));
    }

    /**
     * FORM TAMBAH ADUAN SEKOLAH
     */
    public function createAduan()
    {
        $kategoriAduan = Kategori::where('fitur', 'aduan-sekolah')->orderBy('nama')->get();
        return view('admin.sekolah.aduan.create', compact('kategoriAduan'));
    }

    /**
     * SIMPAN ADUAN SEKOLAH
     */
    public function storeAduan(Request $request)
    {
        $validated = $request->validate([
            'jenis_laporan'  => 'required|string',
            'bukti_laporan'  => 'nullable|image|max:2048',
            'lokasi_laporan' => 'required|string',
            'kategori_laporan' => 'required|string',
            'deskripsi'      => 'required|string',
            'pernyataan'     => 'required|boolean',
        ]);

        if ($request->hasFile('bukti_laporan')) {
            $validated['bukti_laporan'] = $request->file('bukti_laporan')->store('aduan_sekolah', 'public');
        }

        Sekolah::create($validated);

        return redirect()->route('admin.sekolah.aduan.index')
            ->with('success', 'Aduan sekolah berhasil ditambahkan.');
    }

    /**
     * FORM EDIT ADUAN SEKOLAH
     */
    public function editAduan($id)
    {
        $item = Sekolah::findOrFail($id);
        $kategoriAduan = Kategori::where('fitur', 'aduan-sekolah')->get();
        return view('admin.sekolah.aduan.edit', compact('item', 'kategoriAduan'));
    }

    /**
     * UPDATE ADUAN SEKOLAH
     */
    public function updateAduan(Request $request, $id)
    {
        $aduan = Sekolah::findOrFail($id);

        $validated = $request->validate([
            'jenis_laporan'  => 'required|string',
            'bukti_laporan'  => 'nullable|image|max:2048',
            'lokasi_laporan' => 'required|string',
            'kategori_laporan' => 'required|string',
            'deskripsi'      => 'required|string',
            'pernyataan'     => 'required|boolean',
        ]);

        if ($request->hasFile('bukti_laporan')) {
            if ($aduan->bukti_laporan && Storage::disk('public')->exists($aduan->bukti_laporan)) {
                Storage::disk('public')->delete($aduan->bukti_laporan);
            }
            $validated['bukti_laporan'] = $request->file('bukti_laporan')->store('aduan_sekolah', 'public');
        }

        $aduan->update($validated);

        return redirect()->route('admin.sekolah.aduan.index')
            ->with('success', 'Aduan sekolah berhasil diperbarui.');
    }

    public function tempatDestroy($id)
{
    $item = Sekolah::whereNull('jenis_laporan')->findOrFail($id);

    if ($item->foto && Storage::disk('public')->exists($item->foto)) {
        Storage::disk('public')->delete($item->foto);
    }

    $item->delete();

    return redirect()->route('admin.sekolah.tempat.index')
        ->with('success', 'Tempat sekolah berhasil dihapus.');
}

public function aduanDestroy($id)
{
    $item = Sekolah::whereNotNull('jenis_laporan')->findOrFail($id);

    if ($item->foto && Storage::disk('public')->exists($item->foto)) {
        Storage::disk('public')->delete($item->foto);
    }

    $item->delete();

    return redirect()->route('admin.sekolah.aduan.index')
        ->with('success', 'Aduan sekolah berhasil dihapus.');
}

}
