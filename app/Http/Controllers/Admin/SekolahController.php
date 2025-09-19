<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sekolah;
use App\Models\Kategori;
use App\Models\Tempat_sekolah;
use App\Models\InfoSekolah;
use App\Models\Aktivitas;
use App\Models\NotifikasiAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SekolahController extends Controller
{
    /**
     * LIST TEMPAT SEKOLAH
     */
    public function indexTempat()
    {
        $kategoriSekolah = Kategori::where('fitur', 'sekolah')->orderBy('nama')->get();
        $items = Tempat_sekolah::all(); // ini yang dikirim ke blade sebagai $items

        return view('admin.sekolah.tempat.index', compact('items', 'kategoriSekolah'));
    }

    /**
     * FORM TAMBAH TEMPAT SEKOLAH
     */
    public function createTempat()
    {
        $kategoriSekolah = Kategori::where('fitur', 'lokasi sekolah')->orderBy('nama')->get();
        $lokasi = Tempat_sekolah::all(); // untuk peta

        return view('admin.sekolah.tempat.create', compact('kategoriSekolah', 'lokasi'));
    }

    /**
     * SIMPAN TEMPAT SEKOLAH
     */
    public function storeTempat(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string',
            'address'   => 'required|string',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto'      => 'nullable|image|max:2048',
            'fitur' => 'required|string',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('sekolah_foto', 'public');
        }

        Tempat_sekolah::create($validated);

        $this->logAktivitas("Lokasi Sekolah telah ditambahkan");
        $this->logNotifikasi("Lokasi Sekolah telah ditambahkan");

        return redirect()->route('admin.sekolah.tempat.index')
            ->with('success', 'Tempat sekolah berhasil ditambahkan.');
    }

    /**
     * FORM EDIT TEMPAT SEKOLAH
     */
    public function editTempat($id)
    {
        $item = Tempat_sekolah::findOrFail($id);
        $kategoriSekolah = Kategori::where('fitur', 'lokasi sekolah')->get();
        return view('admin.sekolah.tempat.edit', compact('item', 'kategoriSekolah'));
    }

    /**
     * UPDATE TEMPAT SEKOLAH
     */
    public function updateTempat(Request $request, $id)
    {
        $sekolah = Tempat_sekolah::findOrFail($id);

        $validated = $request->validate([
            'name'      => 'required|string',
            'address'   => 'required|string',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto'      => 'nullable|image|max:2048',
            'fitur' => 'required|string',
        ]);

        if ($request->hasFile('foto')) {
            if ($sekolah->foto && Storage::disk('public')->exists($sekolah->foto)) {
                Storage::disk('public')->delete($sekolah->foto);
            }
            $validated['foto'] = $request->file('foto')->store('sekolah_foto', 'public');
        }

        $sekolah->update($validated);

        $this->logAktivitas("Lokasi Sekolah telah diupdate");
        $this->logNotifikasi("Lokasi Sekolah telah diupdate");

        return redirect()->route('admin.sekolah.tempat.index')
            ->with('success', 'Tempat sekolah berhasil diupdate');
    }

    public function tempatDestroy($id)
    {
        $item = Sekolah::whereNull('jenis_laporan')->findOrFail($id);

        if ($item->foto && Storage::disk('public')->exists($item->foto)) {
            Storage::disk('public')->delete($item->foto);
        }

        $item->delete();

        return redirect()->route('admin.sekolah.tempat.index')
            ->with('success', 'Tempat sekolah berhasil dihapus.');
    }

    /**
     * MAP TEMPAT SEKOLAH
     */
    public function mapTempat()
    {
        $lokasi = Tempat_sekolah::all()->map(function ($loc) {
            return [
                'name' => $loc->name,
                'address' => $loc->address,
                'latitude' => $loc->latitude,
                'longitude' => $loc->longitude,
                'foto' => $loc->foto ? asset('storage/' . $loc->foto) : null,
            ];
        });

        return view('admin.sekolah.tempat.map', compact('lokasi'));
    }

    /**
     * SHOW / LIST TEMPAT SEKOLAH (API)
     *
     * Mendukung:
     * - GET /api/tempat-sekolah               -> semua data (filter fitur optional)
     * - GET /api/tempat-sekolah?fitur=sd     -> filter by fitur
     * - GET /api/tempat-sekolah/{id}         -> single by ID
     */
    public function showTempat(Request $request, $id = null)
    {
        if ($id) {
            $data = Tempat_sekolah::with('kategori')->find($id);

            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $arr = [
                'id'         => $data->id,
                'name'       => $data->name,
                'address'    => $data->address,
                'latitude'   => $data->latitude,
                'longitude'  => $data->longitude,
                'fitur'      => $data->kategori->nama ?? $data->fitur, // ambil nama kategori jika ada
                'foto'       => $data->foto
                    ? $this->buildFotoUrl($this->getStoragePathFromFoto($data->foto))
                    : null,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            ];

            return response()->json($arr, 200);
        } else {
            // Build query dan apply filter 'fitur' jika ada
            $query = Tempat_sekolah::with('kategori');

            if ($request->has('fitur') && !empty($request->query('fitur'))) {
                $fitur = $request->query('fitur');
                $query->where('fitur', $fitur);
            }

            $data = $query->get()->map(function ($item) {
                return [
                    'id'         => $item->id,
                    'name'       => $item->name,
                    'address'    => $item->address,
                    'latitude'   => $item->latitude,
                    'longitude'  => $item->longitude,
                    'fitur'      => $item->kategori->nama ?? $item->fitur,
                    'foto'       => $item->foto
                        ? $this->buildFotoUrl($this->getStoragePathFromFoto($item->foto))
                        : null,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });

            return response()->json($data, 200);
        }
    }

    // ======================= ADUAN SEKOLAH DIHAPUS =======================
    // Semua method yang berhubungan dengan aduan sekolah telah dihapus sesuai permintaan.
    // ==================================================================

    // info sekolah
    public function infoindex()
    {
        $infoItems = InfoSekolah::oldest()->get();
        return view('admin.sekolah.info.index', compact('infoItems'));
    }

    public function infocreate()
    {
        return view('admin.sekolah.info.create');
    }

    public function infostore(Request $request)
    {
        $data = $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,svg,bmp|max:5120',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_sekolah', 'public');
        }

        InfoSekolah::create($data);

        $this->logAktivitas("Info Sekolah telah ditambahkan");
        $this->logNotifikasi("Info Sekolah telah ditambahkan");

        return redirect()->route('admin.sekolah.info.index')->with('success', 'Info sekolah berhasil ditambahkan.');
    }

    public function infoedit($id)
    {
        $info = InfoSekolah::findOrFail($id);

        return view('admin.sekolah.info.edit', compact('info'));
    }

    public function infoupdate(Request $request, $id)
    {
        $info = InfoSekolah::findOrFail($id);

        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,svg,bmp|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            // hapus foto lama bila ada
            $oldPath = $this->getStoragePathFromFoto($info->foto);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            $data['foto'] = $request->file('foto')->store('foto_sekolah', 'public');
        }

        $info->update($data);

        $this->logAktivitas("Info Sekolah telah diupdate");
        $this->logNotifikasi("Info Sekolah telah diupdate");

        return redirect()->route('admin.sekolah.info.index')->with('success', 'Info sekolah berhasil diperbarui.');
    }

    public function infodestroy($id)
    {
        $info = InfoSekolah::findOrFail($id);

        if ($info->foto) {
            $oldPath = $this->getStoragePathFromFoto($info->foto);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        $info->delete();

        $this->logAktivitas("Info Sekolah telah dihapus");
        $this->logNotifikasi("Info Sekolah telah dihapus");

        return back()->with('success', 'Info sekolah berhasil dihapus.');
    }

    public function infoupload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');

            // bikin nama file unik + hilangkan spasi
            $filename = time() . '_' . preg_replace('/\s+/', '', $file->getClientOriginalName());

            // simpan ke folder storage/app/public/foto_sekolah
            $file->storeAs('foto_sekolah', $filename, 'public');

            // URL dinamis sesuai host yang sedang diakses
            $url = $request->getSchemeAndHttpHost() . '/storage/foto_sekolah/' . $filename;

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

    /**
     * infoshow:
     * - numeric $id -> single item
     * - no id -> paginated list (10 per page)
     */
    public function infoshow($id = null)
    {
        if ($id) {
            $data = InfoSekolah::find($id);

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
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            ];

            return response()->json($arr, 200);
        } else {
            // Paginated 10 per page, latest first
            $paginator = InfoSekolah::with([])->orderByDesc('created_at')->paginate(10);

            // transform items to include replaced image URLs
            $paginator->getCollection()->transform(function ($item) {
                return [
                    'id'         => $item->id,
                    'judul'      => $item->judul,
                    'deskripsi'  => $this->replaceImageUrlsInHtml($item->deskripsi),
                    'foto'       => $item->foto
                        ? $this->buildFotoUrl($this->getStoragePathFromFoto($item->foto))
                        : null,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });

            return response()->json($paginator, 200);
        }
    }

    /**
     * Helper: mengganti semua <img src="..."> di deskripsi
     * agar selalu pakai host/domain yang sedang digunakan
     */
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

    /**
     * Helper: convert path simpanan jadi URL
     */
    private function buildFotoUrl($path)
    {
        return request()->getSchemeAndHttpHost() . '/storage/' . ltrim($path, '/');
    }

    private function getStoragePathFromFoto($foto)
    {
        // kalau di DB simpan "foto_sekolah/namafile.jpg"
        return $foto;
    }

    protected function logAktivitas($pesan)
    {
        if (auth()->check()) {
            Aktivitas::create([
                'user_id' => auth()->id(),
                'tipe' => 'sekolah',
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