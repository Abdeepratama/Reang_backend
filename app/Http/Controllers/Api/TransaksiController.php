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

    // =======================================================================
// [PERBAIKAN FUNGSI STORE DENGAN LOGIKA COD] — Versi Ditulis Ulang
// =======================================================================

public function store(Request $request)
{
    // ------------------------------------------------------------
    // 1. VALIDASI INPUT
    // ------------------------------------------------------------
    $request->validate([
        'id_user'         => 'required|integer',
        'alamat'          => 'required|string',
        'pesanan_per_toko'=> 'sometimes|required|array|min:1',
        'direct_item'     => 'sometimes|required|array',
        // validasi direct_item lainnya tetap sama
    ]);

    try {
        DB::beginTransaction();

        $id_user = $request->id_user;
        $daftar_transaksi_baru = [];

        /*
        |--------------------------------------------------------------------------
        | SKENARIO A — CHECKOUT DARI KERANJANG (MULTI TOKO)
        |--------------------------------------------------------------------------
        */
        if ($request->has('pesanan_per_toko')) {

            foreach ($request->pesanan_per_toko as $pesanan_toko) {

                // ------------------------------------------------------------
                // AMBIL ITEM KERANJANG
                // ------------------------------------------------------------
                $keranjang_items = DB::table('keranjang')
                    ->where('id_user', $id_user)
                    ->where('id_toko', $pesanan_toko['id_toko'])
                    ->whereIn('id', $pesanan_toko['item_ids'])
                    ->get();

                // ------------------------------------------------------------
                // CEK STOK ITEM
                // ------------------------------------------------------------
                foreach ($keranjang_items as $item) {

                    if (empty($item->id_varian)) {
                        throw new \Exception(
                            'Data keranjang lama tidak valid. Item ID: ' . $item->id .
                            ' — Harap hapus dan tambahkan ulang ke keranjang.'
                        );
                    }

                    $varian_stok = DB::table('produk_varian')
                        ->where('id', $item->id_varian)
                        ->value('stok');

                    if ($item->jumlah > $varian_stok) {
                        throw new \Exception(
                            'Stok produk tidak mencukupi (Sisa: ' . $varian_stok . ')'
                        );
                    }
                }

                // ------------------------------------------------------------
                // HITUNG TOTAL HARGA
                // ------------------------------------------------------------
                $subtotal_toko      = $keranjang_items->sum('subtotal');
                $ongkir_toko        = (float) $pesanan_toko['ongkir'];
                $total_toko         = $subtotal_toko + $ongkir_toko;
                $total_jumlah_item  = $keranjang_items->sum('jumlah');
                $no_transaksi_toko  = 'TRX-' . strtoupper(uniqid());

                // ------------------------------------------------------------
                // LOGIKA COD
                // ------------------------------------------------------------
                $metode_pembayaran_a = $pesanan_toko['metode_pembayaran'] ?? '';
                $is_cod_a            = (strtolower($metode_pembayaran_a) === 'cod');

                $status_transaksi    = $is_cod_a ? 'diproses' : 'menunggu_pembayaran';
                $status_payment      = $is_cod_a ? 'cod'      : 'menunggu';
                $bukti_payment       = $is_cod_a ? 'bayar_ditempat' : 'belum ada';

                // ------------------------------------------------------------
                // INSERT DATA TRANSAKSI
                // ------------------------------------------------------------
                DB::table('transaksi')->insert([
                    'id_user'         => $id_user,
                    'id_toko'         => $pesanan_toko['id_toko'],
                    'no_transaksi'    => $no_transaksi_toko,
                    'alamat'          => $request->alamat,
                    'jumlah'          => $total_jumlah_item,
                    'total'           => $total_toko,
                    'subtotal'        => $subtotal_toko,
                    'ongkir'          => $ongkir_toko,
                    'catatan'         => $pesanan_toko['catatan'] ?? 'Tidak ada catatan',
                    'status'          => $status_transaksi,
                    'jasa_pengiriman' => $pesanan_toko['jasa_pengiriman'],
                    'created_at'      => Carbon::now(),
                ]);

                // ------------------------------------------------------------
                // INSERT DETAIL TRANSAKSI
                // ------------------------------------------------------------
                $detail_items = [];
                foreach ($keranjang_items as $item) {
                    $detail_items[] = [
                        'no_transaksi' => $no_transaksi_toko,
                        'id_produk'    => $item->id_produk,
                        'id_varian'    => $item->id_varian,
                        'id_toko'      => $item->id_toko,
                        'jumlah'       => $item->jumlah,
                        'harga'        => $item->harga,
                        'subtotal'     => $item->subtotal,
                        'created_at'   => Carbon::now(),
                    ];
                    // [TAMBAHAN BARU: KURANGI STOK OTOMATIS]
                    DB::table('produk_varian')
                        ->where('id', $item->id_varian)
                        ->decrement('stok', $item->jumlah);
                    // --------------------------------------
                }
                DB::table('detail_transaksi')->insert($detail_items);

                // ------------------------------------------------------------
                // INSERT PAYMENT
                // ------------------------------------------------------------
                DB::table('payment')->insert([
                    'no_transaksi'      => $no_transaksi_toko,
                    'metode_pembayaran' => $pesanan_toko['metode_pembayaran'],
                    'nomor_tujuan'      => $pesanan_toko['nomor_tujuan'] ?? null,
                    'nama_penerima'     => $pesanan_toko['nama_penerima'],
                    'foto_qris'         => $pesanan_toko['foto_qris'] ?? null,
                    'status_pembayaran' => $status_payment,
                    'bukti_pembayaran'  => $bukti_payment,
                    'tanggal_pembayaran'=> Carbon::now()->format('Y-m-d'),
                    'created_at'        => Carbon::now(),
                ]);

                // ------------------------------------------------------------
                // HAPUS KERANJANG
                // ------------------------------------------------------------
                DB::table('keranjang')
                    ->where('id_user', $id_user)
                    ->whereIn('id', $pesanan_toko['item_ids'])
                    ->delete();

                // ------------------------------------------------------------
                // DATA RESPON
                // ------------------------------------------------------------
                $daftar_transaksi_baru[] = [
                    'no_transaksi'     => $no_transaksi_toko,
                    'total_bayar'      => $total_toko,
                    'metode_pembayaran'=> $pesanan_toko['metode_pembayaran'],
                    'nomor_tujuan'     => $pesanan_toko['nomor_tujuan'] ?? null,
                    'nama_penerima'    => $pesanan_toko['nama_penerima'],
                    'foto_qris'        => $pesanan_toko['foto_qris'] ?? null,
                ];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SKENARIO B — BELI LANGSUNG
        |--------------------------------------------------------------------------
        */
        elseif ($request->has('direct_item')) {

            $item = $request->direct_item;

            // ------------------------------------------------------------
            // CEK VARIAN
            // ------------------------------------------------------------
            $varian = DB::table('produk_varian')
                ->where('id', $item['id_varian'])
                ->where('id_produk', $item['id_produk'])
                ->first();

            if (!$varian) {
                throw new \Exception('Varian produk tidak ditemukan.');
            }

            if ($item['jumlah'] > $varian->stok) {
                return response()->json([
                    'message' => 'Jumlah melebihi stok (Stok: ' . $varian->stok . ')'
                ], 422);
            }

            if ($item['harga'] != $varian->harga) {
                return response()->json([
                    'message' => 'Harga produk telah berubah. Silakan ulangi.'
                ], 422);
            }

            // ------------------------------------------------------------
            // HITUNG HARGA
            // ------------------------------------------------------------
            $subtotal = $varian->harga * $item['jumlah'];
            $ongkir   = (float) $item['ongkir'];
            $total    = $subtotal + $ongkir;

            $no_transaksi = 'TRX-' . strtoupper(uniqid());

            // ------------------------------------------------------------
            // LOGIKA COD
            // ------------------------------------------------------------
            $metode_pembayaran_b  = $item['metode_pembayaran'] ?? '';
            $is_cod_b             = (strtolower($metode_pembayaran_b) === 'cod');

            $status_trans_b       = $is_cod_b ? 'diproses'            : 'menunggu_pembayaran';
            $status_pay_b         = $is_cod_b ? 'cod'                 : 'menunggu';
            $bukti_payment_b      = $is_cod_b ? 'bayar_ditempat'      : 'belum ada';

            // ------------------------------------------------------------
            // INSERT TRANSAKSI
            // ------------------------------------------------------------
            DB::table('transaksi')->insert([
                'id_user'         => $id_user,
                'id_toko'         => $item['id_toko'],
                'no_transaksi'    => $no_transaksi,
                'alamat'          => $request->alamat,
                'jumlah'          => $item['jumlah'],
                'total'           => $total,
                'subtotal'        => $subtotal,
                'ongkir'          => $ongkir,
                'catatan'         => $item['catatan'] ?? 'Tidak ada catatan',
                'status'          => $status_trans_b,
                'jasa_pengiriman' => $item['jasa_pengiriman'],
                'created_at'      => Carbon::now(),
            ]);

            // ------------------------------------------------------------
            // INSERT DETAIL
            // ------------------------------------------------------------
            DB::table('detail_transaksi')->insert([
                'no_transaksi' => $no_transaksi,
                'id_produk'    => $item['id_produk'],
                'id_varian'    => $item['id_varian'],
                'id_toko'      => $item['id_toko'],
                'jumlah'       => $item['jumlah'],
                'harga'        => $varian->harga,
                'subtotal'     => $subtotal,
                'created_at'   => Carbon::now(),
            ]);
            // [TAMBAHAN BARU: KURANGI STOK OTOMATIS]
            DB::table('produk_varian')
                ->where('id', $item['id_varian'])
                ->decrement('stok', $item['jumlah']);

            // ------------------------------------------------------------
            // INSERT PAYMENT
            // ------------------------------------------------------------
            DB::table('payment')->insert([
                'no_transaksi'      => $no_transaksi,
                'metode_pembayaran' => $item['metode_pembayaran'],
                'nomor_tujuan'      => $item['nomor_tujuan'] ?? null,
                'nama_penerima'     => $item['nama_penerima'],
                'foto_qris'         => $item['foto_qris'] ?? null,
                'status_pembayaran' => $status_pay_b,
                'bukti_pembayaran'  => $bukti_payment_b,
                'tanggal_pembayaran'=> Carbon::now()->format('Y-m-d'),
                'created_at'        => Carbon::now(),
            ]);

            // ------------------------------------------------------------
            // DATA RESPON
            // ------------------------------------------------------------
            $daftar_transaksi_baru[] = [
                'no_transaksi'     => $no_transaksi,
                'total_bayar'      => $total,
                'metode_pembayaran'=> $item['metode_pembayaran'],
                'nomor_tujuan'     => $item['nomor_tujuan'] ?? null,
                'nama_penerima'    => $item['nama_penerima'],
                'foto_qris'        => $item['foto_qris'] ?? null,
            ];
        }

        else {
            DB::rollBack();
            return response()->json(['message' => 'Data checkout tidak valid.'], 400);
        }

        // ------------------------------------------------------------
        // SELESAI TRANSAKSI
        // ------------------------------------------------------------
        DB::commit();

        return response()->json([
            'message'         => 'Checkout berhasil, ' . count($daftar_transaksi_baru) . ' pesanan dibuat.',
            'data_pembayaran' => $daftar_transaksi_baru
        ]);

    } catch (\Exception $e) {

        DB::rollBack();
        return response()->json([
            'error' => $e->getMessage(),
            'line'  => $e->getLine()
        ], 500);
    }
}

    
    // =======================================================================
    // --- [PERBAIKAN] FUNGSI 'riwayat' (Tambahkan nama_penerima) ---
    // =======================================================================
    public function riwayat(Request $request, $id_user)
    {
        // 1. Validasi User
        if ($request->user()->id != $id_user) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // 2. Query Dasar dengan Collation Fix (Agar tidak error Illegal Mix)
        $query = DB::table('transaksi')
            ->leftJoin('payment', function($join) {
                $join->on('transaksi.no_transaksi', '=', DB::raw('payment.no_transaksi COLLATE utf8mb4_unicode_ci'));
            })
            ->join('toko', 'transaksi.id_toko', '=', 'toko.id')
            ->where('transaksi.id_user', $id_user);

        // 3. Filter Status (Sesuai Tab di Flutter)
        if ($request->has('status') && !empty($request->status)) {
            $filter = $request->status;

            if ($filter == 'belum_dibayar') {
                // Transaksi 'menunggu_pembayaran' DAN Payment bukan 'menunggu_konfirmasi'
                $query->where('transaksi.status', 'menunggu_pembayaran')
                      ->where(function($q) {
                          $q->where('payment.status_pembayaran', '!=', 'menunggu_konfirmasi')
                            ->orWhereNull('payment.status_pembayaran');
                      });
            } elseif ($filter == 'dikemas') {
                // Gabungan 'menunggu_konfirmasi' (Payment) dan 'diproses' (Transaksi/COD)
                $query->where(function($q) {
                    $q->where('payment.status_pembayaran', 'menunggu_konfirmasi')
                      ->orWhere('transaksi.status', 'diproses');
                });
            } else {
                // Untuk status: dikirim, selesai, dibatalkan
                $query->where('transaksi.status', $filter);
            }
        }

        // 4. Select Data
        $riwayat = $query->select(
                'transaksi.id',
                'transaksi.id_user',
                'transaksi.id_toko',
                'transaksi.no_transaksi',
                'transaksi.alamat',
                'transaksi.jumlah',
                'transaksi.total',
                'transaksi.subtotal',
                'transaksi.ongkir',
                'transaksi.catatan',
                'transaksi.jasa_pengiriman',
                'transaksi.nomor_resi',
                'transaksi.created_at',
                'transaksi.updated_at',
                
                // Logika Status Pintar
                DB::raw("CASE 
                    WHEN payment.status_pembayaran = 'menunggu_konfirmasi' THEN 'menunggu_konfirmasi'
                    WHEN payment.status_pembayaran = 'ditolak' THEN 'menunggu_pembayaran' 
                    ELSE transaksi.status 
                END as status"),

                        DB::raw("(SELECT EXISTS(
                            SELECT 1 FROM ulasan 
                            WHERE ulasan.no_transaksi = transaksi.no_transaksi COLLATE utf8mb4_unicode_ci
                            LIMIT 1
                        )) as is_reviewed"),

                'payment.status_pembayaran',
                'payment.metode_pembayaran',
                'payment.nomor_tujuan',
                'payment.nama_penerima',
                'payment.foto_qris',
                'payment.bukti_pembayaran', // <-- Pastikan ini ada
                
                'toko.nama as nama_toko',
                'toko.no_hp as no_hp_toko'  // <-- Pastikan ini ada
            )
            ->orderBy('transaksi.created_at', 'desc')
            ->paginate(10); // [PENTING] Wajib paginate(10) agar cocok dengan frontend

        // 5. Transform Data (Foto Produk)
        $riwayat->getCollection()->transform(function ($transaksi) {
            $first_item = DB::table('detail_transaksi')
                ->join('produk', 'detail_transaksi.id_produk', '=', 'produk.id')
                ->where('detail_transaksi.no_transaksi', $transaksi->no_transaksi)
                ->select('produk.foto', 'produk.nama')
                ->first();

            $transaksi->foto_produk = $this->formatFotoUrl($first_item->foto ?? null);
            $transaksi->nama_produk_utama = $first_item->nama ?? 'Produk';
            
            // Format URL bukti pembayaran juga
            if (isset($transaksi->bukti_pembayaran)) {
                $transaksi->bukti_pembayaran = $this->formatFotoUrl($transaksi->bukti_pembayaran);
            }
            
            return $transaksi;
        });

        return response()->json($riwayat);
    }
    
 // =======================================================================
    // --- [PERBAIKAN FUNGSI SHOW DENGAN LOGIKA STATUS] ---
    // =======================================================================
    public function show($no_transaksi)
    {
        $transaksi = DB::table('transaksi')
            ->join('toko', 'transaksi.id_toko', '=', 'toko.id')
            ->leftJoin('payment', 'transaksi.no_transaksi', '=', 'payment.no_transaksi')
            ->where('transaksi.no_transaksi', $no_transaksi) // <-- Filter by no_transaksi
            ->select(
                // [PERBAIKAN] Jabarkan semua kolom dari 'transaksi'
                'transaksi.id',
                'transaksi.id_user',
                'transaksi.id_toko',
                'transaksi.no_transaksi',
                'transaksi.alamat',
                'transaksi.jumlah',
                'transaksi.total',
                'transaksi.subtotal',
                'transaksi.ongkir',
                'transaksi.catatan',
                'transaksi.jasa_pengiriman',
                'transaksi.nomor_resi',
                'transaksi.created_at',
                'transaksi.updated_at',

                // [LOGIKA STATUS YANG KONSISTEN]
                // Ini akan menimpa 'transaksi.status' dengan status yang benar
                DB::raw("CASE 
                    WHEN payment.status_pembayaran = 'menunggu_konfirmasi' THEN 'menunggu_konfirmasi'
                    WHEN payment.status_pembayaran = 'ditolak' THEN 'menunggu_pembayaran' 
                    ELSE transaksi.status 
                END as status"),
                // [SELESAI PERBAIKAN LOGIKA STATUS]

                // Kolom dari tabel lain
                'toko.nama as nama_toko',
                'toko.no_hp as no_hp_toko', 
                'payment.status_pembayaran', 
                'payment.metode_pembayaran', 
                'payment.nomor_tujuan',
                'payment.nama_penerima',
                'payment.foto_qris',
                'payment.bukti_pembayaran' // <-- Ini sudah kita tambahkan sebelumnya
            )
            ->first(); // <-- Gunakan first() karena ini 'show' bukan 'get'

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

        // Format URL bukti pembayaran SEBELUM dikirim ke Flutter
        // (Ini sudah Anda tambahkan dan sudah benar)
        if ($transaksi->bukti_pembayaran) {
            $transaksi->bukti_pembayaran = $this->formatFotoUrl($transaksi->bukti_pembayaran);
        }

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

        // 2. Cari transaksi (Pastikan milik user ini)
        $transaksi = DB::table('transaksi')
            ->where('no_transaksi', $no_transaksi)
            ->where('id_user', $id_user)
            ->first();

        // 3. Jika tidak ditemukan
        if (!$transaksi) {
            return response()->json(['message' => 'Pesanan tidak ditemukan.'], 404);
        }

        // 4. Logika Bisnis: Hanya boleh batal jika belum dikirim
        $forbidden_statuses = ['dikirim', 'selesai', 'dibatalkan'];

        if (in_array($transaksi->status, $forbidden_statuses)) {
            return response()->json([
                'message' => 'Pesanan ini sudah dikirim/selesai dan tidak dapat dibatalkan.'
            ], 422);
        }
        
        // 5. Proses Pembatalan
        DB::beginTransaction();
        try {
            // A. Update tabel transaksi
            DB::table('transaksi')
                ->where('no_transaksi', $no_transaksi)
                ->update([
                    'status' => 'dibatalkan',
                    'updated_at' => Carbon::now()
                ]);

            // B. Update tabel payment
            DB::table('payment')
                ->where('no_transaksi', $no_transaksi)
                ->update([
                    'status_pembayaran' => 'dibatalkan',
                    'updated_at' => Carbon::now()
                ]);
            
            // C. [PERBAIKAN UTAMA: KEMBALIKAN STOK]
            // Ambil semua item yang ada di transaksi ini
            $items = DB::table('detail_transaksi')->where('no_transaksi', $no_transaksi)->get();

            foreach ($items as $item) {
                // Kembalikan stok ke varian yang sesuai
                if ($item->id_varian) {
                    DB::table('produk_varian')
                        ->where('id', $item->id_varian)
                        ->increment('stok', $item->jumlah); // <-- Stok bertambah kembali
                }
            }
            // [SELESAI LOGIKA STOK]

            // D. Notifikasi (Opsional: Beri tahu user bahwa berhasil batal)
            \App\Models\Notification::create([
                'id_user' => $id_user,
                'title'   => 'Pesanan Dibatalkan',
                'body'    => "Anda telah membatalkan pesanan #$no_transaksi.",
                'type'    => 'transaksi',
                'data_id' => $no_transaksi,
                'is_read' => 0,
            ]);
        
            DB::commit();
            return response()->json(['message' => 'Pesanan berhasil dibatalkan dan stok telah dikembalikan.']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal membatalkan pesanan: ' . $e->getMessage()], 500);
        }
    }
    public function selesaikanPesanan(Request $request, $no_transaksi)
    {
        $id_user = $request->user()->id;

        // 1. Cek apakah transaksi ini milik user yang login
        $transaksi = DB::table('transaksi')
            ->where('no_transaksi', $no_transaksi)
            ->where('id_user', $id_user)
            ->first();

        if (!$transaksi) {
            return response()->json(['message' => 'Pesanan tidak ditemukan.'], 404);
        }

        // 2. Hanya boleh selesai jika status 'dikirim'
        if ($transaksi->status != 'dikirim') {
             return response()->json(['message' => 'Pesanan belum dikirim, tidak bisa diselesaikan.'], 422);
        }

        // 3. Update status
        DB::table('transaksi')
            ->where('no_transaksi', $no_transaksi)
            ->update([
                'status' => 'selesai',
                'updated_at' => Carbon::now()
            ]);

        return response()->json(['message' => 'Terima kasih! Pesanan telah diselesaikan.']);
    }

    public function getCounts(Request $request, $id_user)
    {
        // Validasi akses
        if ($request->user()->id != $id_user) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $counts = DB::table('transaksi')
            // [PERBAIKAN UTAMA: Tambahkan COLLATE agar tidak error 500]
            ->leftJoin('payment', function($join) {
                $join->on('transaksi.no_transaksi', '=', DB::raw('payment.no_transaksi COLLATE utf8mb4_unicode_ci'));
            })
            ->where('transaksi.id_user', $id_user)
            ->select(
                DB::raw("
                    CASE 
                        WHEN payment.status_pembayaran = 'menunggu_konfirmasi' THEN 'menunggu_konfirmasi'
                        WHEN payment.status_pembayaran = 'ditolak' THEN 'menunggu_pembayaran' 
                        ELSE transaksi.status 
                    END as status_final
                "),
                DB::raw('count(*) as total')
            )
            ->groupBy('status_final')
            ->get();

        $result = [
            'belum_dibayar' => 0,
            'dikemas' => 0,
            'dikirim' => 0,
            'selesai' => 0,
            'dibatalkan' => 0,
        ];

        foreach ($counts as $c) {
            // Mapping status database ke Tab User
            if ($c->status_final == 'menunggu_pembayaran') {
                $result['belum_dibayar'] += $c->total;
            } elseif ($c->status_final == 'menunggu_konfirmasi' || $c->status_final == 'diproses') {
                $result['dikemas'] += $c->total;
            } elseif ($c->status_final == 'dikirim') {
                $result['dikirim'] += $c->total;
            } elseif ($c->status_final == 'selesai') {
                $result['selesai'] += $c->total;
            } elseif ($c->status_final == 'dibatalkan') {
                $result['dibatalkan'] += $c->total;
            }
        }

        return response()->json($result);
    }
}