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
use Illuminate\Database\Eloquent\Builder;

class PasarController extends Controller
{

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

        if ($request->hasFile('foto')) {
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

    public function destroy($id)
    {
        $pasar = Pasar::findOrFail($id);

        // Hapus foto jika ada
        if ($pasar->foto && Storage::disk('public')->exists($pasar->foto)) {
            Storage::disk('public')->delete($pasar->foto);
        }

        $pasar->delete();

        $this->logAktivitas("Lokasi Pasar telah dihapus");
        $this->logNotifikasi("Lokasi Pasar telah dihapus");

        return redirect()->route('admin.pasar.tempat.index')
            ->with('success', 'Lokasi pasar berhasil dihapus!');
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

    public function showTempatWeb($id)
    {
        $data = Pasar::with('kategori')->findOrFail($id);
        return view('admin.pasar.tempat.show', compact('data'));
    }

    /**
     * Endpoint baru: ambil semua kategori terkait lokasi pasar
     * Bisa dipanggil dari Flutter untuk mengisi pilihan filter.
     *
     * Route contoh (API):
     * GET /api/pasar/kategori
     *
     * Response: array object { id, nama, fitur }
     */
    public function categories(Request $request)
    {
        // Ambil kategori yang berhubungan dengan fitur 'lokasi pasar'
        $kategoriPasar = Kategori::where('fitur', 'lokasi pasar')
            ->orderBy('nama')
            ->get(['id', 'nama', 'fitur']);

        // Jika ingin menambahkan jumlah item per kategori, bisa dihitung di sini (opsional).
        // Untuk sekarang kembalikan list kategori sederhana.
        return response()->json([
            'success' => true,
            'count' => $kategoriPasar->count(),
            'categories' => $kategoriPasar,
        ], 200);
    }

    /**
     * Helper: cek apakah request mengandung parameter filter.
     * Hanya treat sebagai filter jika ada salah satu key filter yang meaningful.
     * Param 'page' / 'per_page' / 'sort' saja tidak dianggap filter.
     */
    private function requestHasFilter(Request $request): bool
    {
        $filterKeys = [
            'fitur',
            'kategori',
            'search',
            'q',
            'name',
            'address'
        ];

        foreach ($filterKeys as $k) {
            if ($request->filled($k) || $request->has($k)) {
                return true;
            }
        }

        // Jika ada query keys selain pagination/sort, treat as filter.
        $ignore = ['page', 'per_page', 'sort', 'order'];
        foreach ($request->query() as $key => $val) {
            if (!in_array($key, $ignore)) {
                return true;
            }
        }

        return false;
    }

    /**
     * applySmartSearch:
     * - $columns: kolom pada tabel utama (mis. ['name','address','fitur'])
     * - $relations: array relasi => kolom (tidak digunakan disini, tetapi ada untuk konsistensi)
     * - perilaku:
     *    * support single-char search (prefix) dan longer token -> prefix prioritas, lalu contains
     *    * pemisahan token (spasi) => semua token harus match (AND antar token), tetapi setiap token bisa match di kolom manapun (OR antar kolom)
     *    * menambahkan ORDER BY relevansi: prefix matches lebih tinggi dari contains
     */
    private function applySmartSearch(Builder $query, string $text, array $columns = [], array $secondary = [], array $relations = [])
    {
        $text = trim(mb_strtolower($text));
        if ($text === '') return;

        // tokens: split by whitespace
        $tokens = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        if (!$tokens || count($tokens) === 0) return;

        // WHERE: for each token require at least one column or relation to match (AND across tokens)
        $query->where(function ($q) use ($tokens, $columns, $relations) {
            foreach ($tokens as $tok) {
                $tok = trim($tok);
                if ($tok === '') continue;

                $q->where(function ($q2) use ($tok, $columns, $relations) {
                    // match in main columns (contains)
                    foreach ($columns as $col) {
                        $q2->orWhereRaw("LOWER($col) LIKE ?", ["%{$tok}%"]);
                    }

                    // also check relations via orWhereHas (keberadaan relasi tetap didukung)
                    foreach ($relations as $rel => $relCol) {
                        $q2->orWhereHas($rel, function ($q3) use ($tok, $relCol) {
                            $q3->whereRaw("LOWER($relCol) LIKE ?", ["%{$tok}%"]);
                        });
                    }
                });
            }
        });

        // ORDER BY relevance
        // Build CASE expression: 0 = any prefix match, 1 = any contains (we already filtered to contains),
        // after that append secondary ordering.
        $prefixParts = [];
        $containsParts = [];
        $bindings = [];

        foreach ($tokens as $tok) {
            $tok = trim($tok);
            if ($tok === '') continue;

            $perTokenPrefix = [];
            $perTokenContains = [];

            foreach ($columns as $col) {
                $perTokenPrefix[] = "LOWER($col) LIKE ?";
                $bindings[] = $tok . '%';
                $perTokenContains[] = "LOWER($col) LIKE ?";
                $bindings[] = '%' . $tok . '%';
            }

            if (!empty($perTokenPrefix)) {
                $prefixParts[] = '(' . implode(' OR ', $perTokenPrefix) . ')';
            }
            if (!empty($perTokenContains)) {
                $containsParts[] = '(' . implode(' OR ', $perTokenContains) . ')';
            }
        }

        $prefixExpr = count($prefixParts) ? implode(' OR ', $prefixParts) : '0=1';
        $containsExpr = count($containsParts) ? implode(' OR ', $containsParts) : '0=1';

        $caseExpr = "(CASE WHEN ({$prefixExpr}) THEN 0 WHEN ({$containsExpr}) THEN 1 ELSE 2 END)";

        // Apply ordering by relevance - pass bindings
        $query->orderByRaw($caseExpr, $bindings);

        // apply secondary ordering
        foreach ($secondary as $sec) {
            if (is_array($sec) && count($sec) >= 2) {
                $col = $sec[0];
                $dir = strtolower($sec[1]) === 'asc' ? 'asc' : 'desc';
                $query->orderBy($col, $dir);
            }
        }
    }

    /**
     * show:
     * - numeric $id -> single item
     * - non-numeric $id:
     *     - if 'all' -> return all matching (no pagination)
     *     - if 'search' -> treat as search-path and run search using q/search query param
     *     - otherwise treat as fitur path filter (e.g. /tempat-pasar/pasar-tradisional) and paginate
     * - query ?fitur=... or ?kategori=... -> paginate(10)
     * - ?search=... or ?q=... -> paginate(10)
     * - other filters (non-pagination) -> get() (legacy)
     * - no filter -> paginate(10)
     */
    public function show(Request $request, $id = null)
    {
        $isAllPath = false;
        $isSearchPath = false;

        // if $id present and non-numeric, handle specially
        if ($id !== null && !is_numeric($id)) {
            $decoded = urldecode($id);

            // if path is 'all' -> special "get all" behavior
            if (strtolower($decoded) === 'all') {
                $isAllPath = true;
            } elseif (strtolower($decoded) === 'search') {
                // treat as explicit search path: /tempat-pasar/search?q=...
                $isSearchPath = true;
            } else {
                // treat as fitur path filter (path-based)
                $request->merge(['fitur' => $decoded, 'kategori' => $decoded]);
            }
        }

        // If numeric id -> return single item (unchanged)
        if ($id !== null && is_numeric($id)) {
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
        }

        // Build base query
        $query = Pasar::query();

        // If request is path /tempat-pasar/search -> handle smart search regardless of fitur merging above
        if ($isSearchPath) {
            $text = $request->query('q', $request->query('search', ''));
            // if no search term provided, return empty paginated structure to indicate no results for empty search path
            if (trim($text) === '') {
                // return empty paginator (page meta) for consistency
                $empty = (object) [
                    'current_page' => 1,
                    'data' => [],
                    'first_page_url' => url('/api/tempat-pasar/search?page=1'),
                    'from' => null,
                    'last_page' => 1,
                    'last_page_url' => url('/api/tempat-pasar/search?page=1'),
                    'links' => [
                        ['url' => null, 'label' => '&laquo; Previous', 'active' => false],
                        ['url' => url('/api/tempat-pasar/search?page=1'), 'label' => '1', 'active' => true],
                        ['url' => null, 'label' => 'Next &raquo;', 'active' => false],
                    ],
                    'next_page_url' => null,
                    'path' => url('/api/tempat-pasar/search'),
                    'per_page' => 10,
                    'prev_page_url' => null,
                    'to' => null,
                    'total' => 0,
                ];

                return response()->json($empty, 200);
            }

            $searchQuery = Pasar::query();
            $this->applySmartSearch($searchQuery, $text, ['name', 'address', 'fitur'], [['created_at', 'asc']], []);

            // if explicit all requested as path /tempat-pasar/search/all or ?all=1 - but path won't carry 'all' here; check query
            if ($request->query('all') === '1') {
                $data = $searchQuery->get()->map(function ($item) {
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

            $paginator = $searchQuery->paginate(10);

            $paginator->getCollection()->transform(function ($item) {
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

            return response()->json($paginator, 200);
        }

        // Accept both 'fitur' and 'kategori' as filter keys
        $filter = $request->query('fitur', $request->query('kategori', null));

        // If fitur/kategori provided -> filter (then either paginate or get all depending)
        if ($filter !== null && $filter !== '') {
            $textFilter = strtolower($filter);
            $query->where(function ($q) use ($textFilter) {
                $q->whereRaw('LOWER(fitur) LIKE ?', ["%$textFilter%"]);
            });

            // If search/q is also present, apply smart search inside the filtered results
            if ($request->filled('search') || $request->filled('q')) {
                $text = $request->query('search', $request->query('q'));
                $this->applySmartSearch($query, $text, ['name', 'address', 'fitur'], [['created_at', 'asc']], []);
            }

            if ($isAllPath || $request->query('all') === '1') {
                // return all matching (no pagination)
                $data = $query->orderBy('created_at', 'asc')->get()->map(function ($item) {
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

            // otherwise paginate (10 per page)
            $paginator = $query->orderBy('created_at', 'asc')->paginate(10);

            $paginator->getCollection()->transform(function ($item) {
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

            return response()->json($paginator, 200);
        }

        // SEARCH without fitur -> smart search across name/address/fitur
        if ($request->filled('search') || $request->filled('q')) {
            $text = $request->query('search', $request->query('q'));

            $searchQuery = Pasar::query();
            $this->applySmartSearch($searchQuery, $text, ['name', 'address', 'fitur'], [['created_at', 'asc']], []);

            if ($isAllPath || $request->query('all') === '1') {
                $data = $searchQuery->get()->map(function ($item) {
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

            $paginator = $searchQuery->paginate(10);

            $paginator->getCollection()->transform(function ($item) {
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

            return response()->json($paginator, 200);
        }

        // other filters -> legacy get(), order by created_at asc
        if ($this->requestHasFilter($request)) {
            // minimal known filters (kept simple)
            if ($request->filled('tanggal')) {
                $query->where('tanggal', $request->query('tanggal'));
            }

            // if 'all' requested via path or query, send all; otherwise fall back to get all since it's "other filters"
            $data = $query->orderBy('created_at', 'asc')->get()->map(function ($item) {
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

        // default -> paginate 10 ordered by created_at asc
        $paginator = $query->orderBy('created_at', 'asc')->paginate(10);

        $paginator->getCollection()->transform(function ($item) {
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

        return response()->json($paginator, 200);
    }

    protected $aktivitasTipe = 'pasar';

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
            'url'          => route('admin.pasar.tempat.index'),
            'role'         => $user->role,
            'id_instansi'  => $user->id_instansi,
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
