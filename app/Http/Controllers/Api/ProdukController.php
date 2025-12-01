<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProdukController extends Controller
{
    /**
     * Format path foto menjadi URL penuh.
     *
     * @param string|null $fotoPath
     * @return string|null
     */
    protected function formatFotoUrl($fotoPath)
    {
        if (empty($fotoPath)) {
            return null;
        }

        // Jika sudah URL penuh, kembalikan apa adanya
        if (Str::startsWith($fotoPath, ['http://', 'https://'])) {
            return $fotoPath;
        }

        try {
            // Storage::url mengembalikan path publik (mis. /storage/...)
            $storageUrl = Storage::url($fotoPath);
            return url($storageUrl);
        } catch (\Throwable $e) {
            // Jika ada kesalahan, fallback ke path aslinya
            return $fotoPath;
        }
    }

    /**
     * Helper internal untuk menghapus file dari storage.
     * Menerima baik URL penuh maupun path relatif.
     *
     * @param string|null $path
     * @return void
     */
    protected function hapusFileStorage($path)
    {
        if (empty($path)) {
            return;
        }

        try {
            // Jika path mengandung '/storage/', ekstrak path relatif setelah itu
            if (Str::contains($path, '/storage/')) {
                $relativePath = preg_replace('#^https?://[^/]+/storage/#', '', $path);
                Storage::disk('public')->delete($relativePath);
            } else {
                // Anggap sudah path relatif (mis. 'produk/xxx.jpg' atau 'produk_galeri/yyy.jpg')
                Storage::disk('public')->delete($path);
            }
        } catch (\Exception $e) {
            // Abaikan error saat menghapus file (mis. file tidak ada)
        }
    }

    // 🔹 GET: /api/produk/{id}
    public function show($id)
    {
        $produk = DB::table('produk')->where('id', $id)->first();

        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        // Ambil varian
        $produk->varians = DB::table('produk_varian')->where('id_produk', $id)->get();

        // Ambil galeri foto (jika ada) dan format URL
        $produk->galeri_foto = DB::table('produk_foto')
            ->where('id_produk', $id)
            ->get()
            ->map(function ($foto) {
                $foto->path_foto = $this->formatFotoUrl($foto->path_foto);
                return $foto;
            });

        // Format foto utama jika ada
        if (isset($produk->foto)) {
            $produk->foto = $this->formatFotoUrl($produk->foto);
        }

        return response()->json($produk);
    }

    // 🔹 GET: /api/produk/toko/{id_toko}
    public function showByToko($id_toko)
    {
        $produk = DB::table('produk')
            ->where('id_toko', $id_toko)
            ->select(
                'produk.*',
                
                // 1. Subquery Terjual (Tetap ada)
                DB::raw('(
                    SELECT COALESCE(SUM(dt.jumlah), 0)
                    FROM detail_transaksi dt
                    JOIN transaksi t ON dt.no_transaksi = t.no_transaksi COLLATE utf8mb4_unicode_ci
                    WHERE dt.id_produk = produk.id AND t.status = "selesai"
                ) as terjual'),

                // 2. [BARU] Hitung Rata-rata Rating
                DB::raw('(
                    SELECT COALESCE(AVG(rating), 0)
                    FROM ulasan
                    WHERE id_produk = produk.id
                ) as rating_rata_rata'),

                // 3. [BARU] Hitung Jumlah Ulasan
                DB::raw('(
                    SELECT COUNT(id)
                    FROM ulasan
                    WHERE id_produk = produk.id
                ) as jumlah_ulasan')
            )
            ->orderBy('created_at', 'desc')
            ->get();

        if ($produk->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada produk untuk toko ini'
            ], 404);
        }

        // ... (Sisa logika untuk varian dan galeri TETAP SAMA) ...
        $produkIds = $produk->pluck('id');

        $allVarians = DB::table('produk_varian')
            ->whereIn('id_produk', $produkIds)
            ->get()
            ->groupBy('id_produk');

        $allGaleri = DB::table('produk_foto')
            ->whereIn('id_produk', $produkIds)
            ->get()
            ->groupBy('id_produk');

        $produk->transform(function ($item) use ($allVarians, $allGaleri) {
            $item->foto = isset($item->foto) ? $this->formatFotoUrl($item->foto) : null;
            $item->varians = $allVarians[$item->id] ?? [];
            $item->galeri_foto = collect($allGaleri[$item->id] ?? [])->map(function ($foto) {
                $foto->path_foto = $this->formatFotoUrl($foto->path_foto);
                return $foto;
            });
            
            // Pastikan terjual dikirim sebagai integer
            $item->terjual = (int) $item->terjual; 
            
            return $item;
        });

        return response()->json([
            'status' => true,
            'message' => 'Daftar produk berhasil diambil',
            'data' => $produk
        ]);
    }

    // 🔹 POST: /api/produk/store
    public function store(Request $request)
    {
        // Validasi input
        $dataProduk = $request->validate([
            'id_toko' => 'required|integer|exists:toko,id',
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|file|image|max:2048',
            'deskripsi' => 'nullable|string',
            'spesifikasi' => 'nullable|string',
            'fitur' => 'nullable|string',

            'varians' => 'required|array|min:1',
            'varians.*.nama_varian' => 'required|string|max:100',
            'varians.*.harga' => 'required|numeric|min:0',
            'varians.*.stok' => 'required|integer|min:0',

            'galeri_foto' => 'nullable|array',
            'galeri_foto.*' => 'file|image|max:2048',
        ]);

        $fotoPath = null;
        $galeriPaths = [];

        // Simpan foto utama jika ada
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('produk', 'public');
        }

        DB::beginTransaction();
        try {
            // Simpan produk induk
            $produkId = DB::table('produk')->insertGetId([
                'id_toko' => $dataProduk['id_toko'],
                'nama' => $dataProduk['nama'],
                'deskripsi' => $dataProduk['deskripsi'] ?? null,
                'spesifikasi' => $dataProduk['spesifikasi'] ?? null,
                'fitur' => $dataProduk['fitur'] ?? null,
                'foto' => $fotoPath,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Simpan varian
            $varianData = [];
            foreach ($request->varians as $varian) {
                $varianData[] = [
                    'id_produk' => $produkId,
                    'nama_varian' => $varian['nama_varian'],
                    'harga' => $varian['harga'],
                    'stok' => $varian['stok'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            DB::table('produk_varian')->insert($varianData);

            // Simpan galeri foto (jika ada)
            $galeriInsertData = [];
            if ($request->hasFile('galeri_foto')) {
                foreach ($request->file('galeri_foto') as $file) {
                    if ($file->isValid()) {
                        $path = $file->store('produk_galeri', 'public');
                        $galeriPaths[] = $path;
                        $galeriInsertData[] = [
                            'id_produk' => $produkId,
                            'path_foto' => $path,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
                if (!empty($galeriInsertData)) {
                    DB::table('produk_foto')->insert($galeriInsertData);
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Produk dan varian berhasil ditambahkan',
                'id' => $produkId
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            // Hapus file yang sudah tersimpan (rollback storage)
            if ($fotoPath) {
                $this->hapusFileStorage($fotoPath);
            }
            foreach ($galeriPaths as $p) {
                $this->hapusFileStorage($p);
            }

            return response()->json(['error' => 'Gagal menyimpan produk: ' . $e->getMessage()], 500);
        }
    }

    // 🔹 GET: /api/produk/show (paginate)
public function index(Request $request)
    {
        try {
            // 1. Query Dasar
            $query = DB::table('produk');

            // Filter Kategori
            if ($request->has('fitur') && $request->fitur != 'Semua' && $request->fitur != '') {
                $query->where('fitur', $request->fitur);
            }

            // Filter Pencarian
            if ($request->has('search') && $request->search != '') {
                $query->where('nama', 'like', '%' . $request->search . '%');
            }

            // 2. Select Data
            $produk = $query->select(
                'produk.*',

                // Subquery Terjual
                DB::raw('(
                    SELECT COALESCE(SUM(dt.jumlah), 0)
                    FROM detail_transaksi dt
                    JOIN transaksi t ON dt.no_transaksi = t.no_transaksi COLLATE utf8mb4_unicode_ci
                    WHERE dt.id_produk = produk.id AND t.status = "selesai"
                ) as terjual'),

                // Subquery Rating (Gunakan COLLATE jika perlu, tapi biasanya aman untuk ID)
                DB::raw('(
                    SELECT COALESCE(AVG(rating), 0)
                    FROM ulasan
                    WHERE id_produk = produk.id
                ) as rating_rata_rata'),

                // Subquery Jumlah Ulasan
                DB::raw('(
                    SELECT COUNT(id)
                    FROM ulasan
                    WHERE id_produk = produk.id
                ) as jumlah_ulasan')
            )
            ->orderBy('created_at', 'desc')
            ->paginate(10); 

            // 3. Format Foto & Varian
            // Ambil ID produk dari halaman ini saja (optimasi)
            $produkIds = collect($produk->items())->pluck('id');
            
            $allVarians = DB::table('produk_varian')->whereIn('id_produk', $produkIds)->get()->groupBy('id_produk');
            $allGaleri = DB::table('produk_foto')->whereIn('id_produk', $produkIds)->get()->groupBy('id_produk');

            // Transform data
            $produk->getCollection()->transform(function ($item) use ($allVarians, $allGaleri) {
                $item->foto = $item->foto ? $this->formatFotoUrl($item->foto) : null;
                $item->varians = $allVarians[$item->id] ?? [];
                $item->galeri_foto = collect($allGaleri[$item->id] ?? [])->map(function ($foto) {
                    $foto->path_foto = $this->formatFotoUrl($foto->path_foto);
                    return $foto;
                });
                
                // Casting tipe data
                $item->terjual = (int) $item->terjual;
                $item->rating_rata_rata = (double) $item->rating_rata_rata;
                $item->jumlah_ulasan = (int) $item->jumlah_ulasan;

                return $item;
            });

            // [PERBAIKAN UTAMA: RETURN LANGSUNG]
            // Agar Flutter bisa membaca key 'data' berisi List produk
            return response()->json($produk);

        } catch (\Exception $e) {
            // Jika error, tampilkan pesan errornya biar tau kenapa
            return response()->json([
                'message' => 'Error Backend: ' . $e->getMessage()
            ], 500);
        }
    }

    // 🔹 GET: /api/produk/kategori/{kategori}
    public function showByKategori(Request $request, $kategori)
    {
        $query = DB::table('produk')
            ->join('toko', 'produk.id_toko', '=', 'toko.id')
            ->select('produk.*', 'toko.alamat as lokasi', 'toko.nama as nama_toko')
            ->where('fitur', $kategori)
            ->orderBy('produk.created_at', 'desc');

        // optional search 'q'
        if ($request->has('q') && $request->input('q') != '') {
            $searchText = $request->input('q');
            $query->where(function ($q) use ($searchText) {
                $q->where('produk.nama', 'like', '%' . $searchText . '%')
                    ->orWhere('produk.deskripsi', 'like', '%' . $searchText . '%');
            });
        }

        $produk = $query->paginate(15)->appends($request->query());

        // Eager load varian & galeri
        $produkIds = $produk->pluck('id');
        $allVarians = DB::table('produk_varian')->whereIn('id_produk', $produkIds)->get()->groupBy('id_produk');
        $allGaleri = DB::table('produk_foto')->whereIn('id_produk', $produkIds)->get()->groupBy('id_produk');

        $produk->getCollection()->transform(function ($item) use ($allVarians, $allGaleri) {
            $item->foto = isset($item->foto) ? $this->formatFotoUrl($item->foto) : null;
            $item->varians = $allVarians[$item->id] ?? [];
            $item->galeri_foto = collect($allGaleri[$item->id] ?? [])->map(function ($foto) {
                $foto->path_foto = $this->formatFotoUrl($foto->path_foto);
                return $foto;
            });
            return $item;
        });

        return response()->json($produk);
    }

    // 🔹 GET: suggestions (placeholder)
    public function getSuggestions(Request $request)
    {
        if (!$request->has('q') || $request->input('q') == '') {
            return response()->json([]);
        }

        // Implementasi suggestions sesuai kebutuhan (mis. query ke produk.nama)
        // Contoh singkat (bisa diubah sesuai kebutuhan):
        $q = $request->input('q');
        $results = DB::table('produk')
            ->select('id', 'nama')
            ->where('nama', 'like', '%' . $q . '%')
            ->limit(10)
            ->get();

        return response()->json($results);
    }

    // 🔹 PUT: /api/produk/update/{id}
    public function update(Request $request, $id)
    {
        $produk = DB::table('produk')->where('id', $id)->first();
        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        $dataProduk = $request->validate([
            'nama' => 'sometimes|string|max:255',
            'foto' => 'nullable',
            'deskripsi' => 'nullable|string',
            'spesifikasi' => 'nullable|string',
            'fitur' => 'nullable|string',

            'varians' => 'sometimes|array',
            'varians.*.id' => 'nullable|integer',
            'varians.*.nama_varian' => 'required|string|max:100',
            'varians.*.harga' => 'required|numeric|min:0',
            'varians.*.stok' => 'required|integer|min:0',

            'galeri_foto' => 'nullable|array',
            'galeri_foto.*' => 'file|image|max:2048',
            'hapus_galeri_ids' => 'nullable|array',
            'hapus_galeri_ids.*' => 'integer',
        ]);

        $updateDataProduk = [];
        $newGaleriPaths = [];

        DB::beginTransaction();
        try {
            // Update foto utama: jika ada file baru, hapus file lama lalu simpan yang baru
            if ($request->hasFile('foto')) {
                $this->hapusFileStorage($produk->foto);
                $updateDataProduk['foto'] = $request->file('foto')->store('produk', 'public');
            } elseif ($request->filled('foto') && $request->input('foto') === '') {
                // Jika klien mengirim foto = '' artinya ingin menghapus foto utama
                $this->hapusFileStorage($produk->foto);
                $updateDataProduk['foto'] = null;
            }

            // Update field produk lain (jika ada)
                if (array_key_exists('nama', $dataProduk)) $updateDataProduk['nama'] = $dataProduk['nama'];
                if (array_key_exists('deskripsi', $dataProduk)) $updateDataProduk['deskripsi'] = $dataProduk['deskripsi'];
                if (array_key_exists('spesifikasi', $dataProduk)) $updateDataProduk['spesifikasi'] = $dataProduk['spesifikasi'];
                if (array_key_exists('fitur', $dataProduk)) $updateDataProduk['fitur'] = $dataProduk['fitur'];

                if (!empty($updateDataProduk))
                {
                $updateDataProduk['updated_at'] = now();
                DB::table('produk')->where('id', $id)->update($updateDataProduk);
            }

            // Sinkronisasi varian
            if ($request->has('varians')) {
                $varianBaruIds = [];
                foreach ($request->varians as $varian) {
                    $varianPayload = [
                        'nama_varian' => $varian['nama_varian'],
                        'harga' => $varian['harga'],
                        'stok' => $varian['stok'],
                        'updated_at' => now(),
                    ];

                    if (isset($varian['id']) && $varian['id'] != null) {
                        $varianId = $varian['id'];
                        DB::table('produk_varian')->where('id', $varianId)->update($varianPayload);
                        $varianBaruIds[] = $varianId;
                    } else {
                        $varianPayload['id_produk'] = $id;
                        $varianPayload['created_at'] = now();
                        $newId = DB::table('produk_varian')->insertGetId($varianPayload);
                        $varianBaruIds[] = $newId;
                    }
                }

                // Hapus varian yang tidak ada di payload
                DB::table('produk_varian')
                    ->where('id_produk', $id)
                    ->whereNotIn('id', $varianBaruIds)
                    ->delete();
            }

            // Hapus foto galeri yang diminta
            if ($request->has('hapus_galeri_ids')) {
                $idsToHapus = $request->input('hapus_galeri_ids');
                if (!empty($idsToHapus)) {
                    $fotoLama = DB::table('produk_foto')
                        ->where('id_produk', $id)
                        ->whereIn('id', $idsToHapus)
                        ->get();

                    foreach ($fotoLama as $foto) {
                        $this->hapusFileStorage($foto->path_foto);
                    }

                    DB::table('produk_foto')->whereIn('id', $idsToHapus)->delete();
                }
            }

            // Tambah foto galeri baru (jika ada)
            if ($request->hasFile('galeri_foto')) {
                $galeriInsertData = [];
                foreach ($request->file('galeri_foto') as $file) {
                    if ($file->isValid()) {
                        $path = $file->store('produk_galeri', 'public');
                        $newGaleriPaths[] = $path;
                        $galeriInsertData[] = [
                            'id_produk' => $id,
                            'path_foto' => $path,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
                if (!empty($galeriInsertData)) {
                    DB::table('produk_foto')->insert($galeriInsertData);
                }
            }

            DB::commit();
            return response()->json(['message' => 'Produk berhasil diperbarui']);
        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus foto baru/galeri yang sudah tersimpan saat gagal
            if (isset($updateDataProduk['foto']) && $updateDataProduk['foto']) {
                $this->hapusFileStorage($updateDataProduk['foto']);
            }
            foreach ($newGaleriPaths as $p) {
                $this->hapusFileStorage($p);
            }

            return response()->json(['error' => 'Gagal memperbarui produk: ' . $e->getMessage()], 500);
        }
    }

    // 🔹 DELETE: /api/produk/{id}
    public function destroy($id)
    {
        $produk = DB::table('produk')->where('id', $id)->first();
        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        // Hapus foto utama jika ada
        if (!empty($produk->foto)) {
            $this->hapusFileStorage($produk->foto);
        }

        // Hapus semua foto galeri dari storage
        $galeri = DB::table('produk_foto')->where('id_produk', $id)->get();
        foreach ($galeri as $foto) {
            $this->hapusFileStorage($foto->path_foto);
        }

        // Hapus record produk (produk_varian & produk_foto diasumsikan ON DELETE CASCADE)
        DB::table('produk')->where('id', $id)->delete();

        return response()->json(['message' => 'Produk berhasil dihapus']);
    }
}