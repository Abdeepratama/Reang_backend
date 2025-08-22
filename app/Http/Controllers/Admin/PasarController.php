<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CRUDHelper;
use App\Models\Pasar;
use App\Models\InfoPasar;
use App\Models\Kategori;
use App\Models\Aktivitas;
use App\Models\NotifikasiAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PasarController extends Controller
{
    use CRUDHelper;

    public function __construct()
    {
        $this->model = Pasar::class;
        $this->routePrefix = 'pasar';
        $this->viewPrefix = 'pasar.tempat';
        $this->aktivitasTipe = 'Lokasi pasar';
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

        $this->logAktivitas("Lokasi Pasar telah ditambahkan");
        $this->logNotifikasi("Lokasi Pasar telah ditambahkan");

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
            $path = $request->file('foto')->store('Pasar_foto', 'public');
            $Pasar->foto = $path;
        }

        $Pasar->save();

        $this->logAktivitas("Lokasi Pasar telah diupdate");
        $this->logNotifikasi("Lokasi Pasar telah diupdate");

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
    
    public function info()
    {
        $infoItems = InfoPasar::with('kategori')->get();
        return view('admin.pasar.info.index', compact('infoItems'));
    }

    public function createInfo()
    {
        $kategoriPasar = Kategori::where('fitur', 'pasar')
            ->orderBy('nama')
            ->get();

        $lokasi = InfoPasar::all();

        return view('admin.pasar.info.create', [
            'kategoriPasar' => $kategoriPasar,
            'lokasi' => $lokasi,
        ]);
    }

    public function storeInfo(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'fitur' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fotoName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('foto_pasar', $fotoName, 'public');
        }

        InfoPasar::create([
            'foto' => $path,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'fitur' => $request->fitur,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        $this->logAktivitas("Info Pasar telah ditambahkan");
        $this->logNotifikasi("Info Pasar telah ditambahkan");

        return redirect()->route('admin.pasar.info.index')->with('success', 'Info pasar berhasil disimpan.');
    }

    public function infoEdit($id)
    {
        $info = InfoPasar::findOrFail($id);
        $kategoriPasar = Kategori::where('fitur', 'pasar')->orderBy('nama')->get();
        return view('admin.pasar.info.edit', compact('info', 'kategoriPasar'));
    }

    public function infoUpdate(Request $request, $id)
    {
        $item = InfoPasar::findOrFail($id);

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'fitur' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($request->hasFile('foto')) {
            if ($item->foto) {
                Storage::disk('public')->delete($item->foto);
            }
            $data['foto'] = $request->file('foto')->store('foto_pasar', 'public');
        }

        $item->update($data);

        $this->logAktivitas("Info Pasar telah diupdate");
        $this->logNotifikasi("Info Pasar telah diupdate");

        return redirect()->route('admin.pasar.info.index')->with('success', 'Info pasar berhasil diperbarui.');
    }

    public function infoDestroy($id)
    {
        $item = InfoPasar::findOrFail($id);
        if ($item->foto) Storage::disk('public')->delete($item->foto);
        $item->delete();

        $this->logAktivitas("Info Pasar telah dihapus");
        $this->logNotifikasi("Info Pasar telah dihapus");

        return back()->with('success', 'Info pasar berhasil dihapus.');
    }

    public function infomap()
    {
        $lokasi = InfoPasar::all()->map(function ($loc) {
            return [
                'nama' => $loc->nama,
                'alamat' => $loc->alamat,
                'latitude' => $loc->latitude,
                'longitude' => $loc->longitude,
                'foto' => $loc->foto ? asset('storage/' . $loc->foto) : null,
                'fitur' => $loc->fitur,
            ];
        });

        return view('admin.pasar.info.map', compact('lokasi'));
    }

    protected function logAktivitas($pesan)
    {
        if (auth()->check()) {
            Aktivitas::create([
                'user_id' => auth()->id(),
                'tipe' => $this->aktivitasTipe,
                'keterangan' => $pesan,
            ]);
        }
    }

    protected function logNotifikasi($pesan)
    {
        NotifikasiAktivitas::create([
            'keterangan' => $pesan,
            'dibaca' => false,
            'url' => route('admin.ibadah.tempat.index') // route yang valid
        ]);
    }
}
