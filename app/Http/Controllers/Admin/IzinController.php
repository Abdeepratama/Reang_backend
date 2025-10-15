<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfoPerizinan;
use App\Models\Kategori;
use App\Models\Aktivitas;
use App\Models\NotifikasiAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IzinController extends Controller
{
    public function infoindex()
    {
        $infoItems = InfoPerizinan::with('kategori')->get();
        return view('admin.izin.info.index', compact('infoItems'));
    }

    public function infocreate()
    {
        $kategoriPerizinan = Kategori::where('fitur', 'Info perizinan')
            ->orderBy('nama')
            ->get();

        return view('admin.izin.info.create', [
            'kategoriPerizinan' => $kategoriPerizinan,
        ]);
    }

    public function infostore(Request $request)
    {
        $data = $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,svg,bmp|max:5120',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'fitur' => 'required|string|max:255',
            'kategori_id' => 'nullable|exists:kategori,id',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_perizinan', 'public');
        }

        InfoPerizinan::create($data);

        $this->logAktivitas("Info Perizinan telah ditambahkan");
        $this->logNotifikasi("Info Perizinan telah ditambahkan");

        return redirect()->route('admin.izin.info.index')->with('success', 'Info perizinan berhasil ditambahkan.');
    }

    public function infoedit($id)
    {
        $info = InfoPerizinan::findOrFail($id);
        $kategoriPerizinan = Kategori::where('fitur', 'Info perizinan')->get();

        return view('admin.izin.info.edit', [
            'info' => $info,
            'kategoriPerizinan' => $kategoriPerizinan,
        ]);
    }

    public function infoupdate(Request $request, $id)
    {
        $info = InfoPerizinan::findOrFail($id);

        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'fitur' => 'required|string|max:255',
            'kategori_id' => 'nullable|exists:kategori,id',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,svg,bmp|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            $oldPath = $this->getStoragePathFromFoto($info->foto);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            $data['foto'] = $request->file('foto')->store('foto_perizinan', 'public');
        }

        $info->update($data);

        $this->logAktivitas("Info Perizinan telah diupdate");
        $this->logNotifikasi("Info Perizinan telah diupdate");

        return redirect()->route('admin.izin.info.index')->with('success', 'Info perizinan berhasil diperbarui.');
    }

    public function infodestroy($id)
    {
        $info = InfoPerizinan::findOrFail($id);

        if ($info->foto) {
            $oldPath = $this->getStoragePathFromFoto($info->foto);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        $info->delete();

        $this->logAktivitas("Info Perizinan telah dihapus");
        $this->logNotifikasi("Info Perizinan telah dihapus");

        return back()->with('success', 'Info perizinan berhasil dihapus.');
    }

    public function infoshowDetail($id)
    {
        $info = InfoPerizinan::findOrFail($id);
        return view('admin.izin.info.show', compact('info'));
    }

    public function infoshow($id = null)
    {
        if ($id) {
            $data = InfoPerizinan::with('kategori')->find($id);
            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            return response()->json([
                'id'         => $data->id,
                'judul'      => $data->judul,
                'deskripsi'  => $this->replaceImageUrlsInHtml($data->deskripsi),
                'foto'       => $data->foto ? $this->buildFotoUrl($this->getStoragePathFromFoto($data->foto)) : null,
                'kategori'   => $data->kategori->nama ?? ($data->fitur ?? null),
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            ], 200);
        }

        $data = InfoPerizinan::with('kategori')->get()->map(function ($item) {
            return [
                'id'         => $item->id,
                'judul'      => $item->judul,
                'deskripsi'  => $this->replaceImageUrlsInHtml($item->deskripsi),
                'foto'       => $item->foto ? $this->buildFotoUrl($this->getStoragePathFromFoto($item->foto)) : null,
                'kategori'   => $item->kategori->nama ?? ($item->fitur ?? null),
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });

        return response()->json($data, 200);
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . preg_replace('/\s+/', '', $file->getClientOriginalName());
            $path = $file->storeAs('uploads', $filename, 'public');
            $url = request()->getSchemeAndHttpHost() . '/storage/' . $path;

            return response()->json(['uploaded' => true, 'url' => $url]);
        }

        return response()->json([
            'uploaded' => false,
            'error' => ['message' => 'No file uploaded']
        ], 400);
    }

    // === Utility methods (copied dari versi Kesehatan) ===
    protected $aktivitasTipe = 'kerja';

    protected function logAktivitas($pesan)
    {
        if (auth()->check()) {
            $user = auth()->user();

            // untuk role/dinas yang melakukan aksi
            Aktivitas::create([
                'user_id'      => $user->id,
                'tipe'         => $this->aktivitasTipe,
                'keterangan'   => $pesan,
                'role'         => $user->role,
                'id_instansi'  => $user->id_instansi,
            ]);
        }
    }

    protected function logNotifikasi($pesan)
    {
        $user = auth()->user();

        NotifikasiAktivitas::create([
            'keterangan'   => $pesan,
            'dibaca'       => false,
            'url'          => route('admin.izin.info.index'),
            'role'         => $user->role,
            'id_instansi'  => $user->id_instansi,
        ]);
    }

    private function getStoragePathFromFoto($foto)
    {
        if (!$foto) return null;
        if (strpos($foto, 'http://') !== 0 && strpos($foto, 'https://') !== 0) return $foto;
        if (preg_match('#/storage/(.+)$#', $foto, $matches)) return $matches[1];
        $path = parse_url($foto, PHP_URL_PATH);
        if ($path) {
            $path = ltrim($path, '/');
            if (strpos($path, 'storage/') === 0) return substr($path, strlen('storage/'));
            return $path;
        }
        return null;
    }

    private function buildFotoUrl($storagePath)
    {
        if (!$storagePath) return null;
        return request()->getSchemeAndHttpHost() . '/storage/' . ltrim($storagePath, '/');
    }

    private function replaceImageUrlsInHtml($content)
    {
        if (!$content) return $content;

        return preg_replace_callback('/(<img\b[^>]*\bsrc\s*=\s*[\'"])([^\'"]+)([\'"][^>]*>)/i', function ($m) {
            $prefix = $m[1];
            $src = $m[2];
            $suffix = $m[3];

            if (preg_match('/^data:/i', $src)) return $m[0];

            if (preg_match('#^https?://[^/]+/storage/(.+)$#i', $src, $matches)) {
                $rel = $matches[1];
                $new = request()->getSchemeAndHttpHost() . '/storage/' . ltrim($rel, '/');
                return $prefix . $new . $suffix;
            }

            if (preg_match('#^https?://[^/]+/(uploads/.+|foto_perizinan/.+)$#i', $src, $matches)) {
                $rel = $matches[1];
                $new = request()->getSchemeAndHttpHost() . '/storage/' . ltrim($rel, '/');
                return $prefix . $new . $suffix;
            }

            if (preg_match('#^(uploads/|foto_perizinan/)#i', $src)) {
                $new = request()->getSchemeAndHttpHost() . '/storage/' . ltrim($src, '/');
                return $prefix . $new . $suffix;
            }

            if (strpos($src, '/storage/') === 0) {
                $rel = ltrim(substr($src, strlen('/storage/')), '/');
                $new = request()->getSchemeAndHttpHost() . '/storage/' . $rel;
                return $prefix . $new . $suffix;
            }

            return $m[0];
        }, $content);
    }
}
