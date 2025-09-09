<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CRUDHelper;
use App\Models\Pasar;
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
        $kategoriPasar = Kategori::where('fitur', 'lokasi pasar')->orderBy('nama')->get();
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

        return redirect()->route('admin.pasar.tempat.index')
            ->with('success', 'Tempat pasar berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $item = Pasar::findOrFail($id);
        $kategoriPasar = Kategori::where('fitur', 'lokasi pasar')->get();

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

        $Pasar->name = $validated['name'];
        $Pasar->address = $validated['address'];
        $Pasar->latitude = $validated['latitude'];
        $Pasar->longitude = $validated['longitude'];
        $Pasar->fitur = $validated['fitur'];

        if ($request->hasFile('foto')) {
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

        $pasar = new Pasar();
        $pasar->name = 'Nama Tempat';
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

    public function show(Request $request, $id = null)
    {
        if ($id) {
            $data = Pasar::find($id);

            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $arr = [
                'id'         => $data->id,
                'nama'       => $data->name,
                'alamat'     => $data->address,
                'latitude'   => $data->latitude,
                'longitude'  => $data->longitude,
                'foto'       => $data->foto
                    ? $this->buildFotoUrl($this->getStoragePathFromFoto($data->foto))
                    : null,
                'kategori'   => $data->fitur,
                'fitur'      => $data->fitur,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            ];

            return response()->json($arr, 200);
        } else {
            $kategori = $request->query('kategori');

            $query = Pasar::query();

            if ($kategori) {
                $query->where('fitur', $kategori);
            }

            $data = $query->get()->map(function ($item) {
                return [
                    'id'         => $item->id,
                    'nama'       => $item->name,
                    'alamat'     => $item->address,
                    'latitude'   => $item->latitude,
                    'longitude'  => $item->longitude,
                    'foto'       => $item->foto
                        ? $this->buildFotoUrl($this->getStoragePathFromFoto($item->foto))
                        : null,
                    'kategori'   => $item->fitur,
                    'fitur'      => $item->fitur,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });

            return response()->json($data, 200);
        }
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
            'url' => route('admin.ibadah.tempat.index')
        ]);
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . preg_replace('/\s+/', '', $file->getClientOriginalName());

            $path = $file->storeAs('foto_pasar', $filename, 'public');
            $url = request()->getSchemeAndHttpHost() . '/storage/' . $path;

            return response()->json([
                'uploaded' => true,
                'url'      => $url
            ]);
        }

        return response()->json([
            'uploaded' => false,
            'error'    => [
                'message' => 'No file uploaded'
            ]
        ], 400);
    }

    private function replaceImageUrlsInHtml($html)
    {
        if (!$html) return $html;

        return preg_replace_callback(
            '/<img[^>]+src=["\']([^"\'>]+)["\']/i',
            function ($matches) {
                $src = $matches[1];
                $currentHost = request()->getSchemeAndHttpHost();

                if (preg_match('/^data:/i', $src)) {
                    return $matches[0];
                }

                if (preg_match('#^https?://[^/]+/(.+)$#i', $src, $m)) {
                    $path = $m[1];
                    $new  = $currentHost . '/' . ltrim($path, '/');
                    return str_replace($src, $new, $matches[0]);
                }

                $new = $currentHost . '/storage/' . ltrim($src, '/');
                return str_replace($src, $new, $matches[0]);
            },
            $html
        );
    }

    private function buildFotoUrl($path)
    {
        if (!$path) {
            return null;
        }
        return asset('storage/' . ltrim($path, '/'));
    }

    private function getStoragePathFromFoto($foto)
    {
        if (!$foto) {
            return null;
        }
        return ltrim($foto, '/');
    }
}