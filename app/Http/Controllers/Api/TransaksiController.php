<?php

// Lokasi: app/Http/Controllers/Api/TransaksiController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage; // <-- [BARU] Tambahkan ini
use Illuminate\Support\Str; // <-- [BARU] Tambahkan ini

// Model-model yang mungkin Anda perlukan
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Payment;
use App\Models\Produk;
use App\Models\Keranjang;

class TransaksiController extends Controller
{
    // =======================================================================
    // --- [BARU] FUNGSI STORE (PENGGANTI CHECKOUTCONTROLLER) ---
    // =======================================================================
    /**
     * 🔹 POST: /api/transaksi/create
     * Menerima checkout (baik dari keranjang atau beli langsung).
     * Ini adalah FUNGSI UTAMA CHECKOUT Anda.
     */
   public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|integer',
            'alamat' => 'required|string',
            'metode_pembayaran' => 'required|string',
            'jasa_pengiriman' => 'required|string',
            'catatan' => 'nullable|string',
            'item_ids' => 'sometimes|required|array',
            'item_ids.*' => 'integer|exists:keranjang,id',
            'direct_item' => 'sometimes|required|array',
            'direct_item.id_produk' => 'required_with:direct_item|integer|exists:produk,id',
            'direct_item.id_toko' => 'required_with:direct_item|integer|exists:toko,id',
            'direct_item.jumlah' => 'required_with:direct_item|integer|min:1',
            'direct_item.harga' => 'required_with:direct_item|numeric',
        ]);

        try {
            DB::beginTransaction();
            
            $id_user = $request->id_user;
            $no_transaksi = 'TRX' . strtoupper(uniqid());
            
            $items_for_detail = [];
            $total = 0;
            $total_jumlah = 0;

            if ($request->has('item_ids')) {
                // --- SKENARIO A: CHECKOUT DARI KERANJANG (Logika ini sudah benar) ---
                $keranjang = DB::table('keranjang')
                    ->where('id_user', $id_user)
                    ->whereIn('id', $request->item_ids)
                    ->get();

                if ($keranjang->isEmpty()) {
                    return response()->json(['message' => 'Tidak ada item yang dipilih'], 400);
                }

                $total = $keranjang->sum('subtotal');
                $total_jumlah = $keranjang->sum('jumlah');

                foreach ($keranjang as $item) {
                    $items_for_detail[] = [
                        'no_transaksi' => $no_transaksi,
                        'id_produk' => $item->id_produk,
                        'id_toko' => $item->id_toko,
                        'jumlah' => $item->jumlah,
                        'harga' => $item->harga,
                        'subtotal' => $item->subtotal,
                        'created_at' => Carbon::now(),
                    ];
                }
                
                DB::table('keranjang')
                    ->where('id_user', $id_user)
                    ->whereIn('id', $request->item_ids)
                    ->delete();

            } elseif ($request->has('direct_item')) {
                // --- SKENARIO B: BELI LANGSUNG ---
                $item = $request->input('direct_item');
                
                $produk = DB::table('produk')->find($item['id_produk']);
                if ($item['jumlah'] > $produk->stok) {
                    return response()->json([
                        'message' => 'Jumlah melebihi stok (Stok: ' . $produk->stok . ')'
                    ], 422);
                }

                $subtotal = $item['harga'] * $item['jumlah'];
                $total = $subtotal;
                $total_jumlah = $item['jumlah'];

                // --- [PERBAIKAN DI SINI] ---
                $items_for_detail[] = [
                    'no_transaksi' => $no_transaksi,
                    'id_produk' => $item['id_produk'],
                    'id_toko' => $item['id_toko'], // <-- BARIS INI DITAMBAHKAN
                    'jumlah' => $item['jumlah'],
                    'harga' => $item['harga'],
                    'subtotal' => $subtotal,
                    'created_at' => Carbon::now(),
                ];
                // --- [PERBAIKAN SELESAI] ---

            } else {
                DB::rollBack();
                return response()->json(['message' => 'Data checkout tidak valid.'], 400);
            }

            // 1. Simpan transaksi utama
            DB::table('transaksi')->insert([
                'id_user' => $id_user,
                'no_transaksi' => $no_transaksi,
                'alamat' => $request->alamat,
                'jumlah' => $total_jumlah,
                'total' => $total,
                'subtotal' => $total,
                'catatan' => $request->catatan ?? 'Tidak ada catatan',
                'status' => 'menunggu',
                'jasa_pengiriman' => $request->jasa_pengiriman,
                'created_at' => Carbon::now(),
            ]);

            // 2. Simpan detail transaksi
            DB::table('detail_transaksi')->insert($items_for_detail);

            // 3. Simpan payment
            DB::table('payment')->insert([
                'no_transaksi' => $no_transaksi,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status_pembayaran' => 'proses',
                'bukti_pembayaran' => 'belum ada',
                'tanggal_pembayaran' => Carbon::now()->format('Y-m-d'),
                'created_at' => Carbon::now(),
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Checkout berhasil',
                'no_transaksi' => $no_transaksi,
                'total' => $total
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
     * Melihat riwayat (daftar) transaksi user.
     */
    public function riwayat($id_user)
    {
        // (Pastikan ini sesuai dengan kebutuhan Anda)
        $riwayat = DB::table('transaksi')
            ->where('id_user', $id_user)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json($riwayat);
    }
    
    /**
     * 🔹 GET: /api/transaksi/detail/{no_transaksi}
     * Melihat detail satu transaksi beserta item-itemnya.
     */
    public function show($no_transaksi)
    {
        $transaksi = DB::table('transaksi')
            ->where('no_transaksi', $no_transaksi)
            // ->where('id_user', auth()->id()) // (Pengecekan keamanan)
            ->first();

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        $items = DB::table('detail_transaksi')
            ->join('produk', 'detail_transaksi.id_produk', '=', 'produk.id')
            ->select('detail_transaksi.*', 'produk.nama as nama_produk', 'produk.foto')
            ->where('no_transaksi', $no_transaksi)
            ->get();
            
        // (Format foto jika perlu)
        $items->transform(function ($item) {
            $item->foto = $this->formatFotoUrl($item->foto); // Gunakan helper
            return $item;
        });

        return response()->json([
            'transaksi' => $transaksi,
            'items' => $items
        ]);
    }

    // (Anda bisa tambahkan fungsi 'update' atau 'cancel' di sini nanti)
    
    // (Helper formatFotoUrl - kita perlukan di 'show')
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