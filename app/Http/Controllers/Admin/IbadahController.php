<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CRUDHelper;
use App\Models\Ibadah;
use App\Models\Kategori;
use Illuminate\Http\Request;

class IbadahController extends Controller
{
    use CRUDHelper;

    public function __construct()
    {
        $this->model = Ibadah::class;
        $this->routePrefix = 'ibadah';
        $this->viewPrefix = 'ibadah';
        $this->viewSubfolder = 'tempat';
        $this->aktivitasTipe = 'Ibadah';
        $this->aktivitasCreateMessage = 'Tempat ibadah baru ditambahkan';
        $this->validationRules = [
            'name' => 'required|string',
            'address' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'fitur' => 'required|exists:kategoris,id',
        ];
    }

    public function index()
    {
        $items = Ibadah::all();
        return view('admin.ibadah.index', compact('items'));
    }

    public function tempat()
    {
        $items = Ibadah::all();
        return view('admin.ibadah.tempat.index', compact('items'));
    }

    public function map()
    {
        $lokasi = Ibadah::all(); // ini ambil semua data dari tabel tempat_ibadah
        return view('admin.ibadah.tempat.map', compact('lokasi'));
    }

    public function simpanLokasi(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Simpan ke database, misalnya ke model Ibadah
        $ibadah = new Ibadah();
        $ibadah->name = 'Nama Tempat'; // isi sesuai inputan form
        $ibadah->latitude = $request->latitude;
        $ibadah->longitude = $request->longitude;
        $ibadah->save();

        return redirect()->back()->with('success', 'Lokasi berhasil disimpan.');
    }


    public function create()
    {
        $kategoriIbadah = Kategori::where('fitur', 'ibadah')->orderBy('nama')->get();
        $lokasi = Ibadah::all(); // Ambil semua lokasi

        return view('admin.ibadah.tempat.create', compact('kategoriIbadah', 'lokasi'));
    }

    public function createTempat(Request $request)
    {
        // Ambil data dari query string
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $address = $request->address;

        return view('admin.ibadah.tempat.create', compact('latitude', 'longitude', 'address'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'required|string',
            'fitur' => 'required|string|max:255', // Langsung string, bukan foreign key
        ]);

        $ibadah = new Ibadah();
        $ibadah->name = $request->name;
        $ibadah->latitude = $request->latitude;
        $ibadah->longitude = $request->longitude;
        $ibadah->address = $request->address;
        $ibadah->fitur = $request->fitur; // Langsung dari input
        $ibadah->save();

        return redirect()->route('admin.ibadah.tempat.index')->with('success', 'Tempat ibadah berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = Ibadah::findOrFail($id);
        $kategoriIbadah = Kategori::where('fitur', 'ibadah')->orderBy('nama')->get();
        $lokasi = Ibadah::all(); // <-- tambahkan ini

        return view('admin.ibadah.tempat.edit', compact('item', 'kategoriIbadah', 'lokasi'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'fitur' => 'required|string'
        ]);

        $item = Ibadah::findOrFail($id);
        $item->update([
            'name' => $request->name,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'fitur' => $request->fitur
        ]);

        return redirect()->route('admin.ibadah.tempat.index')->with('success', 'Lokasi berhasil diperbarui.');
    }
}
