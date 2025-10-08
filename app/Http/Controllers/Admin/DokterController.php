<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Puskesmas;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokterController extends Controller
{
    // --- Bagian Admin Panel (TIDAK DIUBAH) ---
    public function index()
    {
        $dokter = Dokter::with(['puskesmas', 'kategori'])->orderBy('id', 'desc')->get();
        return view('admin.sehat.dokter.index', compact('dokter'));
    }

    public function create()
    {
        $puskesmas = Puskesmas::orderBy('nama')->get();
        $kategoriDokter = Kategori::where('fitur', 'dokter')->orderBy('nama')->get();

        return view('admin.sehat.dokter.create', compact('puskesmas', 'kategoriDokter'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_puskesmas' => 'required|integer|exists:puskesmas,id',
            'nama'         => 'required|string|max:255',
            'pendidikan'   => 'required|string|max:255',
            'fitur'        => 'required|string',
            'masa_kerja'   => 'required|string|max:255',
            'nomer'        => 'required|string|max:255',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('dokter_foto', 'public');
            $validated['foto'] = $path;
        }

        $validated['admin_id'] = auth('admin')->id();

        Dokter::create($validated);

        return redirect()->route('admin.sehat.dokter.index')
            ->with('success', 'Data dokter berhasil ditambahkan');
    }

    public function edit(Dokter $dokter)
    {
        $puskesmas = Puskesmas::orderBy('nama')->get();
        $kategoriDokter = Kategori::where('fitur', 'dokter')->orderBy('nama')->get();

        return view('admin.sehat.dokter.edit', compact('dokter', 'puskesmas', 'kategoriDokter'));
    }

    public function update(Request $request, Dokter $dokter)
    {
        $validated = $request->validate([
            'id_puskesmas' => 'required|integer|exists:puskesmas,id',
            'nama'         => 'required|string|max:255',
            'pendidikan'   => 'required|string|max:255',
            'fitur'        => 'required|string',
            'masa_kerja'   => 'required|string|max:255',
            'nomer'        => 'required|string|max:255',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            if ($dokter->foto && Storage::disk('public')->exists($dokter->foto)) {
                Storage::disk('public')->delete($dokter->foto);
            }
            $path = $request->file('foto')->store('dokter_foto', 'public');
            $validated['foto'] = $path;
        }

        $validated['admin_id'] = auth('admin')->id();

        $dokter->update($validated);

        return redirect()->route('admin.sehat.dokter.index')
            ->with('success', 'Data dokter berhasil diperbarui');
    }

    public function destroy(Dokter $dokter)
    {
        if ($dokter->foto) {
            Storage::disk('public')->delete($dokter->foto);
        }

        $dokter->delete();
        return redirect()->route('admin.sehat.dokter.index')
            ->with('success', 'Data dokter berhasil dihapus');
    }

    // ===================== API ===================== //

    // --- FUNGSI INI TELAH DIPERBAIKI ---
    public function apiIndex(Request $request)
    {
        // Mulai query builder, jangan langsung get()
        $query = Dokter::with('puskesmas')->orderBy('id', 'desc');

        // Cek apakah ada parameter 'puskesmas_id' di request
        if ($request->has('puskesmas_id')) {
            // Jika ada, filter berdasarkan ID tersebut
            $query->where('id_puskesmas', $request->puskesmas_id);
        }

        // Eksekusi query
        $dokter = $query->get()->map(function ($d) {
            $d->foto_url = $this->buildFotoUrl($d->foto);
            unset($d->foto);
            return $d;
        });

        return response()->json($dokter);
    }

    public function apiShow($id = null)
    {
        if ($id) {
            $dokter = Dokter::with('puskesmas')->find($id);
            if (!$dokter) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
            $dokter->foto_url = $this->buildFotoUrl($dokter->foto);
            unset($dokter->foto);
            return response()->json($dokter);
        }

        // Blok ini sekarang menjadi redundan karena sudah ditangani oleh apiIndex,
        // namun kita biarkan saja agar tidak mengubah struktur yang sudah ada.
        $dokter = Dokter::with('puskesmas')->get()->map(function ($d) {
            $d->foto_url = $this->buildFotoUrl($d->foto);
            unset($d->foto);
            return $d;
        });

        return response()->json($dokter);
    }

    // --- Sisa kode (Helper Gambar) tidak diubah ---
    private function getStoragePathFromFoto($foto)
    {
        if (!$foto) return null;
        if (strpos($foto, 'http://') !== 0 && strpos($foto, 'https://') !== 0) {
            return $foto;
        }
        if (preg_match('#/storage/(.+)$#', $foto, $matches)) {
            return $matches[1];
        }
        $path = parse_url($foto, PHP_URL_PATH);
        if ($path) {
            $path = ltrim($path, '/');
            if (strpos($path, 'storage/') === 0) {
                return substr($path, strlen('storage/'));
            }
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
            if (preg_match('/^data:/i', $src)) {
                return $m[0];
            }
            if (preg_match('/^https?:\/\//i', $src)) {
                if (preg_match('#/storage/(.+)#i', $src, $matches)) {
                    $rel = $matches[1];
                    $new = request()->getSchemeAndHttpHost() . '/storage/' . ltrim($rel, '/');
                    return $prefix . $new . $suffix;
                }
                if (preg_match('#/(uploads/.+)$#i', $src, $m2)) {
                    $rel = $m2[1];
                    $new = request()->getSchemeAndHttpHost() . '/storage/' . ltrim($rel, '/');
                    return $prefix . $new . $suffix;
                }
                return $m[0];
            }
            $parsedPath = $src;
            if (strpos($parsedPath, '/storage/') === 0) {
                $rel = ltrim(substr($parsedPath, strlen('/storage/')), '/');
                $new = request()->getSchemeAndHttpHost() . '/storage/' . $rel;
                return $prefix . $new . $suffix;
            }
            if (strpos($parsedPath, '/uploads/') === 0) {
                $rel = ltrim($parsedPath, '/');
                $new = request()->getSchemeAndHttpHost() . '/storage/' . $rel;
                return $prefix . $new . $suffix;
            }
            if (preg_match('#^(uploads/|foto_dokter/|dokter_foto/)#i', $parsedPath)) {
                $new = request()->getSchemeAndHttpHost() . '/storage/' . ltrim($parsedPath, '/');
                return $prefix . $new . $suffix;
            }
            return $m[0];
        }, $content);
    }
}