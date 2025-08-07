<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CRUDHelper;
use App\Models\Plesir;
use App\Models\Kategori;
use Illuminate\Http\Request;

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
        $kategoriPlesir = Plesir::all(); // ambil daftar kategori yang benar

        return view('admin.Plesir.tempat.edit', [
            'item' => $item,
            'kategoriPlesir' => $kategoriPlesir,
            'lokasi' => [], // kalau memang diperlukan di view
        ]);
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
}
