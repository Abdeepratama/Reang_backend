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
        $this->aktivitasTipe = 'Tempat ibadah';
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
        return view('admin.ibadah.tempat.index', compact('items'));
    }

    public function createTempat(Request $request)
    {
        $kategoriIbadah = Kategori::where('fitur', 'lokasi ibadah')->orderBy('nama')->get();
        $lokasi = Ibadah::all();

        return view('admin.ibadah.tempat.create', [
            'kategoriIbadah' => $kategoriIbadah,
            'lokasi' => $lokasi,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'address' => $request->address,
        ]);
    }

    public function storeTempat(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'address'   => 'required|string',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'fitur'     => 'required|string',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('ibadah_foto', 'public');
            $validated['foto'] = $path;
        }

        Ibadah::create($validated);

        $this->logAktivitas("Tempat ibadah telah ditambahkan");
        $this->logNotifikasi("Tempat Ibadah telah ditambahkan.");

        return redirect()->route('admin.ibadah.tempat.index')
            ->with('success', 'Tempat ibadah berhasil ditambahkan!');
    }

    public function editTempat($id)
    {
        $item = Ibadah::findOrFail($id);
        $kategoriIbadah = Kategori::where('fitur', 'lokasi ibadah')->orderBy('nama')->get();
        $lokasi = Ibadah::all();

        return view('admin.ibadah.tempat.edit', compact('item', 'kategoriIbadah', 'lokasi'));
    }

    public function updateTempat(Request $request, $id)
    {
        $ibadah = Ibadah::findOrFail($id);

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'address'   => 'required|string',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'fitur'     => 'required|string',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $ibadah->update($validated);

        if ($request->hasFile('foto')) {
            if ($ibadah->foto && Storage::disk('public')->exists($ibadah->foto)) {
                Storage::disk('public')->delete($ibadah->foto);
            }
            $path = $request->file('foto')->store('ibadah_foto', 'public');
            $ibadah->foto = $path;
            $ibadah->save();
        }

        $this->logAktivitas("Tempat ibadah diperbarui");
        $this->logNotifikasi("Tempat Ibadah diperbarui");

        return redirect()->route('admin.ibadah.tempat.index')
            ->with('success', 'Lokasi berhasil diperbarui!');
    }

    public function destroyTempat($id)
    {
        $ibadah = Ibadah::findOrFail($id);

        if ($ibadah->foto) {
            Storage::disk('public')->delete($ibadah->foto);
        }

        $ibadah->delete();

        return redirect()->route('admin.ibadah.tempat.index')
            ->with('success', 'Data ibadah berhasil dihapus');
    }

    /* ========================
   API TEMPAT
   ======================== */

    public function showTempat(Request $request, $id = null)
    {
        if ($id) {
            $data = Ibadah::with('kategori')->find($id);
            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            return response()->json([
                'id'         => $data->id,
                'name'       => $data->name,
                'address'    => $data->address,
                'latitude'   => $data->latitude,
                'longitude'  => $data->longitude,
                'fitur'      => $data->kategori->nama ?? $data->fitur,
                'foto'       => $data->foto ? $this->buildFotoUrl($this->getStoragePathFromFoto($data->foto)) : null,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            ], 200);
        }

        $filter = $request->query('fitur', $request->query('jenis', null));
        $query = Ibadah::with('kategori');

        if ($filter !== null && $filter !== '') {
            if (is_numeric($filter)) {
                $query->where('fitur', $filter)
                    ->orWhereHas('kategori', fn($q) => $q->where('id', $filter));
            } else {
                $text = strtolower($filter);
                $query->where(function ($q) use ($text) {
                    $q->whereRaw('LOWER(fitur) LIKE ?', ["%$text%"])
                        ->orWhereHas('kategori', fn($q2) => $q2->whereRaw('LOWER(nama) LIKE ?', ["%$text%"]));
                });
            }
        }

        $data = $query->get()->map(fn($item) => [
            'id'         => $item->id,
            'name'       => $item->name,
            'address'    => $item->address,
            'latitude'   => $item->latitude,
            'longitude'  => $item->longitude,
            'fitur'      => $item->kategori->nama ?? $item->fitur,
            'foto'       => $item->foto ? $this->buildFotoUrl($this->getStoragePathFromFoto($item->foto)) : null,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ]);

        return response()->json($data, 200);
    }

    public function showTempatWeb($id)
    {
        $data = Ibadah::with('kategori')->findOrFail($id);
        return view('admin.ibadah.tempat.show', compact('data'));
    }


    public function infoIndex()
    {
        $infoItems = InfoKeagamaan::all(); // gunakan model yang benar
        return view('admin.ibadah.info.index', compact('infoItems'));
    }

    public function createInfo()
    {
        $kategoriInfoIbadah = Kategori::where('fitur', 'info ibadah')->get();

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

        return view('admin.ibadah.info.create', compact('kategoriInfoIbadah', 'lokasi'));
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

        $this->logAktivitas("Info keagamaan telah ditambahkan");
        $this->logNotifikasi("Info keagamaan telah ditambahkan");

        return redirect()->route('admin.ibadah.info.index')->with('success', 'Info keagamaan berhasil disimpan.');
    }

    public function infoEdit($id)
    {
        $info = InfoKeagamaan::findOrFail($id);
        $kategoriInfoIbadah = Kategori::where('fitur', 'info ibadah')->get();
        return view('admin.ibadah.info.edit', compact('info', 'kategoriInfoIbadah'));
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

        $this->logAktivitas("Info keagamaan telah diperbarui");
        $this->logNotifikasi("Info keagamaan telah diperbarui");

        return redirect()->route('admin.ibadah.info.index')->with('success', 'Info Keagamaan berhasil diperbarui');
    }

    public function infoDestroy($id)
    {
        $item = InfoKeagamaan::findOrFail($id);
        if ($item->foto) Storage::disk('public')->delete($item->foto);
        $item->delete();

        $this->logAktivitas("Info keagamaan telah dihapus");
        $this->logNotifikasi("Info keagamaan telah dihapus");

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

    public function infoshow($id = null)
    {
        if ($id) {
            // Ambil data tunggal dengan relasi kategori
            $data = InfoKeagamaan::with('kategori')->find($id);

            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $arr = [
                'id'         => $data->id,
                'judul'      => $data->judul,
                'tanggal'    => $data->tanggal,
                'waktu'      => $data->waktu,
                'deskripsi'  => $this->replaceImageUrlsInHtml($data->deskripsi),
                'lokasi'     => $data->lokasi,
                'alamat'     => $data->alamat,
                'foto'       => $data->foto
                    ? $this->buildFotoUrl($this->getStoragePathFromFoto($data->foto))
                    : null,
                'kategori'   => $data->kategori->nama ?? ($data->fitur ?? null),
                'latitude'   => $data->latitude,
                'longitude'  => $data->longitude,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            ];

            return response()->json($arr, 200);
        } else {
            // Ambil semua data
            $data = InfoKeagamaan::with('kategori')->get()->map(function ($item) {
                return [
                    'id'         => $item->id,
                    'judul'      => $item->judul,
                    'tanggal'    => $item->tanggal,
                    'waktu'      => $item->waktu,
                    'deskripsi'  => $this->replaceImageUrlsInHtml($item->deskripsi),
                    'lokasi'     => $item->lokasi,
                    'alamat'     => $item->alamat,
                    'foto'       => $item->foto
                        ? $this->buildFotoUrl($this->getStoragePathFromFoto($item->foto))
                        : null,
                    'kategori'   => $item->kategori->nama ?? ($item->fitur ?? null),
                    'latitude'   => $item->latitude,
                    'longitude'  => $item->longitude,
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
            'url' => route('admin.ibadah.tempat.index') // route yang valid
        ]);
    }

    private function getStoragePathFromFoto($foto)
    {
        if (!$foto) return null;

        // Jika sudah berbentuk path relatif (tidak ada http/https), kembalikan langsung
        if (strpos($foto, 'http://') !== 0 && strpos($foto, 'https://') !== 0) {
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
            if (strpos($path, 'storage/') === 0) {
                return substr($path, strlen('storage/'));
            }
            return $path;
        }

        return null;
    }

    /**
     * Utility: bangun foto URL dinamis berdasarkan host yang sedang diakses
     */
    private function buildFotoUrl($storagePath)
    {
        if (!$storagePath) return null;
        return request()->getSchemeAndHttpHost() . '/storage/' . ltrim($storagePath, '/');
    }

    /**
     * Replace image URLs dalam deskripsi HTML agar pakai host saat ini
     */
    private function replaceImageUrlsInHtml($content)
    {
        if (!$content) return $content;

        return preg_replace_callback('/(<img\b[^>]\bsrc\s=\s*[\'"])([^\'"]+)([\'"][^>]*>)/i', function ($m) {
            $prefix = $m[1];
            $src = $m[2];
            $suffix = $m[3];

            // Biarkan data URI atau external CDN
            if (preg_match('/^data:/i', $src)) {
                return $m[0];
            }

            // Jika absolute URL
            if (preg_match('/^https?:\/\//i', $src)) {
                if (preg_match('#/storage/(.+)#i', $src, $matches)) {
                    $rel = $matches[1];
                    $new = request()->getSchemeAndHttpHost() . '/storage/' . ltrim($rel, '/');
                    return $prefix . $new . $suffix;
                }
                if (preg_match('#/(uploads/.+)$#i', $src, $m2)) {
                    $rel = $m2[1];
                    $new = request()->getSchemeAndHttpHost() . '/storage/' . ltrim($rel, '/');
                    return $prefix . $new . $suffix;
                }
                return $m[0]; // external lain biarkan
            }

            // Jika relative
            $parsedPath = $src;
            if (strpos($parsedPath, '/storage/') === 0) {
                $rel = ltrim(substr($parsedPath, strlen('/storage/')), '/');
                $new = request()->getSchemeAndHttpHost() . '/storage/' . $rel;
                return $prefix . $new . $suffix;
            }
            if (strpos($parsedPath, '/uploads/') === 0) {
                $rel = ltrim($parsedPath, '/');
                $new = request()->getSchemeAndHttpHost() . '/storage/' . $rel;
                return $prefix . $new . $suffix;
            }
            if (preg_match('#^(uploads/|foto_ibadah/|foto_keagamaan/|tempat_ibadah/)#i', $parsedPath)) {
                $new = request()->getSchemeAndHttpHost() . '/storage/' . ltrim($parsedPath, '/');
                return $prefix . $new . $suffix;
            }

            return $m[0];
        }, $content);
    }
}
