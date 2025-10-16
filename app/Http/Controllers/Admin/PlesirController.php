<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CRUDHelper;
use App\Models\Plesir;
use App\Models\Kategori;
use App\Models\Aktivitas;
use App\Models\NotifikasiAktivitas;
use App\Models\InfoPlesir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlesirController extends Controller
{
    public function create()
    {
        $kategoriPlesir = Kategori::where('fitur', 'lokasi plesir')->orderBy('nama')->get();
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

        $this->logAktivitas("Lokasi Plesir telah ditambahkan");
        $this->logNotifikasi("Lokasi Plesir telah ditambahkan");

        return redirect()->route('admin.plesir.tempat.index',)
            ->with('success', 'Tempat plesir berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $item = Plesir::findOrFail($id);
        $kategoriPlesir = Kategori::where('fitur', 'lokasi plesir')->get(); // ambil khusus kategori untuk fitur 'plesir'

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

        $this->logAktivitas("Lokasi Plesir telah diupdate");
        $this->logNotifikasi("Lokasi Plesir telah diupdate");

        return redirect()->route('admin.plesir.tempat.index')
            ->with('success', 'Lokasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $plesir = Plesir::findOrFail($id);

        // Hapus foto jika ada
        if ($plesir->foto && Storage::disk('public')->exists($plesir->foto)) {
            Storage::disk('public')->delete($plesir->foto);
        }

        $plesir->delete();

        $this->logAktivitas("Lokasi Plesir telah dihapus");
        $this->logNotifikasi("Lokasi Plesir telah dihapus");

        return redirect()->route('admin.plesir.tempat.index')
            ->with('success', 'Lokasi plesir berhasil dihapus!');
    }

    public function map()
    {
        $lokasi = Plesir::all()->map(function ($loc) {
            return [
                'name' => $loc->name,
                'address' => $loc->address,
                'latitude' => $loc->latitude,
                'longitude' => $loc->longitude,
                // pastikan sudah menjalankan php artisan storage:link
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

    // --- API UNTUK TEMPAT PLESIR (DIPERBARUI) ---
    public function showTempat(Request $request, $id = null)
    {
        if ($id) {
            $data = Plesir::find($id);
            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
            $arr = [
                'id'         => $data->id,
                'name'       => $data->name,
                'address'    => $data->address,
                'latitude'   => $data->latitude,
                'longitude'  => $data->longitude,
                'fitur'      => $data->fitur,
                'foto'       => $data->foto ? asset('storage/' . $data->foto) : null,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            ];
            return response()->json($arr, 200);
        } else {
            $query = Plesir::latest();
            if ($request->has('fitur') && $request->fitur != '') {
                $query->where('fitur', $request->fitur);
            }
            $paginatedData = $query->paginate(10);
            $paginatedData->getCollection()->transform(function ($item) {
                return [
                    'id'         => $item->id,
                    'name'       => $item->name,
                    'address'    => $item->address,
                    'latitude'   => $item->latitude,
                    'longitude'  => $item->longitude,
                    'fitur'      => $item->fitur,
                    'foto'       => $item->foto ? asset('storage/' . $item->foto) : null,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return response()->json($paginatedData, 200);
        }
    }

    public function showTempatWeb($id)
    {
        $data = Plesir::with('kategori')->findOrFail($id);
        return view('admin.plesir.tempat.show', compact('data'));
    }

    // --- ENDPOINT BARU UNTUK MENGAMBIL FITUR TEMPAT PLESIR ---
    public function apiGetTempatFitur()
    {
        $fitur = Plesir::select('fitur')->groupBy('fitur')->orderByRaw('MIN(created_at) asc')->pluck('fitur');
        return response()->json($fitur, 200);
    }

    public function info()
    {
        $infoItems = InfoPlesir::with('kategori')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.plesir.info.index', compact('infoItems'));
    }

    public function createInfo()
    {
        $kategoriPlesir = Kategori::where('fitur', 'info plesir')
            ->orderBy('nama')
            ->get();

        $lokasi = InfoPlesir::all();

        return view('admin.plesir.info.create', [
            'kategoriPlesir' => $kategoriPlesir,
            'lokasi' => $lokasi,
        ]);
    }

    public function storeInfo(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'judul' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'fitur' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
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
            'rating' => 0, // default 0, nanti diupdate dari Flutter
            'deskripsi' => $request->deskripsi,
            'fitur' => $request->fitur,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        $this->logAktivitas("Info Plesir telah ditambahkan");
        $this->logNotifikasi("Info Plesir telah ditambahkan");

        return redirect()->route('admin.plesir.info.index')->with('success', 'Info plesir berhasil disimpan.');
    }

    public function infoEdit($id)
    {
        $info = InfoPlesir::findOrFail($id);
        $kategoriPlesir = Kategori::where('fitur', 'info plesir')->orderBy('nama')->get();
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
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($request->hasFile('foto')) {
            if ($item->foto) {
                Storage::disk('public')->delete($item->foto);
            }

            $data['foto'] = $request->file('foto')->store('foto_plesir', 'public');
        }

        $item->update($data);

        $this->logAktivitas("Info Plesir telah diupdate");
        $this->logNotifikasi("Info Plesir telah diupdate");

        return redirect()->route('admin.plesir.info.index')->with('success', 'Info plesir berhasil diperbarui.');
    }

    public function infoDestroy($id)
    {
        $item = InfoPlesir::findOrFail($id);
        if ($item->foto) Storage::disk('public')->delete($item->foto);
        $item->delete();

        $this->logAktivitas("Info Plesir telah dihapus");
        $this->logNotifikasi("Info Plesir telah dihapus");

        return back()->with('success', 'Info plesir berhasil dihapus.');
    }

    public function infoshowDetail($id)
    {
        $info = InfoPlesir::findOrFail($id);
        return view('admin.plesir.info.show', compact('info'));
    }

    public function infomap()
    {
        $lokasi = InfoPlesir::all()->map(function ($loc) {
            return [
                'name' => $loc->judul,        // ganti 'name' jadi 'judul'
                'address' => $loc->alamat,      // ganti 'address' jadi 'alamat'
                'latitude' => $loc->latitude,
                'longitude' => $loc->longitude,
                'foto' => $loc->foto ? asset('storage/' . $loc->foto) : null,
                'fitur' => $loc->fitur,        // kalau mau tampilkan kategori/fitur
                'rating' => $loc->rating,      // rating juga bisa ditambahkan
            ];
        });

        return view('admin.plesir.info.map', compact('lokasi'));
    }

    // --- API UNTUK INFO PLESIR (DIPERBARUI) ---
    public function infoshow(Request $request, $id = null)
    {
        if ($id) {
            $data = InfoPlesir::with('kategori')->find($id);

            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $arr = [
                'id'              => $data->id,
                'judul'           => $data->judul,
                'alamat'          => $data->alamat,
                'rating'          => $data->rating,
                'latitude'        => $data->latitude,
                'longitude'       => $data->longitude,
                'foto'            => $data->foto ? $this->buildFotoUrl($this->getStoragePathFromFoto($data->foto)) : null,
                'kategori'        => $data->kategori->nama ?? ($data->fitur ?? null),
                'deskripsi'       => $this->replaceImageUrlsInHtml($data->deskripsi),
                'created_at'      => $data->created_at,
                'updated_at'      => $data->updated_at,
            ];

            return response()->json($arr, 200);
        } else {
            $query = InfoPlesir::with('kategori')->latest();

            if ($request->has('fitur') && $request->fitur != '') {
                $query->where('fitur', $request->fitur);
            }

            $paginatedData = $query->paginate(10);

            $paginatedData->getCollection()->transform(function ($item) {
                return [
                    'id'              => $item->id,
                    'judul'           => $item->judul,
                    'alamat'          => $item->alamat,
                    'rating'          => $item->rating,
                    'latitude'        => $item->latitude,
                    'longitude'       => $item->longitude,
                    'foto'            => $item->foto ? $this->buildFotoUrl($this->getStoragePathFromFoto($item->foto)) : null,
                    'kategori'        => $item->kategori->nama ?? ($item->fitur ?? null),
                    'deskripsi'       => $this->replaceImageUrlsInHtml($item->deskripsi),
                    'created_at'      => $item->created_at,
                    'updated_at'      => $item->updated_at,
                ];
            });

            return response()->json($paginatedData, 200);
        }
    }

    // --- ENDPOINT BARU UNTUK MENGAMBIL FITUR INFO PLESIR ---
    public function apiGetInfoFitur()
    {
        $fitur = InfoPlesir::select('fitur')->groupBy('fitur')->orderByRaw('MIN(created_at) asc')->pluck('fitur');
        return response()->json($fitur, 200);
    }


    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . preg_replace('/\s+/', '', $file->getClientOriginalName());

            $path = $file->storeAs('foto_plesir', $filename, 'public');
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

    protected $aktivitasTipe = 'Sekolah';

    protected function logAktivitas($pesan)
    {
        if (auth()->check()) {
            $user = auth()->user();

            // untuk role/dinas yang melakukan aksi
            Aktivitas::create([
                'user_id'      => $user->id,
                'tipe'         => $this->aktivitasTipe,
                'keterangan'   => $pesan,
                'role'         => $user->role,
                'id_instansi'  => $user->id_instansi,
            ]);
        }
    }

    protected function logNotifikasi($pesan)
    {
        $user = auth()->user();

        NotifikasiAktivitas::create([
            'keterangan'   => $pesan,
            'dibaca'       => false,
            'url'          => route('admin.sekolah.tempat.index'),
            'role'         => $user->role,
            'id_instansi'  => $user->id_instansi,
        ]);
    }

    private function replaceImageUrlsInHtml($html)
    {
        if (!$html) return $html;

        return preg_replace_callback(
            '/<img[^>]+src=["\']([^"\'>]+)["\']/i',
            function ($matches) {
                $src = $matches[1];
                $currentHost = request()->getSchemeAndHttpHost();

                // kalau data:image (base64), biarkan
                if (preg_match('/^data:/i', $src)) {
                    return $matches[0];
                }

                // kalau absolute URL tapi bukan host sekarang → ganti
                if (preg_match('#^https?://[^/]+/(.+)$#i', $src, $m)) {
                    $path = $m[1];
                    $new  = $currentHost . '/' . ltrim($path, '/');
                    return str_replace($src, $new, $matches[0]);
                }

                // kalau relative path (misal: foto_sekolah/abc.jpg)
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
