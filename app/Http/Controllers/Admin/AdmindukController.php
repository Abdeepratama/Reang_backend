<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfoAdminduk;
use App\Models\Aktivitas;
use App\Models\NotifikasiAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdmindukController extends Controller
{
    public function infoindex()
    {
        $infoItems = InfoAdminduk::all();
        return view('admin.adminduk.info.index', compact('infoItems'));
    }

    /**
     * FORM TAMBAH INFO ADMIN DUK
     */
    public function infocreate()
    {
        return view('admin.adminduk.info.create');
    }

    /**
     * SIMPAN INFO ADMIN DUK
     */
    public function infostore(Request $request)
    {
        $validated = $request->validate([
            'judul'      => 'required|string|max:255',
            'deskripsi'  => 'required|string',
            'foto'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fotoName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('foto_adminduk', $fotoName, 'public');
            $validated['foto'] = $path;
        }

        InfoAdminduk::create($validated);

        $this->logAktivitas("Info Adminduk telah ditambahkan");
        $this->logNotifikasi("Info Adminduk telah ditambahkan");

        return redirect()->route('admin.adminduk.info.index')
            ->with('success', 'Info Adminduk berhasil ditambahkan.');
    }

    /**
     * FORM EDIT INFO ADMIN DUK
     */
    public function infoedit($id)
    {
        $item = InfoAdminduk::findOrFail($id);
        return view('admin.adminduk.info.edit', compact('item'));
    }

    /**
     * UPDATE INFO ADMIN DUK
     */
    public function infoupdate(Request $request, $id)
    {
        $item = InfoAdminduk::findOrFail($id);

        $validated = $request->validate([
            'judul'      => 'required|string|max:255',
            'deskripsi'  => 'required|string',
            'foto'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($item->foto) {
                Storage::disk('public')->delete($item->foto);
            }
            $validated['foto'] = $request->file('foto')->store('foto_adminduk', 'public');
        }

        $item->update($validated);

        $this->logAktivitas("Info Adminduk telah diupdate");
        $this->logNotifikasi("Info Adminduk telah diupdate");

        return redirect()->route('admin.adminduk.info.index')
            ->with('success', 'Info Adminduk berhasil diupdate.');
    }

    /**
     * HAPUS INFO ADMIN DUK
     */
    public function infodestroy($id)
    {
        $item = InfoAdminduk::findOrFail($id);
        if ($item->foto) Storage::disk('public')->delete($item->foto);
        $item->delete();

        $this->logAktivitas("Info Adminduk telah dihapus");
        $this->logNotifikasi("Info Adminduk telah dihapus");

        return redirect()->route('admin.adminduk.info.index')
            ->with('success', 'Info Adminduk berhasil dihapus.');
    }

    /**
     * SHOW / LIST INFO ADMIN DUK (API)
     */
    public function infoshow($id = null)
    {
        if ($id) {
            $data = InfoAdminduk::find($id);

            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $arr = [
                'id'         => $data->id,
                'judul'      => $data->judul,
                'deskripsi'  => $this->replaceImageUrlsInHtml($data->deskripsi),
                'foto'       => $data->foto ? $this->buildFotoUrl($this->getStoragePathFromFoto($data->foto)) : null,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            ];

            return response()->json($arr, 200);
        } else {
            $data = InfoAdminduk::latest()->get()->map(function ($item) {
                return [
                    'id'         => $item->id,
                    'judul'      => $item->judul,
                    'deskripsi'  => $this->replaceImageUrlsInHtml($item->deskripsi),
                    'foto'       => $item->foto ? $this->buildFotoUrl($this->getStoragePathFromFoto($item->foto)) : null,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });

            return response()->json($data, 200);
        }
    }

    /**
     * UPLOAD UNTUK CKEDITOR
     */
    public function infoupload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . preg_replace('/\s+/', '', $file->getClientOriginalName());

            $path = $file->storeAs('foto_adminduk', $filename, 'public');
            $url = $request->getSchemeAndHttpHost() . '/storage/' . $path;

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

                // kalau data:image (base64), biarkan
                if (preg_match('/^data:/i', $src)) {
                    return $matches[0];
                }

                // kalau absolute URL tapi bukan host sekarang → ganti
                if (preg_match('#^https?://[^/]+/(.+)$#i', $src, $m)) {
                    $path = $m[1];
                    $new  = $currentHost . '/' . ltrim($path, '/');
                    return str_replace($src, $new, $matches[0]);
                }

                // kalau relative path (misal: foto_adminduk/abc.jpg)
                $new = $currentHost . '/storage/' . ltrim($src, '/');
                return str_replace($src, $new, $matches[0]);
            },
            $html
        );
    }

    /**
     * LOG AKTIVITAS
     */
    protected function logAktivitas($pesan)
    {
        if (auth()->check()) {
            Aktivitas::create([
                'user_id'    => auth()->id(),
                'tipe'       => 'adminduk',
                'keterangan' => $pesan,
            ]);
        }
    }

    /**
     * LOG NOTIFIKASI
     */
    protected function logNotifikasi($pesan)
    {
        NotifikasiAktivitas::create([
            'keterangan' => $pesan,
            'dibaca'     => false,
            'url'        => route('admin.adminduk.info.index') // route yang valid
        ]);
    }

    private function buildFotoUrl($path)
    {
        if (!$path) {
            return null;
        }
        return asset('storage/' . ltrim($path, '/'));
    }

    /**
     * Helper: ambil path relatif dari foto (tanpa slash awal)
     */
    private function getStoragePathFromFoto($foto)
    {
        if (!$foto) {
            return null;
        }
        return ltrim($foto, '/');
    }
}
