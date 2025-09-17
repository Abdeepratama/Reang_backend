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

    /**
     * Helper: cek apakah request mengandung parameter filter.
     * Hanya treat sebagai filter jika ada salah satu key filter yang meaningful.
     * Param 'page' / 'per_page' / 'sort' saja tidak dianggap filter.
     */
    private function requestHasFilter(Request $request): bool
    {
        $filterKeys = [
            'fitur', 'jenis', 'search', 'q', 'kategori', 'judul', 'tanggal', 'lokasi', 'alamat'
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
     * showtempat:
     * - numeric $id -> single item
     * - non-numeric $id -> treat as fitur path filter (e.g. /tempat-ibadah/masjid) and paginate
     * - query ?fitur=... or ?jenis=... -> paginate(10)
     * - ?search=... or ?q=... -> paginate(10)
     * - other filters (non-pagination) -> get() (legacy)
     * - no filter -> paginate(10)
     *
     * NOTE: Tempat Ibadah ordering:
     *   - ALL (get)  => ORDER BY created_at ASC (terlama di atas)
     *   - Paginated results (fitur/search/default) => ORDER BY created_at ASC (terlama di atas)
     */
    public function showtempat(Request $request, $id = null)
    {
        // If path param present and non-numeric, treat as fitur filter (path-based)
        if ($id !== null && !is_numeric($id)) {
            $filterValue = urldecode($id);
            $request->merge(['fitur' => $filterValue, 'kategori' => $filterValue]);
        }

        // If numeric id -> return single item
        if ($id !== null && is_numeric($id)) {
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

        $query = Ibadah::with('kategori');

        // FEATURE: if fitur/jenis provided -> filter and paginate 10 (terlama atas = ASC)
        $filter = $request->query('fitur', $request->query('jenis', null));
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

            $paginator = $query->orderBy('created_at', 'asc')->paginate(10);

            $paginator->getCollection()->transform(fn($item) => [
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

            return response()->json($paginator, 200);
        }

        // SEARCH: paginated 10 (terlama atas = ASC)
        // support both 'search' and 'q' keys
        if ($request->filled('search') || $request->filled('q')) {
            $text = strtolower($request->query('search', $request->query('q')));
            $searchQuery = Ibadah::with('kategori')->where(function ($q) use ($text) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%$text%"])
                  ->orWhereRaw('LOWER(address) LIKE ?', ["%$text%"])
                  ->orWhereHas('kategori', fn($q2) => $q2->whereRaw('LOWER(nama) LIKE ?', ["%$text%"]));
            });

            $paginator = $searchQuery->orderBy('created_at', 'asc')->paginate(10);

            $paginator->getCollection()->transform(fn($item) => [
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

            return response()->json($paginator, 200);
        }

        // If there are other filters (non-pagination keys) -> legacy: return all matching (keeps old behavior)
        if ($this->requestHasFilter($request)) {
            $data = $query->orderBy('created_at', 'asc')->get()->map(fn($item) => [
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

        // Default listing: paginated 10 (terlama atas = ASC)
        $paginator = $query->orderBy('created_at', 'asc')->paginate(10);

        $paginator->getCollection()->transform(fn($item) => [
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

        return response()->json($paginator, 200);
    }

    /**
     * New: GET ALL (no pagination) for tempat-ibadah
     *
     * Route example:
     *   GET /api/tempat-ibadah/all?fitur=masjid
     *
     * Behavior:
     *  - supports same filters as showtempat but returns all results (no pagination)
     *  - ordering: created_at ASC (terlama di atas) — same behavior as existing GET-all in prior code
     */
    public function showtempatAll(Request $request)
    {
        $query = Ibadah::with('kategori');

        // fitur / jenis filter
        $filter = $request->query('fitur', $request->query('jenis', null));
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

            $data = $query->orderBy('created_at', 'asc')->get()->map(fn($item) => [
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

        // search (q/search) -> return all matching ordered ASC
        if ($request->filled('search') || $request->filled('q')) {
            $text = strtolower($request->query('search', $request->query('q')));
            $searchQuery = Ibadah::with('kategori')->where(function ($q) use ($text) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%$text%"])
                  ->orWhereRaw('LOWER(address) LIKE ?', ["%$text%"])
                  ->orWhereHas('kategori', fn($q2) => $q2->whereRaw('LOWER(nama) LIKE ?', ["%$text%"]));
            });

            $data = $searchQuery->orderBy('created_at', 'asc')->get()->map(fn($item) => [
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

        // other filters -> legacy get() ordered ASC
        if ($this->requestHasFilter($request)) {
            // apply minimal known filters
            if ($request->filled('tanggal')) {
                $query->where('tanggal', $request->query('tanggal'));
            }

            $data = $query->orderBy('created_at', 'asc')->get()->map(fn($item) => [
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

        // default -> get all ordered ASC
        $data = $query->orderBy('created_at', 'asc')->get()->map(fn($item) => [
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

    /**
     * showTempatWeb (view)
     */
    public function showTempatWeb($id)
    {
        $data = Ibadah::with('kategori')->findOrFail($id);
        return view('admin.ibadah.tempat.show', compact('data'));
    }

    public function infoIndex()
    {
        $infoItems = InfoKeagamaan::all();
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

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fotoName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('foto_ibadah', $fotoName, 'public');
        }

        InfoKeagamaan::create([
            'foto' => $path,
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
            if ($item->foto) {
                Storage::disk('public')->delete($item->foto);
            }
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
                'judul' => $loc->judul,
                'alamat' => $loc->alamat,
                'latitude' => $loc->latitude,
                'longitude' => $loc->longitude,
                'foto' => $loc->foto ? asset('storage/' . $loc->foto) : null,
                'fitur' => $loc->fitur,
                'rating' => $loc->rating,
            ];
        });

        return view('admin.ibadah.info.map', compact('lokasi'));
    }

    /**
     * infoshow:
     * - numeric $id -> single item
     * - non-numeric $id -> treat as kategori path filter (e.g. /event-agama/islam) and paginate
     * - query ?kategori=... or ?fitur=... -> paginate(10)
     * - ?search=... or ?q=... -> paginate(10)
     * - other filters -> get() (legacy)
     * - no filter -> paginate(10)
     *
     * NOTE: Event/Info ordering:
     *   - ALL (get)  => ORDER BY tanggal DESC (terbaru di atas)
     *   - Paginated results (kategori/search/default) => ORDER BY tanggal DESC (terbaru di atas)
     */
    public function infoshow(Request $request, $id = null)
    {
        // if $id non-numeric treat as kategori path filter
        if ($id !== null && !is_numeric($id)) {
            $filterValue = urldecode($id);
            $request->merge(['kategori' => $filterValue, 'fitur' => $filterValue]);
        }

        // numeric id -> single
        if ($id !== null && is_numeric($id)) {
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
        }

        $query = InfoKeagamaan::with('kategori');

        // kategori/fitur provided -> filter and paginate 10 (latest first by tanggal)
        $filter = $request->query('kategori', $request->query('fitur', null));
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

            $paginator = $query->orderByDesc('tanggal')->paginate(10);

            $paginator->getCollection()->transform(function ($item) {
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

            return response()->json($paginator, 200);
        }

        // search -> paginated 10 ordered by tanggal desc (latest first)
        // support both 'search' and 'q'
        if ($request->filled('search') || $request->filled('q')) {
            $text = strtolower($request->query('search', $request->query('q')));
            $searchQuery = InfoKeagamaan::with('kategori')->where(function ($q) use ($text) {
                $q->whereRaw('LOWER(judul) LIKE ?', ["%$text%"])
                  ->orWhereRaw('LOWER(lokasi) LIKE ?', ["%$text%"])
                  ->orWhereRaw('LOWER(alamat) LIKE ?', ["%$text%"])
                  ->orWhereHas('kategori', fn($q2) => $q2->whereRaw('LOWER(nama) LIKE ?', ["%$text%"]));
            });

            $paginator = $searchQuery->orderByDesc('tanggal')->paginate(10);

            $paginator->getCollection()->transform(function ($item) {
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

            return response()->json($paginator, 200);
        }

        // other filters -> legacy get(), order by tanggal desc (latest first)
        if ($this->requestHasFilter($request)) {
            if ($request->filled('tanggal')) {
                $query->where('tanggal', $request->query('tanggal'));
            }

            $data = $query->orderByDesc('tanggal')->get()->map(function ($item) {
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

        // default -> paginate 10 ordered by tanggal desc (latest first)
        $paginator = InfoKeagamaan::with('kategori')->orderByDesc('tanggal')->paginate(10);

        $paginator->getCollection()->transform(function ($item) {
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

        return response()->json($paginator, 200);
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

    private function getStoragePathFromFoto($foto)
    {
        if (!$foto) return null;

        if (strpos($foto, 'http://') !== 0 && strpos($foto, 'https://') !== 0) {
            return $foto;
        }

        if (preg_match('#/storage/(.+)$#', $foto, $matches)) {
            return $matches[1];
        }

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

    private function buildFotoUrl($storagePath)
    {
        if (!$storagePath) return null;
        return request()->getSchemeAndHttpHost() . '/storage/' . ltrim($storagePath, '/');
    }

    private function replaceImageUrlsInHtml($content)
    {
        if (!$content) return $content;

        return preg_replace_callback('/(<img\b[^>]\bsrc\s=\s*[\'"])([^\'"]+)([\'"][^>]*>)/i', function ($m) {
            $prefix = $m[1];
            $src = $m[2];
            $suffix = $m[3];

            if (preg_match('/^data:/i', $src)) {
                return $m[0];
            }

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
                return $m[0];
            }

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