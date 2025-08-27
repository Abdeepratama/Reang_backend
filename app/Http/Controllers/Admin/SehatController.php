<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CRUDHelper;
use App\Models\Sehat;
use App\Models\InfoKesehatan;
use App\Models\Tempat_olahraga;
use App\Models\Kategori;
use App\Models\Aktivitas;
use App\Models\NotifikasiAktivitas;
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
        $this->viewSubfolder = 'tempat';
        $this->aktivitasTipe = 'Lokasi Kesehatan';
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
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120'
        ]);

        if (isset($validated['foto'])) {
            $path = $request->file('foto')->store('Sehat_foto', 'public');
            $validated['foto'] = $path;
        }

        Sehat::create($validated);

        $this->logAktivitas("Lokasi Kesehatan telah ditambahkan");
        $this->logNotifikasi("Lokasi Kesehatan telah ditambahkan");

        return redirect()->route('admin.sehat.tempat.index')
            ->with('success', 'Lokasi Kesehatan berhasil ditambahkan!');
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
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120'
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

        $this->logAktivitas("Lokasi Kesehatan telah diupdate");
        $this->logNotifikasi("Lokasi Kesehatan telah diupdate");

        return redirect()->route('admin.sehat.tempat.index')
            ->with('success', 'Lokasi Kesehatan berhasil diupdate!');
    }

    public function destroy($id)
    {
        $sehat = Sehat::findOrFail($id);

        // Hapus foto kalau ada
        if ($sehat->foto && Storage::disk('public')->exists($sehat->foto)) {
            Storage::disk('public')->delete($sehat->foto);
        }

        $sehat->delete();

        $this->logAktivitas("Lokasi Kesehatan telah dihapus");
        $this->logNotifikasi("Lokasi Kesehatan telah dihapus");

        return redirect()->route('admin.sehat.tempat.index')
            ->with('success', 'Lokasi Kesehatan berhasil dihapus!');
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

    public function infoindex()
    {
        $infoItems = InfoKesehatan::with('kategori')->get();
        return view('admin.sehat.info.index', compact('infoItems'));
    }

    public function infocreate()
    {
        $kategoriKesehatan = Kategori::where('fitur', 'Kesehatan')
            ->orderBy('nama')
            ->get();

        $lokasi = InfoKesehatan::all();

        return view('admin.sehat.info.create', [
            'kategoriKesehatan' => $kategoriKesehatan,
        ]);
    }

    public function infostore(Request $request)
    {
        $data = $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'fitur' => 'required|string|max:255',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_kesehatan', 'public');
        }

        InfoKesehatan::create($data);

        $this->logAktivitas("Info Kesehatan telah ditambahkan");
        $this->logNotifikasi("Info Kesehatan telah ditambahkan");

        return redirect()->route('admin.sehat.info.index')->with('success', 'Info kesehatan berhasil ditambahkan.');
    }

    public function infoedit($id)
    {
        $info = InfoKesehatan::findOrFail($id);
        $kategoriKesehatan = Kategori::where('fitur', 'Kesehatan')->get();

        return view('admin.sehat.info.edit', [
            'info' => $info,
            'kategoriKesehatan' => $kategoriKesehatan,
        ]);
    }

    public function infoupdate(Request $request, $id)
    {
        $info = InfoKesehatan::findOrFail($id);

        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'fitur' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            if ($info->foto) {
                Storage::disk('public')->delete($info->foto);
            }
            $data['foto'] = $request->file('foto')->store('foto_kesehatan', 'public');
        }

        $info->update($data);

        $this->logAktivitas("Info Kesehatan telah diupdate");
        $this->logNotifikasi("Info Kesehatan telah diupdate");

        return redirect()->route('admin.sehat.info.index')->with('success', 'Info kesehatan berhasil diperbarui.');
    }

    public function infodestroy($id)
    {
        $info = InfoKesehatan::findOrFail($id);

        if ($info->foto) {
            Storage::disk('public')->delete($info->foto);
        }

        $info->delete();

        $this->logAktivitas("Lokasi Kesehatan telah dihapus");
        $this->logNotifikasi("Lokasi Kesehatan telah dihapus");

        return back()->with('success', 'Info kesehatan berhasil dihapus.');
    }

    public function show($id = null)
    {
        if ($id) {
            $data = Sehat::find($id);
            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
            return response()->json($data, 200);
        } else {
            $data = Sehat::all();
            return response()->json($data, 200);
        }
    }

    public function infoshow($id = null)
    {
        if ($id) {
            $data = InfoKesehatan::with('kategori')->find($id);
            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $result = $data->toArray();
            $result['foto'] = $data->foto ? asset('storage/' . $data->foto) : null;

            return response()->json($result, 200);
        } else {
            $data = InfoKesehatan::with('kategori')->get()->map(function ($item) {
                $arr = $item->toArray();
                $arr['foto'] = $item->foto ? asset('storage/' . $item->foto) : null;
                return $arr;
            });

            return response()->json($data, 200);
        }
    }

    public function showolahraga($id = null)
    {
        if ($id) {
            $data = Tempat_olahraga::find($id);
            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $result = [
                'id'        => $data->id,
                'name'      => $data->name,
                'address'   => $data->address,
                'latitude'  => $data->latitude,
                'longitude' => $data->longitude,
            ];

            return response()->json($result, 200);
        } else {
            $data = Tempat_olahraga::all()->map(function ($item) {
                return [
                    'id'        => $item->id,
                    'name'      => $item->name,
                    'address'   => $item->address,
                    'latitude'  => $item->latitude,
                    'longitude' => $item->longitude,
                ];
            });

            return response()->json($data, 200);
        }
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . $file->getClientOriginalName();

            // simpan ke storage/app/public/uploads
            $file->storeAs('uploads', $filename, 'public');

            $url = asset('storage/uploads/' . $filename);

            // CKEditor 5 format
            return response()->json([
                'uploaded' => true,
                'url' => $url
            ]);
        }

        return response()->json([
            'uploaded' => false,
            'error' => [
                'message' => 'No file uploaded'
            ]
        ], 400);
    }

    //Tempat olahraga
    public function indexolahraga()
    {
        $items = Tempat_olahraga::all();
        return view('admin.sehat.olahraga.index', compact('items'));
    }

    public function createolahraga()
    {
        $lokasi = Tempat_olahraga::all(); // untuk peta

        return view('admin.sehat.olahraga.create', compact('lokasi'));
    }

    public function storeolahraga(Request $request)
{
    $validated = $request->validate([
        'name'      => 'required|string|max:255',
        'address'   => 'required|string',
        'latitude'  => 'required|numeric',
        'longitude' => 'required|numeric',
        'foto'      => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
    ]);

    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $fotoName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('tempat_olahraga', $fotoName, 'public');
        $validated['foto'] = $path; // 🔥 masukin foto ke array validated
    }

    Tempat_olahraga::create($validated);

    $this->logAktivitas("Tempat olahraga telah ditambahkan");
    $this->logNotifikasi("Tempat olahraga telah ditambahkan");

    return redirect()->route('admin.sehat.olahraga.index')
        ->with('success', 'Tempat olahraga berhasil ditambahkan!');
}

    public function editolahraga($id)
    {
        $item = Tempat_olahraga::findOrFail($id);

        return view('admin.sehat.olahraga.edit', [
            'olahraga' => $item,
            'lokasi' => [],
        ]);
    }

    public function updateolahraga(Request $request, $id)
{
    $olahraga = Tempat_olahraga::findOrFail($id);

    $validated = $request->validate([
        'name'      => 'required|string|max:255',
        'address'   => 'required|string',
        'latitude'  => 'required|numeric',
        'longitude' => 'required|numeric',
        'foto'      => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
    ]);

    // simpan data dulu
    $data = $validated;

    // cek apakah ada upload file baru
    if ($request->hasFile('foto')) {
        // hapus foto lama
        if ($olahraga->foto) {
            Storage::disk('public')->delete($olahraga->foto);
        }
        // upload baru
        $data['foto'] = $request->file('foto')->store('tempat_olahraga', 'public');
    } else {
        // kalau tidak upload, jangan hapus foto lama
        $data['foto'] = $olahraga->foto;
    }

    $olahraga->update($data);

    $this->logAktivitas("Tempat olahraga telah diperbarui");
    $this->logNotifikasi("Tempat olahraga telah diperbarui");

    return redirect()->route('admin.sehat.olahraga.index')
        ->with('success', 'Tempat olahraga berhasil diperbarui!');
}

    public function destroyolahraga($id)
    {
        $olahraga = Tempat_olahraga::findOrFail($id);
         if ($olahraga->foto) Storage::disk('public')->delete($olahraga->foto);
        $olahraga->delete();

        $this->logAktivitas("Tempat olahraga telah dihapus");
        $this->logNotifikasi("Tempat olahraga telah dihapus");

        return redirect()->route('admin.sehat.olahraga.index')
            ->with('success', 'Tempat olahraga berhasil dihapus!');
    }

    public function mapolahraga()
    {
        $lokasi = Tempat_olahraga::all()->map(function ($loc) {
            return [
                'name'      => $loc->name,
                'address'   => $loc->address,
                'latitude'  => $loc->latitude,
                'longitude' => $loc->longitude,
                'foto' => $loc->foto ? asset('storage/' . $loc->foto) : null,
            ];
        });

        return view('admin.sehat.olahraga.map', compact('lokasi'));
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
            'url' => route('admin.sehat.tempat.index') // route yang valid
        ]);
    }
}
