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
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,svg,bmp|max:5120'
        ]);

        if ($request->hasFile('foto')) {
            // simpan PATH relatif di DB, bukan URL penuh
            $path = $request->file('foto')->store('foto_kesehatan', 'public');
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
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,svg,bmp|max:5120'
        ]);

        $sehat->name = $validated['name'];
        $sehat->address = $validated['address'];
        $sehat->latitude = $validated['latitude'];
        $sehat->longitude = $validated['longitude'];
        $sehat->fitur = $validated['fitur'];

        if ($request->hasFile('foto')) {
            // Hapus file lama bila ada (support jika db menyimpan URL penuh atau path)
            $oldPath = $this->getStoragePathFromFoto($sehat->foto);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('foto')->store('foto_kesehatan', 'public');
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

        // Hapus foto kalau ada (support untuk URL penuh atau path relatif)
        if ($sehat->foto) {
            $path = $this->getStoragePathFromFoto($sehat->foto);
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $sehat->delete();

        $this->logAktivitas("Lokasi Kesehatan telah dihapus");
        $this->logNotifikasi("Lokasi Kesehatan telah dihapus");

        return redirect()->route('admin.sehat.tempat.index')
            ->with('success', 'Lokasi Kesehatan berhasil dihapus!');
    }

    // API: show all or single, mengembalikan foto sebagai URL dinamis sesuai request
    public function show($id = null)
    {
        if ($id) {
            // load relasi kategori kalau ada
            $data = Sehat::with('kategori')->find($id);
            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $arr = $data->toArray();

            // mapping foto url
            $arr['foto'] = $data->foto
                ? $this->buildFotoUrl($this->getStoragePathFromFoto($data->foto))
                : null;

            // kalau relasi kategori kosong, fallback pakai fitur
            if (empty($arr['kategori'])) {
                $arr['kategori'] = $arr['fitur'] ?? null;
            }

            // hapus fitur biar tidak dobel
            unset($arr['fitur']);

            return response()->json($arr, 200);
        } else {
            $data = Sehat::with('kategori')->get()->map(function ($item) {
                $arr = $item->toArray();

                // mapping foto url
                $arr['foto'] = $item->foto
                    ? $this->buildFotoUrl($this->getStoragePathFromFoto($item->foto))
                    : null;

                // kalau relasi kategori kosong, fallback pakai fitur
                if (empty($arr['kategori'])) {
                    $arr['kategori'] = $arr['fitur'] ?? null;
                }

                // hapus fitur biar tidak dobel
                unset($arr['fitur']);

                return $arr;
            });

            return response()->json($data, 200);
        }
    }

    public function map()
    {
        $lokasi = Sehat::all()->map(function ($loc) {
            return [
                'name' => $loc->name,
                'address' => $loc->address,
                'latitude' => $loc->latitude,
                'longitude' => $loc->longitude,
                'foto' => $loc->foto ?: null,
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
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,svg,bmp|max:5120',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'fitur' => 'required|string|max:255',
        ]);

        if ($request->hasFile('foto')) {
            // simpan PATH relatif
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
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,svg,bmp|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            // hapus foto lama bila ada
            $oldPath = $this->getStoragePathFromFoto($info->foto);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
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
            $oldPath = $this->getStoragePathFromFoto($info->foto);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        $info->delete();

        $this->logAktivitas("Lokasi Kesehatan telah dihapus");
        $this->logNotifikasi("Lokasi Kesehatan telah dihapus");

        return back()->with('success', 'Info kesehatan berhasil dihapus.');
    }

    public function infoshow($id = null)
    {
        if ($id) {
            // Ambil data tunggal dengan relasi kategori
            $data = InfoKesehatan::with('kategori')->find($id);

            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $arr = [
                'id'         => $data->id,
                'judul'      => $data->judul,
                'deskripsi'  => $this->replaceImageUrlsInHtml($data->deskripsi),
                'foto'       => $data->foto
                    ? $this->buildFotoUrl($this->getStoragePathFromFoto($data->foto))
                    : null,
                'kategori'   => $data->kategori->nama ?? ($data->fitur ?? null),
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            ];

            return response()->json($arr, 200);
        } else {
            // Ambil semua data
            $data = InfoKesehatan::with('kategori')->get()->map(function ($item) {
                return [
                    'id'         => $item->id,
                    'judul'      => $item->judul,
                    'deskripsi'  => $this->replaceImageUrlsInHtml($item->deskripsi),
                    'foto'       => $item->foto
                        ? $this->buildFotoUrl($this->getStoragePathFromFoto($item->foto))
                        : null,
                    'kategori'   => $item->kategori->nama ?? ($item->fitur ?? null),
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });

            return response()->json($data, 200);
        }
    }

    // Upload endpoint (ckeditor) -> simpan file dan kembalikan URL dinamis
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . preg_replace('/\s+/', '', $file->getClientOriginalName());

            // simpan ke storage/app/public/uploads -> hasilnya "uploads/namafile.jpg"
            $path = $file->storeAs('uploads', $filename, 'public');

            // kirim ke CKEditor relative path, bukan absolute
            // CKEditor butuh URL, jadi kita kasih absolute berdasarkan host sekarang
            $url = request()->getSchemeAndHttpHost() . '/storage/' . $path;

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
            'foto'      => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,svg,bmp|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            // simpan PATH relatif
            $path = $request->file('foto')->store('tempat_olahraga', 'public');
            $validated['foto'] = $path;
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
            'foto'      => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,svg,bmp|max:5120',
        ]);

        // simpan data dulu
        $data = $validated;

        // cek apakah ada upload file baru
        if ($request->hasFile('foto')) {
            // hapus foto lama (support URL penuh atau path relatif)
            $oldPath = $this->getStoragePathFromFoto($olahraga->foto);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            // upload baru -> simpan path relatif
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
        if ($olahraga->foto) {
            $oldPath = $this->getStoragePathFromFoto($olahraga->foto);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }
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
                'foto' => $loc->foto ?: null,
            ];
        });

        return view('admin.sehat.olahraga.map', compact('lokasi'));
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
                'foto'      => $data->foto ? $this->buildFotoUrl($this->getStoragePathFromFoto($data->foto)) : null,
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
                    'foto'      => $item->foto ? $this->buildFotoUrl($this->getStoragePathFromFoto($item->foto)) : null,
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
            'url' => route('admin.sehat.tempat.index') // route yang valid
        ]);
    }

    /**
     * Utility: menerima value foto dari DB (bisa URL penuh atau path relatif)
     * dan mengembalikan path relatif di storage disk public (contoh: "foto_kesehatan/abc.jpg")
     */
    private function getStoragePathFromFoto($foto)
    {
        if (!$foto) return null;

        // Jika sudah berbentuk path relatif (tidak ada http/https), kembalikan langsung
        if (strpos($foto, 'http://') !== 0 && strpos($foto, 'https://') !== 0) {
            // kemungkinan sudah path relatif seperti 'foto_kesehatan/xxx.jpg' atau 'uploads/xxx.jpg'
            return $foto;
        }

        // jika berisi '/storage/...', ambil bagian setelah '/storage/'
        if (preg_match('#/storage/(.+)$#', $foto, $matches)) {
            return $matches[1];
        }

        // jika tidak menemukan '/storage/', ambil path dari URL, dan hapus leading '/'
        $path = parse_url($foto, PHP_URL_PATH);
        if ($path) {
            $path = ltrim($path, '/');
            // jika path mengandung 'storage/' di awal, buang segmen 'storage/'
            if (strpos($path, 'storage/') === 0) {
                return substr($path, strlen('storage/'));
            }
            return $path;
        }

        return null;
    }

    /**
     * Utility: bangun foto URL dinamis berdasarkan host yang sedang diakses
     * menerima path relatif seperti 'foto_kesehatan/abc.jpg'
     */
    private function buildFotoUrl($storagePath)
    {
        if (!$storagePath) return null;
        return request()->getSchemeAndHttpHost() . '/storage/' . ltrim($storagePath, '/');
    }

    /**
     * replaceImageUrlsInHtml:
     * - mencari semua atribut src="..." di HTML deskripsi
     * - jika src mengarah ke /storage/... atau mengandung '/storage/...', ganti dengan host saat ini
     * - jika src relative seperti 'uploads/..' juga diubah ke storage URL saat ini
     * - biarkan data URI dan external CDN tidak diubah
     */
    
    private function replaceImageUrlsInHtml($content)
    {
        if (!$content) return $content;

        return preg_replace_callback('/(<img\b[^>]*\bsrc\s*=\s*[\'"])([^\'"]+)([\'"][^>]*>)/i', function ($m) {
            $prefix = $m[1];
            $src = $m[2];
            $suffix = $m[3];

            // Biarkan data URI
            if (preg_match('/^data:/i', $src)) {
                return $m[0];
            }

            // CASE 1: absolute URL dengan /storage/
            if (preg_match('#^https?://[^/]+/storage/(.+)$#i', $src, $matches)) {
                $rel = $matches[1];
                $new = request()->getSchemeAndHttpHost() . '/storage/' . ltrim($rel, '/');
                return $prefix . $new . $suffix;
            }

            // CASE 2: absolute URL dengan /uploads/, /foto_kesehatan/, /tempat_olahraga/
            if (preg_match('#^https?://[^/]+/(uploads/.+|foto_kesehatan/.+|tempat_olahraga/.+)$#i', $src, $matches)) {
                $rel = $matches[1];
                $new = request()->getSchemeAndHttpHost() . '/storage/' . ltrim($rel, '/');
                return $prefix . $new . $suffix;
            }

            // CASE 3: relative path (uploads/xxx.jpg, foto_kesehatan/xxx.jpg, dst)
            if (preg_match('#^(uploads/|foto_kesehatan/|tempat_olahraga/)#i', $src)) {
                $new = request()->getSchemeAndHttpHost() . '/storage/' . ltrim($src, '/');
                return $prefix . $new . $suffix;
            }

            // CASE 4: path diawali /storage/
            if (strpos($src, '/storage/') === 0) {
                $rel = ltrim(substr($src, strlen('/storage/')), '/');
                $new = request()->getSchemeAndHttpHost() . '/storage/' . $rel;
                return $prefix . $new . $suffix;
            }

            // selain itu (CDN atau external image) → biarkan
            return $m[0];
        }, $content);
    }
}
