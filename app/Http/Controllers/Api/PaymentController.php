<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'no_transaksi' => 'required|string|exists:transaksi,no_transaksi',
            'metode_pembayaran' => 'required|string',
            'status_pembayaran' => 'required|string',
            'bukti_pembayaran' => 'nullable|string',
            'tanggal_pembayaran' => 'required|date',
        ]);

        $payment = Payment::create($data);
        return response()->json($payment); 
    }

    public function show($noTransaksi)
    {
        $payment = Payment::where('no_transaksi', $noTransaksi)->firstOrFail();
        return response()->json($payment);
    }

    public function riwayat($id_user)
    {
        // Join payment dengan transaksi untuk dapatkan user dan info produk
        $riwayat = DB::table('payment')
            ->join('transaksi', 'payment.no_transaksi', '=', 'transaksi.no_transaksi')
            ->join('produk', 'transaksi.id_produk', '=', 'produk.id')
            ->select(
                'payment.no_transaksi',
                'payment.metode_pembayaran',
                'payment.status_pembayaran',
                'payment.bukti_pembayaran',
                'payment.tanggal_pembayaran',
                'transaksi.jumlah',
                'transaksi.total',
                'produk.nama as nama_produk',
                'produk.foto',
                'transaksi.status as status_transaksi',
                'transaksi.created_at as tanggal_transaksi'
            )
            ->where('transaksi.id_user', $id_user)
            ->orderBy('payment.created_at', 'desc')
            ->get();

        if ($riwayat->isEmpty()) {
            return response()->json([
                'message' => 'Belum ada riwayat pembayaran untuk user ini'
            ], 404);
        }

        return response()->json([
            'message' => 'Riwayat pembayaran ditemukan',
            'data' => $riwayat
        ]);
    }
}
