<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Renbang;
use App\Models\Aktivitas;
use App\Models\NotifikasiAktivitas;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RenbangController extends Controller
{
    /**
     * INDEX DESKRIPSI
     */
    public function deskripsiIndex()
{
    // data utama yang ditampilkan di index (daftar renbang)
    $renbangItems = Renbang::latest()->get();

    // daftar kategori untuk keperluan filter/dropdown (opsional di index)
    $kategoriRenbangs = Kategori::where('fitur', 'deskripsi renbang')
        ->orderBy('nama')
        ->get();

    // kirim kedua variabel ke view
    return view('admin.renbang.deskripsi.index', compact('renbangItems', 'kategoriRenbangs'));
}

public function deskripsiCreate()
{
    // pastikan nama variabel sama dengan yang akan dipakai di blade create
    $kategoriRenbangs = Kategori::where('fitur', 'deskripsi renbang')
        ->orderBy('nama')
        ->get();

    return view('admin.renbang.deskripsi.create', compact('kategoriRenbangs'));
}

public function deskripsiEdit($id)
{
    $item = Renbang::findOrFail($id);

    $kategoriRenbangs = Kategori::where('fitur', 'deskripsi renbang')
        ->orderBy('nama')
        ->get();

    return view('admin.renbang.deskripsi.edit', compact('item', 'kategoriRenbangs'));
}

public function deskripsiStore(Request $request)
{
    $data = $request->validate([
        'judul'     => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'fitur'     => 'required|string|max:255', // ganti kategori jadi fitur
        'gambar'    => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,svg,bmp|max:5120',
        'alamat'    => 'required|string|max:255',
    ]);

    if ($request->hasFile('gambar')) {
        $data['gambar'] = $request->file('gambar')->store('renbang', 'public');
    }

    Renbang::create($data);

    $this->logAktivitas("Deskripsi Renbang telah ditambahkan");
    $this->logNotifikasi("Deskripsi Renbang telah ditambahkan");

    return redirect()->route('admin.renbang.deskripsi.index')
        ->with('success', 'Deskripsi Renbang berhasil ditambahkan.');
}

public function deskripsiUpdate(Request $request, $id)
{
    $item = Renbang::findOrFail($id);

    $data = $request->validate([
        'judul'     => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'fitur'     => 'required|string|max:255',
        'gambar'    => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,svg,bmp|max:5120',
        'alamat'    => 'required|string|max:255',
    ]);

    if ($request->hasFile('gambar')) {
        if ($item->gambar && Storage::disk('public')->exists($item->gambar)) {
            Storage::disk('public')->delete($item->gambar);
        }
        $data['gambar'] = $request->file('gambar')->store('renbang', 'public');
    }

    $item->update($data);

    $this->logAktivitas("Deskripsi Renbang telah diperbarui");
    $this->logNotifikasi("Deskripsi Renbang telah diperbarui");

    return redirect()->route('admin.renbang.deskripsi.index')
        ->with('success', 'Deskripsi Renbang berhasil diperbarui.');
}

public function deskripsiShow($id = null)
{
    if ($id) {
        $data = Renbang::with('kategori')->find($id);

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $arr = [
            'id'        => $data->id,
            'judul'     => $data->judul,
            'deskripsi' => $this->replaceImageUrlsInHtml($data->deskripsi),
            'fitur'     => $data->kategori->nama ?? ($data->fitur ?? null),
            'gambar'    => $data->gambar
                ? $this->buildFotoUrl($data->gambar)
                : null,
            'alamat'    => $data->alamat,
            'created_at'=> $data->created_at,
            'updated_at'=> $data->updated_at,
        ];

        return response()->json($arr, 200);
    } else {
        $data = Renbang::with('kategori')->latest()->get()->map(function ($item) {
            return [
                'id'        => $item->id,
                'judul'     => $item->judul,
                'deskripsi' => $this->replaceImageUrlsInHtml($item->deskripsi),
                'fitur'     => $item->kategori->nama ?? ($item->fitur ?? null),
                'gambar'    => $item->gambar
                    ? $this->buildFotoUrl($item->gambar)
                    : null,
                'alamat'    => $item->alamat,
                'created_at'=> $item->created_at,
                'updated_at'=> $item->updated_at,
            ];
        });

        return response()->json($data, 200);
    }
}

public function deskripsiUpload(Request $request)
{
    if ($request->hasFile('upload')) {
        $file = $request->file('upload');
        $filename = time() . '_' . preg_replace('/\s+/', '', $file->getClientOriginalName());

        // simpan ke storage/app/public/renbangs
        $path = $file->storeAs('renbangs', $filename, 'public');

        // buat URL absolut supaya CKEditor bisa akses gambar
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

    /**
     * Helper: mengganti semua <img src="..."> di deskripsi
     * agar selalu pakai host/domain yang sedang digunakan
     */
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

    /**
     * Helper: convert path simpanan jadi URL
     */
    private function buildFotoUrl($path)
    {
        return request()->getSchemeAndHttpHost() . '/storage/' . ltrim($path, '/');
    }

    protected function logAktivitas($pesan)
    {
        if (auth()->check()) {
            Aktivitas::create([
                'user_id' => auth()->id(),
                'tipe' => 'renbang',
                'keterangan' => $pesan,
            ]);
        }
    }

    protected function logNotifikasi($pesan)
    {
        NotifikasiAktivitas::create([
            'keterangan' => $pesan,
            'dibaca' => false,
            'url' => route('admin.renbang.deskripsi.index')
        ]);
    }
}
