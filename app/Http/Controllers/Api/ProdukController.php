<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    /**
     * Format path foto menjadi URL penuh (mengikuti domain).
     *
     * - Jika foto kosong -> null
     * - Jika sudah URL (http/https) -> kembalikan apa adanya
     * - Lainnya -> gunakan Storage::url() lalu url() agar mengikuti APP_URL
     */
    protected function formatFotoUrl($fotoPath)
    {
        if (empty($fotoPath)) {
            return null;
        }

        // Jika sudah URL, kembalikan apa adanya
        if (Str::startsWith($fotoPath, ['http://', 'https://'])) {
            return $fotoPath;
        }

        // Jika path relatif, gunakan Storage::url() lalu url() untuk mendapatkan domain penuh
        try {
            $storageUrl = Storage::url($fotoPath); // -> '/storage/produk/xxx.jpg'
            return url($storageUrl); // -> 'https://domain.com/storage/produk/xxx.jpg'
        } catch (\Throwable $e) {
            return $fotoPath;
        }
    }




    // 🔹 GET: /api/produk/{id}
    public function show($id)
    {
        $produk = DB::table('produk')->where('id', $id)->first();

        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        if (isset($produk->foto)) {
            $produk->foto = $this->formatFotoUrl($produk->foto);
        } else {
            $produk->foto = null;
        }

        return response()->json($produk);
    }

    // 🔹 GET: /api/produk/toko/{id_toko}
    public function showByToko($id_toko)
    {
        $produk = DB::table('produk')
            ->where('id_toko', $id_toko)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($produk->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada produk untuk toko ini'
            ], 404);
        }

        $produk->transform(function ($item) {
            if (isset($item->foto)) {
                $item->foto = $this->formatFotoUrl($item->foto);
            } else {
                $item->foto = null;
            }
            return $item;
        });

        return response()->json([
            'status' => true,
            'message' => 'Daftar produk berdasarkan toko',
            'data' => $produk
        ]);
    }

    // 🔹 POST: /api/produk
    public function store(Request $request)
    {
        // Terima 'foto' sebagai nullable (bisa file atau string)
        $data = $request->validate([
            'id_toko' => 'required|integer|exists:toko,id',
            'nama' => 'required|string|max:255',
            'foto' => 'nullable', // tidak dipaksakan string di sini
            'harga' => 'required|numeric',
            'variasi' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'spesifikasi' => 'nullable|string',
            'fitur' => 'nullable|string',
            'stok' => 'required|integer',
        ]);

        // Jika ada file upload pada key 'foto', simpan ke disk public
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            if ($file->isValid()) {
                // Simpan di storage/app/public/produk
                $path = $file->store('produk', 'public'); // ex: 'produk/abcd.jpg'
                $data['foto'] = $path;
            }
        } else {
            // Jika frontend mengirim 'foto' sebagai string path/URL, biarkan apa adanya
            if (isset($data['foto']) && is_string($data['foto']) && $data['foto'] !== '') {
                // tetap simpan string tersebut (mis. 'produk/abc.jpg' atau full URL)
            } else {
                $data['foto'] = null;
            }
        }

        $data['created_at'] = now();
        $data['updated_at'] = now();

        $id = DB::table('produk')->insertGetId($data);

        return response()->json([
            'message' => 'Produk berhasil ditambahkan',
            'id' => $id
        ]);
    }
    public function index(Request $request)
    {
        // 1. Mulai query builder
        $query = DB::table('produk')
            // --- TAMBAHKAN JOIN INI ---
            ->join('toko', 'produk.id_toko', '=', 'toko.id')
            // --- TAMBAHKAN SELECT INI ---
            ->select(
                'produk.*', // Ambil semua kolom dari tabel 'produk'
                'toko.alamat as lokasi' // Ambil 'alamat' dari 'toko' dan namai 'lokasi'
            )
            // --- PERBAIKI INI (Tambahkan 'produk.') ---
            ->orderBy('produk.created_at', 'desc');

        // 3. Tambahkan filter Kategori (fitur) jika ada
        if ($request->has('fitur') && $request->input('fitur') != 'Semua') {
            // --- PERBAIKI INI (Tambahkan 'produk.') ---
            $query->where('produk.fitur', $request->input('fitur'));
        }

        // 4. Tambahkan filter Search (q) jika ada
        if ($request->has('q') && $request->input('q') != '') {
            $searchText = $request->input('q');
            $query->where(function ($q) use ($searchText) {
                // --- PERBAIKI INI (Tambahkan 'produk.') ---
                $q->where('produk.nama', 'like', '%' . $searchText . '%')
                  ->orWhere('produk.deskripsi', 'like', '%' . $searchText . '%');
            });
        }

        // 5. Eksekusi query dengan paginasi (tidak berubah)
        $produk = $query->paginate(15)
                        ->appends($request->query());

        // 6. Format foto (tidak berubah)
        $produk->getCollection()->transform(function ($item) {
            if (isset($item->foto)) {
                $item->foto = $this->formatFotoUrl($item->foto);
            } else {
                $item->foto = null;
            }
            return $item;
        });

        return response()->json($produk);
    }
// =======================================================================
    // --- TAMBAHKAN METODE BARU DI SINI ---
    // =======================================================================
    /**
     * 🔹 GET: /api/produk/kategori/{kategori}
     * Menampilkan produk berdasarkan kategori (fitur) dengan paginasi.
     * Mendukung: /api/produk/kategori/baju?page=2
     * Mendukung: /api/produk/kategori/baju?q=kaos
     */
    public function showByKategori(Request $request, $kategori)
    {
        // 1. Mulai query builder dan FILTER berdasarkan parameter URL
        $query = DB::table('produk')
            ->where('fitur', $kategori) // <-- INI LOGIKA UTAMANYA
            ->orderBy('created_at', 'desc');

        // 2. (BONUS) Tambahkan filter Search (q) jika ada
        if ($request->has('q') && $request->input('q') != '') {
            $searchText = $request->input('q');
            $query->where(function ($q) use ($searchText) {
                $q->where('nama', 'like', '%' . $searchText . '%')
                  ->orWhere('deskripsi', 'like', '%' . $searchText . '%');
            });
        }

        // 3. Eksekusi query dengan paginasi
        $produk = $query->paginate(15)->appends($request->query());

        // 4. Format foto
        $produk->getCollection()->transform(function ($item) {
            if (isset($item->foto)) {
                $item->foto = $this->formatFotoUrl($item->foto);
            } else {
                $item->foto = null;
            }
            return $item;
        });

        return response()->json($produk);
    }
    ///serch suggestions
    public function getSuggestions(Request $request)
    {
        // 1. Validasi input: kita butuh parameter 'q' (query)
        if (!$request->has('q') || $request->input('q') == '') {
            // Jika tidak ada query, kembalikan array kosong
            return response()->json([]);
        }

        $query = $request->input('q');
        
        // Kita cari kata yang 'dimulai dengan' query. Misal: "g%"
        $searchQuery = $query . '%';

        // 2. Cari 7 nama produk unik yang cocok
        $namaSuggestions = DB::table('produk')
            ->where('nama', 'like', $searchQuery)
            ->distinct()
            ->limit(7) // Ambil 7 dari nama
            ->pluck('nama'); // -> ["gitar listrik", "gitar akustik", "gelang pria"]

        // 3. Cari 3 nama kategori (fitur) unik yang cocok
        $fiturSuggestions = DB::table('produk')
            ->where('fitur', 'like', $searchQuery)
            ->distinct()
            ->limit(3) // Ambil 3 dari kategori
            ->pluck('fitur'); // -> ["gelang", "gantungan"]

        // 4. Gabungkan keduanya, pastikan unik, dan ambil total 10
        $allSuggestions = $namaSuggestions->merge($fiturSuggestions)
                                         ->unique() // Hapus duplikat (misal 'baju' ada di nama & fitur)
                                         ->values() // Reset keys array
                                         ->take(10); // Batasi total 10 sugesti

        // 5. Kembalikan sebagai JSON array of strings
        return response()->json($allSuggestions);
    }
    

    // 🔹 PUT: /api/produk/{id}
    public function update(Request $request, $id)
    {
        $produk = DB::table('produk')->where('id', $id)->first();

        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        $data = $request->validate([
            'id_toko' => 'sometimes|integer|exists:toko,id',
            'nama' => 'sometimes|string|max:255',
            'foto' => 'nullable',
            'harga' => 'sometimes|numeric',
            'variasi' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'spesifikasi' => 'nullable|string',
            'fitur' => 'nullable|string',
            'stok' => 'sometimes|integer',
        ]);

        // Jika ada file upload baru pada key 'foto', simpan dan hapus file lama jika ada
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            if ($file->isValid()) {
                // simpan file baru
                $path = $file->store('produk', 'public'); // 'produk/xxx.jpg'
                $data['foto'] = $path;

                // hapus file lama jika ada
                if (!empty($produk->foto)) {
                    // Produk->foto mungkin berisi full URL atau path relatif.
                    $old = $produk->foto;

                    // Jika full URL yang mengandung '/storage/', ambil bagian setelah '/storage/'
                    if (Str::contains($old, '/storage/')) {
                        $relative = preg_replace('#^https?://[^/]+/storage/#', '', $old);
                        Storage::disk('public')->delete($relative);
                    } else {
                        // Anggap sudah relatif seperti 'produk/xxx.jpg'
                        Storage::disk('public')->delete($old);
                    }
                }
            }
        } else {
            // jika frontend memberi 'foto' string baru (misal mengganti path), simpan string itu
            if (array_key_exists('foto', $data)) {
                if ($data['foto'] === null || $data['foto'] === '') {
                    // jika ingin mengosongkan foto, hapus file lama juga jika ada
                    if (!empty($produk->foto)) {
                        $old = $produk->foto;
                        if (Str::contains($old, '/storage/')) {
                            $relative = preg_replace('#^https?://[^/]+/storage/#', '', $old);
                            Storage::disk('public')->delete($relative);
                        } else {
                            Storage::disk('public')->delete($old);
                        }
                    }
                    $data['foto'] = null;
                } else {
                    // simpan string yang diberikan (asumsikan path relatif atau URL)
                }
            }
        }

        $data['updated_at'] = now();

        DB::table('produk')->where('id', $id)->update($data);

        return response()->json(['message' => 'Produk berhasil diperbarui']);
    }

    // 🔹 DELETE: /api/produk/{id}
    public function destroy($id)
    {
        $produk = DB::table('produk')->where('id', $id)->first();

        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        // Hapus file foto dari storage jika ada
        if (!empty($produk->foto)) {
            $old = $produk->foto;
            if (Str::contains($old, '/storage/')) {
                $relative = preg_replace('#^https?://[^/]+/storage/#', '', $old);
                Storage::disk('public')->delete($relative);
            } else {
                Storage::disk('public')->delete($old);
            }
        }

        DB::table('produk')->where('id', $id)->delete();

        return response()->json(['message' => 'Produk berhasil dihapus']);
    }
}