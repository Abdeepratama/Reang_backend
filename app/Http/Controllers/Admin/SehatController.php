<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CRUDHelper;
use App\Models\Sehat;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SehatController extends Controller
{
    use CRUDHelper;

    public function __construct()
    {
        $this->model = Sehat::class;
        $this->routePrefix = 'sehat';
        $this->viewPrefix = 'sehat';
        $this->aktivitasTipe = 'Sehat';
        $this->aktivitasCreateMessage = 'Lokasi Sehat baru ditambahkan';
        $this->validationRules = [
            'name' => 'required|string',
            'address' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'fitur' => 'required|string',
        ];
    }

    public function create()
    {
        $kategoriSehat = Kategori::where('fitur', 'Sehat')->orderBy('nama')->get();
        $lokasi = Sehat::all(); // untuk peta

        return view('admin.sehat.tempat.create', compact('kategoriSehat', 'lokasi'));
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
            $path = $request->file('foto')->store('Sehat_foto', 'public');
            $validated['foto'] = $path;
        }

        Sehat::create($validated);

        return redirect()->route('admin.sehat.tempat.index')
            ->with('success', 'Tempat sehat berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $item = Sehat::findOrFail($id);
        $kategoriSehat = Kategori::where('fitur', 'Sehat')->get();

        return view('admin.sehat.tempat.edit', [
            'item' => $item,
            'kategoriSehat' => $kategoriSehat,
            'lokasi' => [],
        ]);
    }

    public function update(Request $request, $id)
    {
        $sehat = Sehat::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'fitur' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        $sehat->name = $validated['name'];
        $sehat->address = $validated['address'];
        $sehat->latitude = $validated['latitude'];
        $sehat->longitude = $validated['longitude'];
        $sehat->fitur = $validated['fitur'];

        if ($request->hasFile('foto')) {
            if ($sehat->foto && Storage::disk('public')->exists($sehat->foto)) {
                Storage::disk('public')->delete($sehat->foto);
            }
            $path = $request->file('foto')->store('tempat_Sehat_foto', 'public');
            $sehat->foto = $path;
        }

        $sehat->save();

        return redirect()->route('admin.sehat.tempat.index')
            ->with('success', 'Lokasi berhasil diperbarui!');
    }

    public function map()
    {
        $lokasi = Sehat::all()->map(function ($loc) {
            return [
                'name' => $loc->name,
                'address' => $loc->address,
                'latitude' => $loc->latitude,
                'longitude' => $loc->longitude,
                'foto' => $loc->foto ? asset('storage/' . $loc->foto) : null,
            ];
        });

        return view('admin.sehat.tempat.map', compact('lokasi'));
    }

    public function simpanLokasi(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $sehat = new Sehat();
        $sehat->name = 'Nama Tempat'; 
        $sehat->latitude = $request->latitude;
        $sehat->longitude = $request->longitude;
        $sehat->save();

        return redirect()->back()->with('success', 'Lokasi berhasil disimpan.');
    }

    public function tempat()
    {
        $items = Sehat::all();
        return view('admin.sehat.tempat.index', compact('items'));
    }
}
