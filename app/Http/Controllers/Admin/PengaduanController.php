<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Validator;
use App\Models\Aktivitas;

class PengaduanController extends Controller
{
    /**
     * GET semua pengaduan (web dan api).
     */
    public function index(Request $request)
    {
        $pengaduans = Pengaduan::latest()->get();

        if ($request->wantsJson()) {
            return response()->json($pengaduans, 200);
        }

        return view('admin.pengaduan.index', compact('pengaduans'));
    }

    /**
     * GET detail pengaduan by ID (web dan api).
     */
    public function show(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        if ($request->wantsJson()) {
            return response()->json($pengaduan, 200);
        }

        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    /**
     * Form edit (khusus web).
     */
    public function edit($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        return view('admin.pengaduan.edit', compact('pengaduan'));
    }

    /**
     * PUT update status & tanggapan (web dan api).
     */
    public function update(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:masuk,diproses,selesai,ditolak',
            'tanggapan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            return back()->withErrors($validator)->withInput();
        }

        $pengaduan->update($request->only('status', 'tanggapan'));

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Berhasil diperbarui', 'data' => $pengaduan], 200);
        }

        return redirect()->route('admin.pengaduan.index')->with('success', 'Pengaduan diperbarui');
    }

    /**
     * DELETE pengaduan (web dan api).
     */
    public function destroy(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        if ($pengaduan->bukti_laporan && file_exists(public_path($pengaduan->bukti_laporan))) {
            unlink(public_path($pengaduan->bukti_laporan));
        }

        $pengaduan->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Berhasil dihapus'], 200);
        }

        return redirect()->route('admin.pengaduan.index')->with('success', 'Pengaduan dihapus');
    }

    /**
     * POST kirim pengaduan (API only).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_laporan' => 'required|string',
            'kategori_laporan' => 'required|string',
            'lokasi_laporan' => 'nullable|string',
            'deskripsi' => 'required|string',
            'bukti_laporan' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'pernyataan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        if ($request->hasFile('bukti_laporan')) {
            $file = $request->file('bukti_laporan');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pengaduan'), $filename);
            $data['bukti_laporan'] = 'uploads/pengaduan/' . $filename;
        }

        $pengaduan = Pengaduan::create($data);

        Aktivitas::create([
            'keterangan' => 'Aduan masyarakat baru masuk',
            'tipe' => 'Pengaduan',
            'url' => route('admin.pengaduan.index', $pengaduan->id), 
        ]);


        return response()->json([
            'message' => 'Pengaduan berhasil dikirim',
            'data' => $pengaduan
        ], 201);
    }
}
