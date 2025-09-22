<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InfoKerja;
use App\Models\Kategori;
use App\Models\Aktivitas;
use App\Models\NotifikasiAktivitas;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class KerjaController extends Controller
{
    public function infoindex()
    {
        $infoItems = InfoKerja::with('kategori')->get();

        return view('admin.kerja.info.index', compact('infoItems'));
    }

    public function infocreate()
    {
        $kategoriKerja = Kategori::where('fitur', 'info kerja')->orderBy('nama')->get();
        return view('admin.kerja.info.create', ['kategoriKerja' => $kategoriKerja]);
    }

    public function infostore(Request $request)
    {
        $data = $request->validate([
            'foto'          => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,svg,bmp|max:5120',
            'name'          => 'required|string',
            'judul'         => 'required|string|max:255',
            'alamat'        => 'required|string',
            'gaji'          => 'nullable|string|max:255',
            'nomor_telepon' => 'nullable|string|max:50',
            'waktu_kerja'   => 'nullable|string|max:255',
            'jenis_kerja'   => 'nullable|string|max:255',
            'fitur'         => 'required|string|max:255',
            'deskripsi'     => 'required|string',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_kerja', 'public');
        }

        InfoKerja::create($data);

        $this->logAktivitas("Info Kerja telah ditambahkan");
        $this->logNotifikasi("Info Kerja telah ditambahkan");

        return redirect()->route('admin.kerja.info.index')->with('success', 'Info kerja berhasil ditambahkan.');
    }

    public function infoedit($id)
    {
        $info = InfoKerja::findOrFail($id);
        $kategoriKerja = Kategori::where('fitur', 'info kerja')->get();

        return view('admin.kerja.info.edit', [
            'info' => $info,
            'kategoriKerja' => $kategoriKerja,
        ]);
    }

    public function infoupdate(Request $request, $id)
    {
        $info = InfoKerja::findOrFail($id);

        $data = $request->validate([
            'judul'         => 'required|string|max:255',
            'name'          => 'required|string',
            'alamat'        => 'required|string',
            'gaji'          => 'nullable|string|max:255',
            'nomor_telepon' => 'nullable|string|max:50',
            'waktu_kerja'   => 'nullable|string|max:255',
            'jenis_kerja'   => 'nullable|string|max:255',
            'fitur'         => 'required|string|max:255',
            'deskripsi'     => 'required|string',
            'foto'          => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,svg,bmp|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            $oldPath = $this->getStoragePathFromFoto($info->foto);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            $data['foto'] = $request->file('foto')->store('foto_kerja', 'public');
        }

        $info->update($data);

        $this->logAktivitas("Info Kerja telah diupdate");
        $this->logNotifikasi("Info Kerja telah diupdate");

        return redirect()->route('admin.kerja.info.index')->with('success', 'Info kerja berhasil diperbarui.');
    }

    public function infodestroy($id)
    {
        $info = InfoKerja::findOrFail($id);

        if ($info->foto) {
            $oldPath = $this->getStoragePathFromFoto($info->foto);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        $info->delete();

        $this->logAktivitas("Info Kerja telah dihapus");
        $this->logNotifikasi("Info Kerja telah dihapus");

        return back()->with('success', 'Info kerja berhasil dihapus.');
    }

    /**
     * Helper: apply smart search
     * - columns: columns on main table to search (no whereHas usage to avoid dependency on kategori_id)
     */
    private function applySmartSearch(Builder $query, string $text, array $columns = [], array $secondary = [])
    {
        $text = trim(mb_strtolower($text));
        if ($text === '') return;

        $tokens = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        if (!$tokens || count($tokens) === 0) return;

        // WHERE: AND across tokens, OR across columns
        $query->where(function ($q) use ($tokens, $columns) {
            foreach ($tokens as $tok) {
                $tok = trim($tok);
                if ($tok === '') continue;

                $q->where(function ($q2) use ($tok, $columns) {
                    foreach ($columns as $col) {
                        $q2->orWhereRaw("LOWER({$col}) LIKE ?", ["%{$tok}%"]);
                    }
                });
            }
        });

        // ORDER BY relevance
        $prefixParts = [];
        $containsParts = [];
        $bindings = [];

        foreach ($tokens as $tok) {
            $tok = trim($tok);
            if ($tok === '') continue;

            $perTokenPrefix = [];
            $perTokenContains = [];

            foreach ($columns as $col) {
                $perTokenPrefix[] = "LOWER({$col}) LIKE ?";
                $bindings[] = $tok . '%';
                $perTokenContains[] = "LOWER({$col}) LIKE ?";
                $bindings[] = '%' . $tok . '%';
            }

            if (!empty($perTokenPrefix)) $prefixParts[] = '(' . implode(' OR ', $perTokenPrefix) . ')';
            if (!empty($perTokenContains)) $containsParts[] = '(' . implode(' OR ', $perTokenContains) . ')';
        }

        $prefixExpr = count($prefixParts) ? implode(' OR ', $prefixParts) : '0=1';
        $containsExpr = count($containsParts) ? implode(' OR ', $containsParts) : '0=1';
        $caseExpr = "(CASE WHEN ({$prefixExpr}) THEN 0 WHEN ({$containsExpr}) THEN 1 ELSE 2 END)";

        $query->orderByRaw($caseExpr, $bindings);

        foreach ($secondary as $sec) {
            if (is_array($sec) && count($sec) >= 2) {
                $col = $sec[0];
                $dir = strtolower($sec[1]) === 'asc' ? 'asc' : 'desc';
                $query->orderBy($col, $dir);
            }
        }
    }

    /**
     * API: infoshow
     * - GET /api/info-kerja                -> paginated (10)
     * - GET /api/info-kerja?fitur=...      -> paginate filtered by fitur
     * - GET /api/info-kerja?search=...     -> smart search paginate
     * - GET /api/info-kerja?all=1          -> return all matching (no pagination)
     * - GET /api/info-kerja/{id}           -> single item
     * - GET /api/info-kerja/kategori      -> categories list (handled below)
     */
    public function infoshow(Request $request, $id = null)
    {
        // Special-case: if path is /info-kerja/kategori -> return kategori list
        if ($id !== null && !is_numeric($id) && strtolower($id) === 'kategori') {
            return $this->kategoriList();
        }

        // single item by numeric id
        if ($id && is_numeric($id)) {
            $data = InfoKerja::with('kategori')->find($id);

            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $arr = [
                'id'                => $data->id,
                'Nama Perusahaan'   => $data->name,
                'Posisi'            => $data->judul,
                'alamat'            => $data->alamat,
                'gaji'              => $data->gaji,
                'nomor_telepon'     => $data->nomor_telepon,
                'waktu_kerja'       => $data->waktu_kerja,
                'jenis_kerja'       => $data->jenis_kerja,
                'foto'              => $data->foto ? $this->buildFotoUrl($this->getStoragePathFromFoto($data->foto)) : null,
                'kategori'          => $data->kategori->nama ?? ($data->fitur ?? null),
                'deskripsi'         => $this->replaceImageUrlsInHtml($data->deskripsi),
                'created_at'        => $data->created_at,
                'updated_at'        => $data->updated_at,
            ];

            return response()->json($arr, 200);
        }

        // base query
        $query = InfoKerja::with('kategori');

        // check filter 'fitur' or 'kategori'
        $filter = $request->query('fitur', $request->query('kategori', null));
        $isAll = $request->query('all') === '1';

        if ($filter !== null && $filter !== '') {
            if (is_numeric($filter)) {
                $possibleCat = Kategori::find($filter);
                if ($possibleCat) {
                    $query->where(function ($q) use ($possibleCat, $filter) {
                        $q->where('fitur', $possibleCat->nama)
                          ->orWhere('fitur', $filter);
                    });
                } else {
                    $query->where('fitur', $filter);
                }
            } else {
                $textFilter = mb_strtolower($filter);
                $query->whereRaw('LOWER(fitur) LIKE ?', ["%{$textFilter}%"]);
            }

            if ($request->filled('search') || $request->filled('q')) {
                $text = $request->query('search', $request->query('q'));
                $this->applySmartSearch($query, $text, ['judul','name','alamat','deskripsi','fitur'], [['created_at','desc']]);
            }

            if ($isAll) {
                $data = $query->orderByDesc('created_at')->get()->map(function ($item) {
                    return [
                        'id'               => $item->id,
                        'Nama Perusahaan'  => $item->name,
                        'Posisi'           => $item->judul,
                        'alamat'           => $item->alamat,
                        'gaji'             => $item->gaji,
                        'nomor_telepon'    => $item->nomor_telepon,
                        'waktu_kerja'      => $item->waktu_kerja,
                        'jenis_kerja'      => $item->jenis_kerja,
                        'foto'             => $item->foto ? $this->buildFotoUrl($this->getStoragePathFromFoto($item->foto)) : null,
                        'kategori'         => $item->kategori->nama ?? ($item->fitur ?? null),
                        'deskripsi'        => $this->replaceImageUrlsInHtml($item->deskripsi),
                        'created_at'       => $item->created_at,
                        'updated_at'       => $item->updated_at,
                    ];
                });

                return response()->json($data, 200);
            }

            $paginator = $query->orderByDesc('created_at')->paginate(10);
            $paginator->getCollection()->transform(function ($item) {
                return [
                    'id'               => $item->id,
                    'Nama Perusahaan'  => $item->name,
                    'Posisi'           => $item->judul,
                    'alamat'           => $item->alamat,
                    'gaji'             => $item->gaji,
                    'nomor_telepon'    => $item->nomor_telepon,
                    'waktu_kerja'      => $item->waktu_kerja,
                    'jenis_kerja'      => $item->jenis_kerja,
                    'foto'             => $item->foto ? $this->buildFotoUrl($this->getStoragePathFromFoto($item->foto)) : null,
                    'kategori'         => $item->kategori->nama ?? ($item->fitur ?? null),
                    'deskripsi'        => $this->replaceImageUrlsInHtml($item->deskripsi),
                    'created_at'       => $item->created_at,
                    'updated_at'       => $item->updated_at,
                ];
            });

            return response()->json($paginator, 200);
        }

        // smart search (no fitur filter)
        if ($request->filled('search') || $request->filled('q')) {
            $text = $request->query('search', $request->query('q'));
            $this->applySmartSearch($query, $text, ['judul','name','alamat','deskripsi','fitur'], [['created_at','desc']]);

            if ($isAll) {
                $data = $query->orderByDesc('created_at')->get()->map(function ($item) {
                    return [
                        'id'               => $item->id,
                        'Nama Perusahaan'  => $item->name,
                        'Posisi'           => $item->judul,
                        'alamat'           => $item->alamat,
                        'gaji'             => $item->gaji,
                        'nomor_telepon'    => $item->nomor_telepon,
                        'waktu_kerja'      => $item->waktu_kerja,
                        'jenis_kerja'      => $item->jenis_kerja,
                        'foto'             => $item->foto ? $this->buildFotoUrl($this->getStoragePathFromFoto($item->foto)) : null,
                        'kategori'         => $item->kategori->nama ?? ($item->fitur ?? null),
                        'deskripsi'        => $this->replaceImageUrlsInHtml($item->deskripsi),
                        'created_at'       => $item->created_at,
                        'updated_at'       => $item->updated_at,
                    ];
                });

                return response()->json($data, 200);
            }

            $paginator = $query->paginate(10);
            $paginator->getCollection()->transform(function ($item) {
                return [
                    'id'               => $item->id,
                    'Nama Perusahaan'  => $item->name,
                    'Posisi'           => $item->judul,
                    'alamat'           => $item->alamat,
                    'gaji'             => $item->gaji,
                    'nomor_telepon'    => $item->nomor_telepon,
                    'waktu_kerja'      => $item->waktu_kerja,
                    'jenis_kerja'      => $item->jenis_kerja,
                    'foto'             => $item->foto ? $this->buildFotoUrl($this->getStoragePathFromFoto($item->foto)) : null,
                    'kategori'         => $item->kategori->nama ?? ($item->fitur ?? null),
                    'deskripsi'        => $this->replaceImageUrlsInHtml($item->deskripsi),
                    'created_at'       => $item->created_at,
                    'updated_at'       => $item->updated_at,
                ];
            });

            return response()->json($paginator, 200);
        }

        // default: paginate 10 latest first (or all if all=1)
        if ($isAll) {
            $data = $query->orderByDesc('created_at')->get()->map(function ($item) {
                return [
                    'id'               => $item->id,
                    'Nama Perusahaan'  => $item->name,
                    'Posisi'           => $item->judul,
                    'alamat'           => $item->alamat,
                    'gaji'             => $item->gaji,
                    'nomor_telepon'    => $item->nomor_telepon,
                    'waktu_kerja'      => $item->waktu_kerja,
                    'jenis_kerja'      => $item->jenis_kerja,
                    'foto'             => $item->foto ? $this->buildFotoUrl($this->getStoragePathFromFoto($item->foto)) : null,
                    'kategori'         => $item->kategori->nama ?? ($item->fitur ?? null),
                    'deskripsi'        => $this->replaceImageUrlsInHtml($item->deskripsi),
                    'created_at'       => $item->created_at,
                    'updated_at'       => $item->updated_at,
                ];
            });

            return response()->json($data, 200);
        }

        $paginator = $query->orderByDesc('created_at')->paginate(10);
        $paginator->getCollection()->transform(function ($item) {
            return [
                'id'               => $item->id,
                'Nama Perusahaan'  => $item->name,
                'Posisi'           => $item->judul,
                'alamat'           => $item->alamat,
                'gaji'             => $item->gaji,
                'nomor_telepon'    => $item->nomor_telepon,
                'waktu_kerja'      => $item->waktu_kerja,
                'jenis_kerja'      => $item->jenis_kerja,
                'foto'             => $item->foto ? $this->buildFotoUrl($this->getStoragePathFromFoto($item->foto)) : null,
                'kategori'         => $item->kategori->nama ?? ($item->fitur ?? null),
                'deskripsi'        => $this->replaceImageUrlsInHtml($item->deskripsi),
                'created_at'       => $item->created_at,
                'updated_at'       => $item->updated_at,
            ];
        });

        return response()->json($paginator, 200);
    }

    /**
     * API: daftar kategori untuk fitur = 'info kerja'
     * - jika tabel kategoris punya data, pakai itu
     * - jika tidak ada, fallback ambil distinct fitur dari tabel info_kerja
     * - gabungkan kedua sumber agar front-end dapat semua opsi
     */
    public function kategoriList()
    {
        // 1) ambil dari tabel kategoris
        $cats = Kategori::where('fitur', 'info kerja')->orderBy('nama')->get(['id','nama','fitur']);

        // jika ada, kumpulkan dulu
        $result = collect();
        if ($cats->isNotEmpty()) {
            $result = $cats->map(function ($c) {
                return [
                    'id' => $c->id,
                    'nama' => $c->nama,
                    'fitur' => $c->fitur,
                ];
            });
        }

        // 2) fallback / tambahan: ambil distinct fitur dari InfoKerja table (kolom 'fitur')
        $distinctFitur = InfoKerja::query()
            ->whereNotNull('fitur')
            ->selectRaw('LOWER(TRIM(fitur)) as fitur_norm, fitur')
            ->groupBy('fitur_norm', 'fitur')
            ->pluck('fitur')
            ->filter(fn($v) => !is_null($v) && trim($v) !== '')
            ->unique()
            ->values();

        // ubah distinct fitur jadi bentuk kategori (id => null)
        $fromFitur = $distinctFitur->map(function ($f) {
            return [
                'id' => null,
                'nama' => $f,
                'fitur' => 'info kerja',
            ];
        });

        // gabungkan, tapi hindari duplicate nama (case-insensitive)
        $combined = collect();
        // pertama, push existing kategori (lowercase key)
        $seen = [];
        foreach ($result as $r) {
            $key = Str::lower(trim($r['nama'] ?? ($r['fitur'] ?? '')));
            if ($key === '') continue;
            $seen[$key] = true;
            $combined->push($r);
        }
        // lalu push fitur-derived yang belum ada
        foreach ($fromFitur as $ff) {
            $key = Str::lower(trim($ff['nama']));
            if ($key === '') continue;
            if (!isset($seen[$key])) {
                $combined->push($ff);
                $seen[$key] = true;
            }
        }

        return response()->json([
            'success' => true,
            'count' => $combined->count(),
            'categories' => $combined->values(),
        ], 200);
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . preg_replace('/\s+/', '', $file->getClientOriginalName());

            $path = $file->storeAs('uploads', $filename, 'public');
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

    protected function logAktivitas($pesan)
    {
        if (auth()->check()) {
            Aktivitas::create([
                'user_id' => auth()->id(),
                'tipe' => 'kerja',
                'keterangan' => $pesan,
            ]);
        }
    }

    protected function logNotifikasi($pesan)
    {
        NotifikasiAktivitas::create([
            'keterangan' => $pesan,
            'dibaca' => false,
            'url' => route('admin.kerja.info.index')
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
        return ltrim($foto,'/');
    }
}