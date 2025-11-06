<?php

// Lokasi: app/Http/Controllers/Api/TransaksiController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Str; 

// Model-model yang mungkin Anda perlukan
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Payment;
use App\Models\Produk;
use App\Models\Keranjang;

class TransaksiController extends Controller
{

    public function store(Request $request)
    {
        // 1. Validasi Input Utama
        $request->validate([
            'id_user' => 'required|integer',
            'alamat' => 'required|string',
            'metode_pembayaran' => 'required|string',
            'pesanan_per_toko' => 'required|array|min:1',
            
            // Validasi setiap item di dalam array 'pesanan_per_toko'
            'pesanan_per_toko.*.id_toko' => 'required|integer|exists:toko,id',
            'pesanan_per_toko.*.item_ids' => 'required|array|min:1',
            'pesanan_per_toko..item_ids.' => 'integer|exists:keranjang,id',
            'pesanan_per_toko.*.jasa_pengiriman' => 'required|string',
            'pesanan_per_toko.*.ongkir' => 'required|numeric',
            'pesanan_per_toko.*.catatan' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();
            
            $id_user = $request->id_user;
            
            // Buat SATU "Nomor Pembayaran Induk" untuk SEMUA pesanan
            $no_pembayaran = 'PAY-' . strtoupper(uniqid());
            
            $total_keseluruhan = 0;
            $daftar_no_transaksi = [];

            // 2. Loop setiap pesanan (per toko) yang dikirim Flutter
            foreach ($request->pesanan_per_toko as $pesanan_toko) {
                
                // --- A. Ambil Data Item dari Keranjang ---
                $item_ids = $pesanan_toko['item_ids'];
                $keranjang_items = DB::table('keranjang')
                    ->where('id_user', $id_user)
                    ->where('id_toko', $pesanan_toko['id_toko'])
                    ->whereIn('id', $item_ids)
                    ->get();

                if ($keranjang_items->isEmpty()) {
                    throw new \Exception('Item keranjang tidak valid untuk toko ' . $pesanan_toko['id_toko']);
                }
                
                // (Anda bisa tambahkan Cek Stok di sini jika mau)

                // --- B. Hitung Total per Toko ---
                $subtotal_toko = $keranjang_items->sum('subtotal');
                $ongkir_toko = (float) $pesanan_toko['ongkir'];
                $total_toko = $subtotal_toko + $ongkir_toko;
                
                $total_keseluruhan += $total_toko; // Tambahkan ke total induk
                $total_jumlah_item = $keranjang_items->sum('jumlah');

                // --- C. Buat "Nota" (Transaksi) Unik per Toko ---
                $no_transaksi_toko = 'TRX-' . strtoupper(uniqid());
                $daftar_no_transaksi[] = $no_transaksi_toko;

                DB::table('transaksi')->insert([
                    'id_user' => $id_user,
                    'id_toko' => $pesanan_toko['id_toko'],
                    'no_transaksi' => $no_transaksi_toko, // <-- Nota unik toko
                    'no_pembayaran' => $no_pembayaran, // <-- Pengikat ke Pembayaran Induk
                    'alamat' => $request->alamat,
                    'jumlah' => $total_jumlah_item,
                    'total' => $total_toko,
                    'subtotal' => $subtotal_toko,
                    // 'ongkir' => $ongkir_toko, // (Tambahkan kolom 'ongkir' ke tabel 'transaksi' jika perlu)
                    'catatan' => $pesanan_toko['catatan'] ?? 'Tidak ada catatan',
                    'status' => 'menunggu_pembayaran', // Ganti status
                    'jasa_pengiriman' => $pesanan_toko['jasa_pengiriman'],
                    'created_at' => Carbon::now(),
                ]);

                // --- D. Siapkan Detail Item untuk Nota ini ---
                $items_for_detail = [];
                foreach ($keranjang_items as $item) {
                    $items_for_detail[] = [
                        'no_transaksi' => $no_transaksi_toko, // <-- Link ke nota unik
                        'id_produk' => $item->id_produk,
                        'id_toko' => $item->id_toko,
                        'jumlah' => $item->jumlah,
                        'harga' => $item->harga,
                        'subtotal' => $item->subtotal,
                        'created_at' => Carbon::now(),
                    ];
                }
                
                // Insert detail item
                DB::table('detail_transaksi')->insert($items_for_detail);

                // Hapus item dari keranjang
                DB::table('keranjang')
                    ->where('id_user', $id_user)
                    ->whereIn('id', $item_ids)
                    ->delete();
            }
            
            // --- E. Buat SATU Pembayaran Induk ---
            DB::table('payment')->insert([
                'no_pembayaran' => $no_pembayaran, // <-- Menggunakan ID Pembayaran Induk
                'metode_pembayaran' => $request->metode_pembayaran,
                'status_pembayaran' => 'proses',
                'bukti_pembayaran' => 'belum ada',
                'tanggal_pembayaran' => Carbon::now()->format('Y-m-d'),
                'created_at' => Carbon::now(),
                // 'total' => $total_keseluruhan // (Tambahkan jika ada kolom total di payment)
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Checkout berhasil, ' . count($daftar_no_transaksi) . ' pesanan dibuat.',
                'no_pembayaran' => $no_pembayaran, // Kirim ini ke Flutter
                'no_transaksi_terbuat' => $daftar_no_transaksi,
                'total_keseluruhan' => $total_keseluruhan
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    // =======================================================================
    // --- FUNGSI 'riwayat' DAN 'show' (TETAP ADA) ---
    // =======================================================================

    /**
     * 🔹 GET: /api/transaksi/riwayat/{id_user}
     * (Tidak berubah)
     */
    public function riwayat($id_user)
    {
        $riwayat = DB::table('transaksi')
            ->where('id_user', $id_user)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json($riwayat);
    }
    
    /**
     * 🔹 GET: /api/transaksi/detail/{no_transaksi}
     * (Tidak berubah)
     */
    public function show($no_transaksi)
    {
        $transaksi = DB::table('transaksi')
            ->where('no_transaksi', $no_transaksi)
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
    
    /**
     * Helper formatFotoUrl
     * (Tidak berubah)
     */
    protected function formatFotoUrl($fotoPath)
    {
        if (empty($fotoPath)) return null;
        if (Str::startsWith($fotoPath, ['http://', 'https://'])) return $fotoPath;
        try {
            $storageUrl = Storage::url($fotoPath); 
            return url($storageUrl);
        } catch (\Throwable $e) {
            return $fotoPath;
        }
    }
}