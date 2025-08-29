<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfoPajak;
use App\Models\Aktivitas;
use App\Models\NotifikasiAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PajakController extends Controller
{
    public function infoindex()
    {
        $infoItems = InfoPajak::latest()->get();
        return view('admin.pajak.info.index', compact('infoItems'));
    }

    public function infocreate()
    {
        return view('admin.pajak.info.create');
    }

    public function infostore(Request $request)
    {
        $data = $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,svg,bmp|max:5120',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_pajak', 'public');
        }

        InfoPajak::create($data);

        $this->logAktivitas("Info Pajak telah ditambahkan");
        $this->logNotifikasi("Info Pajak telah ditambahkan");

        return redirect()->route('admin.pajak.info.index')->with('success', 'Info pajak berhasil ditambahkan.');
    }

    public function infoedit($id)
    {
        $info = InfoPajak::findOrFail($id);
        return view('admin.pajak.info.edit', compact('info'));
    }

    public function infoupdate(Request $request, $id)
    {
        $info = InfoPajak::findOrFail($id);

        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,svg,bmp|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            $oldPath = $this->getStoragePathFromFoto($info->foto);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            $data['foto'] = $request->file('foto')->store('foto_pajak', 'public');
        }

        $info->update($data);

        $this->logAktivitas("Info Pajak telah diupdate");
        $this->logNotifikasi("Info Pajak telah diupdate");

        return redirect()->route('admin.pajak.info.index')->with('success', 'Info pajak berhasil diperbarui.');
    }

    public function infodestroy($id)
    {
        $info = InfoPajak::findOrFail($id);

        if ($info->foto) {
            $oldPath = $this->getStoragePathFromFoto($info->foto);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        $info->delete();

        $this->logAktivitas("Info Pajak telah dihapus");
        $this->logNotifikasi("Info Pajak telah dihapus");

        return back()->with('success', 'Info pajak berhasil dihapus.');
    }

    public function upload(Request $request)
{
    if ($request->hasFile('upload')) {
        $file = $request->file('upload');
        $filename = time() . '_' . preg_replace('/\s+/', '', $file->getClientOriginalName());

        // simpan ke storage/app/public/uploads -> hasilnya "uploads/namafile.jpg"
        $path = $file->storeAs('uploads', $filename, 'public');

        // kirim ke CKEditor relative path, bukan absolute
        // CKEditor butuh URL, jadi kita kasih absolute berdasarkan host sekarang
        $url = request()->getSchemeAndHttpHost() . '/storage/' . $path;

        return response()->json([
            'uploaded' => true,
            'url' => $url
        ]);
    }

    return response()->json([
        'uploaded' => false,
        'error' => [
            'message' => 'No file uploaded'
        ]
    ], 400);
}

    public function infoshow($id = null)
    {
        if ($id) {
            $data = InfoPajak::find($id);

            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $arr = [
                'id'         => $data->id,
                'judul'      => $data->judul,
                'deskripsi'  => $this->replaceImageUrlsInHtml($data->deskripsi),
                'foto'       => $data->foto
                    ? $this->buildFotoUrl($this->getStoragePathFromFoto($data->foto))
                    : null,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            ];

            return response()->json($arr, 200);
        } else {
            $data = InfoPajak::all()->map(function ($item) {
                return [
                    'id'         => $item->id,
                    'judul'      => $item->judul,
                    'deskripsi'  => $this->replaceImageUrlsInHtml($item->deskripsi),
                    'foto'       => $item->foto
                        ? $this->buildFotoUrl($this->getStoragePathFromFoto($item->foto))
                        : null,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });

            return response()->json($data, 200);
        }
    }

    private function replaceImageUrlsInHtml($content)
{
    if (!$content) return $content;

    return preg_replace_callback('/(<img\b[^>]*\bsrc\s*=\s*[\'"])([^\'"]+)([\'"][^>]*>)/i', function ($m) {
        $prefix = $m[1];
        $src = $m[2];
        $suffix = $m[3];

        // Biarkan data URI
        if (preg_match('/^data:/i', $src)) {
            return $m[0];
        }

        // CASE 1: absolute URL dengan /storage/
        if (preg_match('#^https?://[^/]+/storage/(.+)$#i', $src, $matches)) {
            $rel = $matches[1];
            $new = request()->getSchemeAndHttpHost() . '/storage/' . ltrim($rel, '/');
            return $prefix . $new . $suffix;
        }

        // CASE 2: absolute URL dengan /uploads/, /foto_kesehatan/, /tempat_olahraga/
        if (preg_match('#^https?://[^/]+/(uploads/.+|foto_kesehatan/.+|tempat_olahraga/.+)$#i', $src, $matches)) {
            $rel = $matches[1];
            $new = request()->getSchemeAndHttpHost() . '/storage/' . ltrim($rel, '/');
            return $prefix . $new . $suffix;
        }

        // CASE 3: relative path (uploads/xxx.jpg, foto_kesehatan/xxx.jpg, dst)
        if (preg_match('#^(uploads/|foto_kesehatan/|tempat_olahraga/)#i', $src)) {
            $new = request()->getSchemeAndHttpHost() . '/storage/' . ltrim($src, '/');
            return $prefix . $new . $suffix;
        }

        // CASE 4: path diawali /storage/
        if (strpos($src, '/storage/') === 0) {
            $rel = ltrim(substr($src, strlen('/storage/')), '/');
            $new = request()->getSchemeAndHttpHost() . '/storage/' . $rel;
            return $prefix . $new . $suffix;
        }

        // selain itu (CDN atau external image) → biarkan
        return $m[0];
    }, $content);
}


    protected function logAktivitas($pesan)
    {
        if (auth()->check()) {
            Aktivitas::create([
                'user_id' => auth()->id(),
                'tipe' => 'sekolah',
                'keterangan' => $pesan,
            ]);
        }
    }

    protected function logNotifikasi($pesan)
    {
        NotifikasiAktivitas::create([
            'keterangan' => $pesan,
            'dibaca' => false,
            'url' => route('admin.ibadah.tempat.index') // route yang valid
        ]);
    }

    private function buildFotoUrl($path)
{
    if (!$path) {
        return null;
    }

    // kembalikan URL publik untuk file di storage
    return asset('storage/' . ltrim($path, '/'));
}

private function getStoragePathFromFoto($foto)
{
    if (!$foto) {
        return null;
    }

    // misalnya foto sudah tersimpan "foto_sekolah/namafile.png"
    return ltrim($foto, '/');
}
}
