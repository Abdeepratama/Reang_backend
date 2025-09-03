<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InfoKerja;
use App\Models\Kategori;
use App\Models\Aktivitas;
use App\Models\NotifikasiAktivitas;
use Illuminate\Support\Facades\Storage;

class KerjaController extends Controller
{
    public function infoindex()
    {
        $infoItems = InfoKerja::with('kategori')->get();

        return view('admin.kerja.info.index', compact('infoItems'));
    }

    public function infocreate()
    {
        $kategoriKerja = Kategori::where('fitur', 'Kerja')->orderBy('nama')->get();
        return view('admin.kerja.info.create', ['kategoriKerja' => $kategoriKerja]);
    }

    public function infostore(Request $request)
    {
        $data = $request->validate([
            'foto'          => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,svg,bmp|max:5120',
            'name'          => 'required|string',
            'judul'         => 'required|string|max:255',
            'alamat'        => 'required|string',
            'gaji'          => 'nullable|string|max:255',
            'nomor_telepon' => 'nullable|string|max:50',
            'waktu_kerja'   => 'nullable|string|max:255',
            'jenis_kerja'   => 'nullable|string|max:255',
            'fitur'         => 'required|string|max:255',
            'deskripsi'     => 'required|string',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_kerja', 'public');
        }

        InfoKerja::create($data);

        $this->logAktivitas("Info Kerja telah ditambahkan");
        $this->logNotifikasi("Info Kerja telah ditambahkan");


        return redirect()->route('admin.kerja.info.index')->with('success', 'Info kerja berhasil ditambahkan.');
    }

    public function infoedit($id)
    {
        $info = InfoKerja::findOrFail($id);
        $kategoriKerja = Kategori::where('fitur', 'Kerja')->get();

        return view('admin.kerja.info.edit', [
            'info' => $info,
            'kategoriKerja' => $kategoriKerja,
            
        ]);
    }

    public function infoupdate(Request $request, $id)
    {
        $info = InfoKerja::findOrFail($id);

        $data = $request->validate([
            'judul'         => 'required|string|max:255',
            'name'          => 'required|string',
            'alamat'        => 'required|string',
            'gaji'          => 'nullable|string|max:255',
            'nomor_telepon' => 'nullable|string|max:50',
            'waktu_kerja'   => 'nullable|string|max:255',
            'jenis_kerja'   => 'nullable|string|max:255',
            'fitur'         => 'required|string|max:255',
            'deskripsi'     => 'required|string',
            'foto'          => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,svg,bmp|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            $oldPath = $this->getStoragePathFromFoto($info->foto);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            $data['foto'] = $request->file('foto')->store('foto_kerja', 'public');
        }

        $info->update($data);

        $this->logAktivitas("Info Kerja telah diupdate");
        $this->logNotifikasi("Info Kerja telah diupdate");

        return redirect()->route('admin.kerja.info.index')->with('success', 'Info kerja berhasil diperbarui.');
    }

    public function infodestroy($id)
    {
        $info = InfoKerja::findOrFail($id);

        if ($info->foto) {
            $oldPath = $this->getStoragePathFromFoto($info->foto);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        $info->delete();

        $this->logAktivitas("Info Kerja telah dihapus");
        $this->logNotifikasi("Info Kerja telah dihapus");

        return back()->with('success', 'Info kerja berhasil dihapus.');
    }

    public function infoshow($id = null)
    {
        if ($id) {
            $data = InfoKerja::with('kategori')->find($id);

            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $arr = [
                'id'                => $data->id,
                'Nama Perusahaan'   => $data->name,
                'Posisi'            => $data->judul,
                'alamat'            => $data->alamat,
                'gaji'              => $data->gaji,
                'nomor_telepon'     => $data->nomor_telepon,
                'waktu_kerja'       => $data->waktu_kerja,
                'jenis_kerja'       => $data->jenis_kerja,
                'foto'              => $data->foto ? $this->buildFotoUrl($this->getStoragePathFromFoto($data->foto)) : null,
                'kategori'          => $data->kategori->nama ?? ($data->fitur ?? null),
                'deskripsi'         => $this->replaceImageUrlsInHtml($data->deskripsi),
                'created_at'        => $data->created_at,
                'updated_at'        => $data->updated_at,
            ];

            return response()->json($arr, 200);
        } else {
            $data = InfoKerja::with('kategori')->get()->map(function ($item) {
                return [
                    'id'               => $item->id,
                    'Nama Perusahaan'  => $item->name,
                    'Posisi'           => $item->judul,
                    'alamat'           => $item->alamat,
                    'gaji'             => $item->gaji,
                    'nomor_telepon'    => $item->nomor_telepon,
                    'waktu_kerja'      => $item->waktu_kerja,
                    'jenis_kerja'      => $item->jenis_kerja,
                    'foto'             => $item->foto ? $this->buildFotoUrl($this->getStoragePathFromFoto($item->foto)) : null,
                    'kategori'         => $item->kategori->nama ?? ($item->fitur ?? null),
                    'deskripsi'        => $this->replaceImageUrlsInHtml($item->deskripsi),
                    'created_at'       => $item->created_at,
                    'updated_at'       => $item->updated_at,
                ];
            });

            return response()->json($data, 200);
        }
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . preg_replace('/\s+/', '', $file->getClientOriginalName());

            $path = $file->storeAs('uploads', $filename, 'public');
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

    protected function logAktivitas($pesan)
    {
        if (auth()->check()) {
            Aktivitas::create([
                'user_id' => auth()->id(),
                'tipe' => 'kerja',
                'keterangan' => $pesan,
            ]);
        }
    }

    protected function logNotifikasi($pesan)
    {
        NotifikasiAktivitas::create([
            'keterangan' => $pesan,
            'dibaca' => false,
            'url' => route('admin.kerja.info.index')
        ]);
    }

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

                // kalau relative path (misal: foto_sekolah/abc.jpg)
                $new = $currentHost . '/storage/' . ltrim($src, '/');
                return str_replace($src, $new, $matches[0]);
            },
            $html
        );
    }

    private function buildFotoUrl($path)
    {
        if (!$path) {
            return null;
        }
        return asset('storage/' . ltrim($path, '/'));
    }

    private function getStoragePathFromFoto($foto)
    {
        if (!$foto) {
            return null;
        }
        return ltrim($foto, '/');
    }
}
