<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfoAdminduk;
use App\Models\Aktivitas;
use App\Models\NotifikasiAktivitas;
use Illuminate\Http\Request;

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
        ]);

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
        ]);

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
        $item->delete();

        $this->logAktivitas("Info Adminduk telah dihapus");
        $this->logNotifikasi("Info Adminduk telah dihapus");

        return redirect()->route('admin.adminduk.info.index')
            ->with('success', 'Info Adminduk berhasil dihapus.');
    }

    public function infoupload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');

            // bikin nama file unik + hilangkan spasi
            $filename = time() . '_' . preg_replace('/\s+/', '', $file->getClientOriginalName());

            // simpan ke folder storage/app/public/foto_adminduk
            $file->storeAs('foto_adminduk', $filename, 'public');

            // URL dinamis sesuai host yang sedang diakses
            $url = $request->getSchemeAndHttpHost() . '/storage/foto_adminduk/' . $filename;

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
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });

            return response()->json($data, 200);
        }
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
}
