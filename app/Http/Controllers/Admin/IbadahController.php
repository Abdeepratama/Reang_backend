<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CRUDHelper;
use App\Models\Ibadah;
use App\Models\Kategori;
use App\Models\InfoKeagamaan;
use App\Models\Aktivitas;
use App\Models\NotifikasiAktivitas;
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
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ];
    }

    public function index()
    {
        $items = Ibadah::all();
        return view('admin.ibadah.index', compact('items'));
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
            $path = $request->file('foto')->store('ibadah_foto', 'public');
            $validated['foto'] = $path;
        }

        Ibadah::create($validated);

        $this->logAktivitas("Tempat ibadah telah ditambahkan");
        $this->logNotifikasi("Tempat Ibadah telah ditambahkan.");

        return redirect()->route('admin.ibadah.tempat.index',)
            ->with('success', 'Tempat ibadah berhasil ditambahkan!');
    }

    public function editTempat(Request $request, $id)
{
    $ibadah = Ibadah::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'fitur' => 'required|string',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
    ]);

    $ibadah->update($validated);

    // Catat aktivitas dan notifikasi **setelah update berhasil**
    $this->logAktivitas("Tempat ibadah telah diperbarui: " );
    $this->logNotifikasi("Tempat Ibadah telah diperbarui: " );

    return redirect()->route('admin.ibadah.tempat.index')
                     ->with('success', 'Tempat ibadah berhasil diperbarui!');
}

    public function tempat()
    {
        $items = Ibadah::all();
        return view('admin.ibadah.tempat.index', compact('items'));
    }

    public function map()
    {
        $lokasi = Ibadah::all()->map(function ($loc) {
            return [
                'name' => $loc->name,
                'address' => $loc->address,
                'latitude' => $loc->latitude,
                'longitude' => $loc->longitude,
                'fitur'     => $loc->fitur,
                'foto' => $loc->foto ? asset('storage/' . $loc->foto) : null,
            ];
        });

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

    public function edit($id)
    {
        $item = Ibadah::findOrFail($id);
        $kategoriIbadah = Kategori::where('fitur', 'ibadah')->orderBy('nama')->get();
        $lokasi = Ibadah::all(); // <-- tambahkan ini

        return view('admin.ibadah.tempat.edit', compact('item', 'kategoriIbadah', 'lokasi'));
    }


    public function update(Request $request, $id)
    {
        $ibadah = Ibadah::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'fitur' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        // Update field dasar
        $ibadah->name = $validated['name'];
        $ibadah->address = $validated['address'];
        $ibadah->latitude = $validated['latitude'];
        $ibadah->longitude = $validated['longitude'];
        $ibadah->fitur = $validated['fitur'];

        // Jika ada file foto baru, ganti
        if ($request->hasFile('foto')) {
            // hapus foto lama kalau ada
            if ($ibadah->foto && Storage::disk('public')->exists($ibadah->foto)) {
                Storage::disk('public')->delete($ibadah->foto);
            }
            $path = $request->file('foto')->store('ibadah_foto', 'public');
            $ibadah->foto = $path;
        }

        $ibadah->save();

        return redirect()->route('admin.ibadah.tempat.index')
            ->with('success', 'Lokasi berhasil diperbarui!');
    }

    public function infoIndex()
    {
        $infoItems = InfoKeagamaan::all(); // gunakan model yang benar
        return view('admin.ibadah.info.index', compact('infoItems'));
    }

    public function createInfo()
    {
        $kategoriIbadah = Kategori::where('fitur', 'ibadah')->get();

        $lokasi = InfoKeagamaan::all()->map(function ($loc) {
            return [
                'name' => $loc->judul,
                'address' => $loc->alamat,
                'latitude' => $loc->latitude,
                'longitude' => $loc->longitude,
                'foto' => $loc->foto ? asset('storage/' . $loc->foto) : null,
                'fitur' => $loc->fitur,
            ];
        });

        return view('admin.ibadah.info.create', compact('kategoriIbadah', 'lokasi'));
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
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
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
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        $this->logAktivitas('InfoKeagamaan', 'Info keagamaan baru ditambahkan ', 'create');

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
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
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

        $this->logAktivitas('InfoKeagamaan', 'Info keagamaan diperbarui ', 'update', $item->id);

        return redirect()->route('admin.ibadah.info.index')->with('success', 'Info Keagamaan berhasil diperbarui');
    }

    public function infoDestroy($id)
    {
        $item = InfoKeagamaan::findOrFail($id);
        if ($item->foto) Storage::disk('public')->delete($item->foto);
        $item->delete();

        $this->logAktivitas('InfoKeagamaan', 'Info keagamaan dihapus ', 'delete', $item->id);

        return back()->with('success', 'Info Keagamaan berhasil dihapus');
    }

    public function infomap()
    {
        $lokasi = InfoKeagamaan::all()->map(function ($loc) {
            return [
                'judul' => $loc->judul,          // ganti 'name' jadi 'judul'
                'alamat' => $loc->alamat,      // ganti 'address' jadi 'alamat'
                'latitude' => $loc->latitude,
                'longitude' => $loc->longitude,
                'foto' => $loc->foto ? asset('storage/' . $loc->foto) : null,
                'fitur' => $loc->fitur,         // kalau mau tampilkan kategori/fitur
                'rating' => $loc->rating,       // rating juga bisa ditambahkan
            ];
        });

        return view('admin.ibadah.info.map', compact('lokasi'));
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
