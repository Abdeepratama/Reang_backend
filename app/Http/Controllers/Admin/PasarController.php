<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CRUDHelper;
use App\Models\Pasar;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PasarController extends Controller
{
    use CRUDHelper;

    public function __construct()
    {
        $this->model = Pasar::class;
        $this->routePrefix = 'pasar';
        $this->viewPrefix = 'pasar';
        $this->aktivitasTipe = 'Pasar';
        $this->aktivitasCreateMessage = 'Lokasi Pasar baru ditambahkan';
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
        $kategoriPasar = Kategori::where('fitur', 'Pasar')->orderBy('nama')->get();
        $lokasi = Pasar::all(); // untuk peta

        return view('admin.pasar.tempat.create', compact('kategoriPasar', 'lokasi'));
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
            $path = $request->file('foto')->store('Pasar_foto', 'public');
            $validated['foto'] = $path;
        }

        Pasar::create($validated);

        return redirect()->route('admin.pasar.tempat.index',)
            ->with('success', 'Tempat pasar berhasil ditambahkan!');
    }

    public function edit($id)
{
    $item = Pasar::findOrFail($id);
    $kategoriPasar = Kategori::where('fitur', 'Pasar')->get(); // ambil khusus kategori untuk fitur 'Pasar'

    return view('admin.pasar.tempat.edit', [
        'item' => $item,
        'kategoriPasar' => $kategoriPasar,
        'lokasi' => [],
    ]);
}

    public function update(Request $request, $id)
    {
        $Pasar = Pasar::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'fitur' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        // Update field dasar
        $Pasar->name = $validated['name'];
        $Pasar->address = $validated['address'];
        $Pasar->latitude = $validated['latitude'];
        $Pasar->longitude = $validated['longitude'];
        $Pasar->fitur = $validated['fitur'];

        // Jika ada file foto baru, ganti
        if ($request->hasFile('foto')) {
            // hapus foto lama kalau ada
            if ($Pasar->foto && Storage::disk('public')->exists($Pasar->foto)) {
                Storage::disk('public')->delete($Pasar->foto);
            }
            $path = $request->file('foto')->store('tempat_Pasar_foto', 'public');
            $Pasar->foto = $path;
        }

        $Pasar->save();

        return redirect()->route('admin.pasar.tempat.index')
            ->with('success', 'Lokasi berhasil diperbarui!');
    }

    public function map()
    {
        $lokasi = Pasar::all()->map(function ($loc) {
            return [
                'name' => $loc->name,
                'address' => $loc->address,
                'latitude' => $loc->latitude,
                'longitude' => $loc->longitude,
                'fitur'     => $loc->fitur,
                'foto' => $loc->foto ? asset('storage/' . $loc->foto) : null,
            ];
        });

        return view('admin.pasar.tempat.map', compact('lokasi'));
    }

    public function simpanLokasi(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Simpan ke database, misalnya ke model Pasar
        $pasar = new Pasar();
        $pasar->name = 'Nama Tempat'; // isi sesuai inputan form
        $pasar->latitude = $request->latitude;
        $pasar->longitude = $request->longitude;
        $pasar->save();

        return redirect()->back()->with('success', 'Lokasi berhasil disimpan.');
    }

    public function tempat()
    {
        $items = Pasar::all();
        return view('admin.pasar.tempat.index', compact('items'));
    }
}
