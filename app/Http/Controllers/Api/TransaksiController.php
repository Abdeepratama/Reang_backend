<?php

// Lokasi: app/Http/Controllers/Api/TransaksiController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Str; 

class TransaksiController extends Controller
{

    public function store(Request $request)
    {
        // 1. Validasi Input Utama
        $request->validate([
            'id_user' => 'required|integer',
            'alamat' => 'required|string',
            
            // Skenario A (Keranjang)
            'pesanan_per_toko' => 'sometimes|required|array|min:1',
            'pesanan_per_toko.*.id_toko' => 'required_with:pesanan_per_toko|integer|exists:toko,id',
            'pesanan_per_toko.*.item_ids' => 'required_with:pesanan_per_toko|array|min:1',
            'pesanan_per_toko..item_ids.' => 'integer', 
            'pesanan_per_toko.*.jasa_pengiriman' => 'required_with:pesanan_per_toko|string',
            'pesanan_per_toko.*.ongkir' => 'required_with:pesanan_per_toko|numeric',
            'pesanan_per_toko.*.catatan' => 'nullable|string',
            'pesanan_per_toko.*.metode_pembayaran' => 'required_with:pesanan_per_toko|string',
            'pesanan_per_toko.*.nomor_tujuan' => 'required_with:pesanan_per_toko|string',
            'pesanan_per_toko.*.nama_penerima' => 'required_with:pesanan_per_toko|string', // <-- [BARU]
            'pesanan_per_toko.*.foto_qris' => 'nullable|string|url',

            // Skenario B (Beli Langsung)
            'direct_item' => 'sometimes|required|array',
            'direct_item.id_produk' => 'required_with:direct_item|integer|exists:produk,id',
            'direct_item.id_toko' => 'required_with:direct_item|integer|exists:toko,id',
            'direct_item.jumlah' => 'required_with:direct_item|integer|min:1',
            'direct_item.harga' => 'required_with:direct_item|numeric',
            'direct_item.jasa_pengiriman' => 'required_with:direct_item|string',
            'direct_item.ongkir' => 'required_with:direct_item|numeric',
            'direct_item.catatan' => 'nullable|string',
            'direct_item.metode_pembayaran' => 'required_with:direct_item|string',
            'direct_item.nomor_tujuan' => 'required_with:direct_item|string',
            'direct_item.nama_penerima' => 'required_with:direct_item|string', // <-- [BARU]
            'direct_item.foto_qris' => 'nullable|string|url',
        ]);

        try {
            DB::beginTransaction();
            
            $id_user = $request->id_user;
            $daftar_transaksi_baru = []; 

            // 2. Tentukan Skenario
            if ($request->has('pesanan_per_toko')) {
                // --- SKENARIO A: CHECKOUT DARI KERANJANG (Multi-Toko) ---
                
                foreach ($request->pesanan_per_toko as $pesanan_toko) {
                    // ... (Logika ambil keranjang, cek stok, hitung total) ...
                    $item_ids = $pesanan_toko['item_ids'];
                    $keranjang_items = DB::table('keranjang')->where('id_user', $id_user)->where('id_toko', $pesanan_toko['id_toko'])->whereIn('id', $item_ids)->get();
                    if ($keranjang_items->isEmpty()) { throw new \Exception('Item keranjang tidak valid'); }
                    $subtotal_toko = $keranjang_items->sum('subtotal');
                    $ongkir_toko = (float) $pesanan_toko['ongkir'];
                    $total_toko = $subtotal_toko + $ongkir_toko;
                    $total_jumlah_item = $keranjang_items->sum('jumlah');
                    $no_transaksi_toko = 'TRX-' . strtoupper(uniqid());

                    // Buat 1 Transaksi per Toko
                    DB::table('transaksi')->insert([
                        'id_user' => $id_user,
                        'id_toko' => $pesanan_toko['id_toko'],
                        'no_transaksi' => $no_transaksi_toko,
                        'alamat' => $request->alamat,
                        'jumlah' => $total_jumlah_item,
                        'total' => $total_toko,
                        'subtotal' => $subtotal_toko,
                        'ongkir' => $ongkir_toko,
                        'catatan' => $pesanan_toko['catatan'] ?? 'Tidak ada catatan',
                        'status' => 'menunggu_pembayaran',
                        'jasa_pengiriman' => $pesanan_toko['jasa_pengiriman'],
                        'created_at' => Carbon::now(),
                    ]);

                    // ... (Logika insert 'detail_transaksi') ...
                    $items_for_detail = [];
                    foreach ($keranjang_items as $item) {
                        $items_for_detail[] = [
                            'no_transaksi' => $no_transaksi_toko,
                            'id_produk' => $item->id_produk,
                            'id_toko' => $item->id_toko,
                            'jumlah' => $item->jumlah,
                            'harga' => $item->harga,
                            'subtotal' => $item->subtotal,
                            'created_at' => Carbon::now(),
                        ];
                    }
                    DB::table('detail_transaksi')->insert($items_for_detail);

                    // Buat 1 Payment per Transaksi
                    DB::table('payment')->insert([
                        'no_transaksi' => $no_transaksi_toko,
                        'metode_pembayaran' => $pesanan_toko['metode_pembayaran'],
                        'nomor_tujuan' => $pesanan_toko['nomor_tujuan'],
                        'nama_penerima' => $pesanan_toko['nama_penerima'], // <-- [PERBAIKAN] Simpan
                        'foto_qris' => $pesanan_toko['foto_qris'] ?? null,
                        'status_pembayaran' => 'menunggu',
                        'bukti_pembayaran' => 'belum ada',
                        'tanggal_pembayaran' => Carbon::now()->format('Y-m-d'),
                        'created_at' => Carbon::now(),
                    ]);

                    // Hapus dari keranjang
                    DB::table('keranjang')->where('id_user', $id_user)->whereIn('id', $item_ids)->delete();
                    
                    // Siapkan data untuk respons
                    $daftar_transaksi_baru[] = [
                        'no_transaksi' => $no_transaksi_toko,
                        'total_bayar' => $total_toko,
                        'metode_pembayaran' => $pesanan_toko['metode_pembayaran'],
                        'nomor_tujuan' => $pesanan_toko['nomor_tujuan'],
                        'nama_penerima' => $pesanan_toko['nama_penerima'], // <-- [PERBAIKAN] Kirim
                        'foto_qris' => $pesanan_toko['foto_qris'] ?? null,
                    ];
                } // End foreach

            } elseif ($request->has('direct_item')) {
                // --- SKENARIO B: BELI LANGSUNG (Satu Toko) ---
                $item = $request->input('direct_item');
                
                // ... (Cek Stok) ...
                $produk = DB::table('produk')->find($item['id_produk']);
                if ($item['jumlah'] > $produk->stok) {
                    return response()->json(['message' => 'Jumlah melebihi stok (Stok: ' . $produk->stok . ')'], 422);
                }

                $subtotal_toko = $item['harga'] * $item['jumlah'];
                $ongkir_toko = (float) $item['ongkir'];
                $total_toko = $subtotal_toko + $ongkir_toko;
                $total_jumlah_item = $item['jumlah'];
                $no_transaksi_toko = 'TRX-' . strtoupper(uniqid());

                // Buat 1 Transaksi
                DB::table('transaksi')->insert([
                    'id_user' => $id_user,
                    'id_toko' => $item['id_toko'],
                    'no_transaksi' => $no_transaksi_toko,
                    'alamat' => $request->alamat,
                    'jumlah' => $total_jumlah_item,
                    'total' => $total_toko,
                    'subtotal' => $subtotal_toko,
                    'ongkir' => $ongkir_toko,
                    'catatan' => $item['catatan'] ?? 'Tidak ada catatan',
                    'status' => 'menunggu_pembayaran',
                    'jasa_pengiriman' => $item['jasa_pengiriman'],
                    'created_at' => Carbon::now(),
                ]);

                // Buat 1 Detail Transaksi
                DB::table('detail_transaksi')->insert([
                    'no_transaksi' => $no_transaksi_toko,
                    'id_produk' => $item['id_produk'],
                    'id_toko' => $item['id_toko'],
                    'jumlah' => $item['jumlah'],
                    'harga' => $item['harga'],
                    'subtotal' => $subtotal_toko,
                    'created_at' => Carbon::now(),
                ]);
                
                // Buat 1 Payment
                DB::table('payment')->insert([
                    'no_transaksi' => $no_transaksi_toko,
                    'metode_pembayaran' => $item['metode_pembayaran'],
                    'nomor_tujuan' => $item['nomor_tujuan'],
                    'nama_penerima' => $item['nama_penerima'], // <-- [PERBAIKAN] Simpan
                    'foto_qris' => $item['foto_qris'] ?? null,
                    'status_pembayaran' => 'menunggu',
                    'bukti_pembayaran' => 'belum ada',
                    'tanggal_pembayaran' => Carbon::now()->format('Y-m-d'),
                    'created_at' => Carbon::now(),
                ]);
                
                $daftar_transaksi_baru[] = [
                    'no_transaksi' => $no_transaksi_toko,
                    'total_bayar' => $total_toko,
                    'metode_pembayaran' => $item['metode_pembayaran'],
                    'nomor_tujuan' => $item['nomor_tujuan'],
                    'nama_penerima' => $item['nama_penerima'], // <-- [PERBAIKAN] Kirim
                    'foto_qris' => $item['foto_qris'] ?? null,
                ];
                
            } else {
                DB::rollBack();
                return response()->json(['message' => 'Data checkout tidak valid.'], 400);
            }

            DB::commit();

            return response()->json([
                'message' => 'Checkout berhasil, ' . count($daftar_transaksi_baru) . ' pesanan dibuat.',
                'data_pembayaran' => $daftar_transaksi_baru 
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }
    
    // =======================================================================
    // --- [PERBAIKAN] FUNGSI 'riwayat' (Tambahkan nama_penerima) ---
    // =======================================================================
    public function riwayat($id_user)
    {
        $riwayat = DB::table('transaksi')
            ->leftJoin('payment', 'transaksi.no_transaksi', '=', 'payment.no_transaksi')
            ->join('toko', 'transaksi.id_toko', '=', 'toko.id')
            ->select(
                'transaksi.*', 
                'payment.status_pembayaran',
                'payment.metode_pembayaran',
                'payment.nomor_tujuan',
                'payment.nama_penerima', // <-- [PERBAIKAN]
                'payment.foto_qris',
                'toko.nama as nama_toko'
            )
            ->where('transaksi.id_user', $id_user)
            ->orderBy('transaksi.created_at', 'desc')
            ->get();
            
        foreach ($riwayat as $transaksi) {
            $first_item = DB::table('detail_transaksi')
                ->join('produk', 'detail_transaksi.id_produk', '=', 'produk.id')
                ->where('detail_transaksi.no_transaksi', $transaksi->no_transaksi)
                ->select('produk.foto', 'produk.nama')
                ->first();

            $transaksi->foto_produk = $this->formatFotoUrl($first_item->foto ?? null);
            $transaksi->nama_produk_utama = $first_item->nama ?? 'Produk';
        }

        return response()->json($riwayat);
    }
    
    // =======================================================================
    // --- [PERBAIKAN] FUNGSI 'show' (Tambahkan nama_penerima) ---
    // =======================================================================
    public function show($no_transaksi)
    {
        $transaksi = DB::table('transaksi')
            ->join('toko', 'transaksi.id_toko', '=', 'toko.id')
            ->leftJoin('payment', 'transaksi.no_transaksi', '=', 'payment.no_transaksi')
            ->select(
                'transaksi.*', 
                'toko.nama as nama_toko', 
                'payment.status_pembayaran', 
                'payment.metode_pembayaran', 
                'payment.nomor_tujuan',
                'payment.nama_penerima', // <-- [PERBAIKAN]
                'payment.foto_qris'
            )
            ->where('transaksi.no_transaksi', $no_transaksi)
            ->first();

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }
        
        $items = DB::table('detail_transaksi')
            ->join('produk', 'detail_transaksi.id_produk', '=', 'produk.id')
            ->select('detail_transaksi.*', 'produk.nama as nama_produk', 'produk.foto')
            ->where('no_transaksi', $no_transaksi)
            ->get();
            
        $items->transform(function ($item) {
            $item->foto = $this->formatFotoUrl($item->foto);
            return $item;
        });

        return response()->json([
            'transaksi' => $transaksi,
            'items' => $items
        ]);
    }
    
    protected function formatFotoUrl($fotoPath)
    {
        if (empty($fotoPath)) return null;
        if (Str::startsWith($fotoPath, ['http://', 'httpsS://'])) return $fotoPath;
        try {
            $storageUrl = Storage::url($fotoPath); 
            return url($storageUrl);
        } catch (\Throwable $e) {
            return $fotoPath;
        }
    }

    public function batalkan(Request $request, $no_transaksi)
    {
        // 1. Dapatkan ID user yang sedang login
        $id_user = $request->user()->id;

        // 2. Cari transaksi
        $transaksi = DB::table('transaksi')
            ->where('no_transaksi', $no_transaksi)
            ->where('id_user', $id_user)
            ->first();

        // 3. Jika tidak ditemukan
        if (!$transaksi) {
            return response()->json(['message' => 'Pesanan tidak ditemukan.'], 404);
        }

        // 4. Logika Bisnis:
        // User HANYA boleh membatalkan jika status masih 'menunggu_pembayaran'
        // ATAU 'menunggu_konfirmasi' (admin belum memproses).
        if ($transaksi->status != 'menunggu_pembayaran' && $transaksi->status != 'menunggu_konfirmasi') {
            return response()->json([
                'message' => 'Pesanan ini sudah diproses dan tidak dapat dibatalkan.'
            ], 422); // 422 Unprocessable Entity
        }
        
        // 5. Jika boleh dibatalkan, lakukan update
        try {
            DB::beginTransaction();

            // Update tabel transaksi
            DB::table('transaksi')
                ->where('no_transaksi', $no_transaksi)
                ->update([
                    'status' => 'dibatalkan',
                    'updated_at' => Carbon::now()
                ]);

            // Update tabel payment
            DB::table('payment')
                ->where('no_transaksi', $no_transaksi)
                ->update([
                    'status_pembayaran' => 'dibatalkan',
                    'updated_at' => Carbon::now()
                ]);
            
        
            DB::commit();

            return response()->json(['message' => 'Pesanan berhasil dibatalkan.']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal membatalkan pesanan: ' . $e->getMessage()], 500);
        }
    }
}