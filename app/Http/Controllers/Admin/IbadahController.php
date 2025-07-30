<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CRUDHelper;
use App\Models\Ibadah;
use App\Models\Kategori;
use App\Models\InfoKeagamaan;
use App\Models\Aktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function info()
    {
        $infoItems = InfoKeagamaan::all(); // gunakan model yang benar
        return view('admin.ibadah.info.index', compact('infoItems'));
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
    $data = $request->validate([
        'judul' => 'required',
        'deskripsi' => 'required',
        'foto' => 'nullable|image|max:2048',
    ]);

    // Simpan info keagamaan
    if ($request->hasFile('foto')) {
        $data['foto'] = $request->file('foto')->store('foto_ibadah', 'public');
    }

    $info = InfoKeagamaan::create($data);

    // Tambah notifikasi
    Aktivitas::create([
        'keterangan' => 'Info Keagamaan baru ditambahkan: ' . $info->judul,
        'tipe' => 'info_keagamaan',
        'url' => route('admin.info.show', $info->id),
        'item_id' => $info->id,
        'dibaca' => false,
    ]);

    return redirect()->route('admin.info.index')->with('success', 'Info Keagamaan berhasil ditambahkan.');
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

    public function infoIndex()
    {
        $infoItems = InfoKeagamaan::all();
        return view('admin.ibadah.info.index', compact('infoItems')); // ganti jadi infoItems
    }

    public function createInfo()
    {
        $kategoriIbadah = Kategori::all();

        return view('admin.ibadah.info.create', compact('kategoriIbadah'));
    }

    public function storeInfo(Request $request)
{
    $request->validate([
        'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'judul' => 'required|string|max:255',
        'tanggal' => 'required|date',
        'waktu' => 'required',
        'deskripsi' => 'required|string',
        'lokasi' => 'required|string',
        'alamat' => 'required|string',
        'fitur' => 'required|string',
    ]);

    // Upload foto ke disk publik di folder 'foto_ibadah'
    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $fotoName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('foto_ibadah', $fotoName, 'public'); // disimpan di storage/app/public/foto_ibadah
    }

    // Simpan ke database (pakai $path agar asset() bisa memuat)
    InfoKeagamaan::create([
        'foto' => $path, // Simpan path lengkap relatif ke storage/app/public
        'judul' => $request->judul,
        'tanggal' => $request->tanggal,
        'waktu' => $request->waktu,
        'deskripsi' => $request->deskripsi,
        'lokasi' => $request->lokasi,
        'alamat' => $request->alamat,
        'fitur' => $request->fitur,
    ]);

    return redirect()->route('admin.ibadah.info.index')->with('success', 'Info keagamaan berhasil disimpan.');
}

    public function infoEdit($id)
{
    $info = InfoKeagamaan::findOrFail($id);
    $kategoriIbadah = Kategori::all();
    return view('admin.ibadah.info.edit', compact('info', 'kategoriIbadah'));
}

    public function infoUpdate(Request $request, $id)
{
    $item = InfoKeagamaan::findOrFail($id);

    $data = $request->validate([
        'judul' => 'required',
        'tanggal' => 'required|date',
        'waktu' => 'required',
        'deskripsi' => 'required',
        'lokasi' => 'required',
        'alamat' => 'required',
        'fitur' => 'required',
        'foto' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('foto')) {
        // Hapus foto lama jika ada
        if ($item->foto) {
            Storage::disk('public')->delete($item->foto);
        }

        // Upload dan simpan path baru
        $data['foto'] = $request->file('foto')->store('foto_ibadah', 'public');
    }

    $item->update($data);

    return redirect()->route('admin.ibadah.info.index')->with('success', 'Info Keagamaan berhasil diperbarui');
}

    public function infoDestroy($id)
    {
        $item = InfoKeagamaan::findOrFail($id);
        if ($item->foto) Storage::disk('public')->delete($item->foto);
        $item->delete();

        return back()->with('success', 'Info Keagamaan berhasil dihapus');
    }
}
