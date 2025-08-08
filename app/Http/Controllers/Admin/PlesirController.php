<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CRUDHelper;
use App\Models\Plesir;
use App\Models\Kategori;
use App\Models\InfoPlesir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlesirController extends Controller
{
    use CRUDHelper;

    public function __construct()
    {
        $this->model = Plesir::class;
        $this->routePrefix = 'plesir';
        $this->viewPrefix = 'plesir';
        $this->viewSubfolder = 'tempat';
        $this->aktivitasTipe = 'Plesir';
        $this->aktivitasCreateMessage = 'Tempat plesir baru ditambahkan';
        $this->validationRules = [
            'name' => 'required|string',
            'address' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'fitur' => 'required|exists:kategoris,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ];
    }

    public function create()
    {
        $kategoriPlesir = Kategori::where('fitur', 'plesir')->orderBy('nama')->get();
        $lokasi = Plesir::all(); // untuk peta

        return view('admin.plesir.tempat.create', compact('kategoriPlesir', 'lokasi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'fitur' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        if (isset($validated['foto'])) {
            $path = $request->file('foto')->store('plesir_foto', 'public');
            $validated['foto'] = $path;
        }

        Plesir::create($validated);

        return redirect()->route('admin.plesir.tempat.index',)
            ->with('success', 'Tempat plesir berhasil ditambahkan!');
    }

    public function edit($id)
{
    $item = Plesir::findOrFail($id);
    $kategoriPlesir = Kategori::where('fitur', 'plesir')->get(); // ambil khusus kategori untuk fitur 'plesir'

    return view('admin.Plesir.tempat.edit', [
        'item' => $item,
        'kategoriPlesir' => $kategoriPlesir,
        'lokasi' => [],
    ]);
}

    public function update(Request $request, $id)
    {
        $plesir = Plesir::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'fitur' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        // Update field dasar
        $plesir->name = $validated['name'];
        $plesir->address = $validated['address'];
        $plesir->latitude = $validated['latitude'];
        $plesir->longitude = $validated['longitude'];
        $plesir->fitur = $validated['fitur'];

        // Jika ada file foto baru, ganti
        if ($request->hasFile('foto')) {
            // hapus foto lama kalau ada
            if ($plesir->foto && Storage::disk('public')->exists($plesir->foto)) {
                Storage::disk('public')->delete($plesir->foto);
            }
            $path = $request->file('foto')->store('tempat_plesir_foto', 'public');
            $plesir->foto = $path;
        }

        $plesir->save();

        return redirect()->route('admin.plesir.tempat.index')
            ->with('success', 'Lokasi berhasil diperbarui!');
    }

    public function map()
    {
        $lokasi = Plesir::all()->map(function ($loc) {
            return [
                'name' => $loc->name,
                'address' => $loc->address,
                'latitude' => $loc->latitude,
                'longitude' => $loc->longitude,
                // pastikan sudah menjalankan `php artisan storage:link`
                'foto' => $loc->foto ? asset('storage/' . $loc->foto) : null,
            ];
        });

        return view('admin.plesir.tempat.map', compact('lokasi'));
    }

    public function simpanLokasi(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Simpan ke database, misalnya ke model plesir
        $plesir = new Plesir();
        $plesir->name = 'Nama Tempat'; // isi sesuai inputan form
        $plesir->latitude = $request->latitude;
        $plesir->longitude = $request->longitude;
        $plesir->save();

        return redirect()->back()->with('success', 'Lokasi berhasil disimpan.');
    }

    public function tempat()
    {
        $items = Plesir::all();
        return view('admin.plesir.tempat.index', compact('items'));
    }

    public function info()
{
    $infoItems = InfoPlesir::all();
    return view('admin.plesir.info.index', compact('infoItems'));
}

public function createInfo()
{
    $kategoriPlesir = Kategori::where('fitur', 'plesir')->orderBy('nama')->get();
    return view('admin.plesir.info.create', compact('kategoriPlesir'));
}

public function storeInfo(Request $request)
{
    $request->validate([
    'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    'judul' => 'required|string|max:255',
    'alamat' => 'required|string|max:255',
    'deskripsi' => 'required|string',
    'fitur' => 'required|string|max:255',
]);

    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $fotoName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('foto_plesir', $fotoName, 'public');
    }

    InfoPlesir::create([
        'foto' => $path,
        'judul' => $request->judul,
        'alamat' => $request->alamat,
        'rating' => $request->rating,
        'deskripsi' => $request->deskripsi,
        'fitur' => $request->fitur,
    ]);

    return redirect()->route('admin.plesir.info.index')->with('success', 'Info plesir berhasil disimpan.');
}

public function infoEdit($id)
{
    $info = InfoPlesir::findOrFail($id);
    $kategoriPlesir = Kategori::where('fitur', 'plesir')->orderBy('nama')->get();
    return view('admin.plesir.info.edit', compact('info', 'kategoriPlesir'));
}

public function infoUpdate(Request $request, $id)
{
    $item = InfoPlesir::findOrFail($id);

    $data = $request->validate([
    'judul' => 'required',
    'deskripsi' => 'required',
    'alamat' => 'required',
    'fitur' => 'required',
    'foto' => 'nullable|image|max:2048',
    'rating' => 'required|numeric|between:0,5',
]);

    if ($request->hasFile('foto')) {
        if ($item->foto) {
            Storage::disk('public')->delete($item->foto);
        }

        $data['foto'] = $request->file('foto')->store('foto_plesir', 'public');
    }

    $item->update($data);

    return redirect()->route('admin.plesir.info.index')->with('success', 'Info plesir berhasil diperbarui.');
}

public function infoDestroy($id)
{
    $item = InfoPlesir::findOrFail($id);
    if ($item->foto) Storage::disk('public')->delete($item->foto);
    $item->delete();

    return back()->with('success', 'Info plesir berhasil dihapus.');
}
}
