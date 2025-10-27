<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
    // TAMPILAN DAFTAR OWNER
    public function index()
    {
        $user = Auth::guard('admin')->user();

        if ($user->role === 'superadmin' || $user->role === 'admindinas') {
            $owner = Owner::with('umkm')->latest()->get();
        } else {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('admin.pasar.umkm.owner.index', compact('owner'));
    }

    // FORM TAMBAH
    public function create()
    {
        $umkm = Umkm::orderBy('nama')->get();
        return view('admin.pasar.umkm.owner.create', compact('umkm'));
    }

    // SIMPAN DATA
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_umkm' => 'required|exists:umkm,id',
            'nama'    => 'required|string|max:255',
            'no_hp'   => 'required|string|max:20',
            'alamat'  => 'required|string|max:255',
            'foto'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('owner_foto', 'public');
            $validated['foto'] = $path;
        }

        Owner::create($validated);

        return redirect()->route('admin.pasar.umkm.owner.index')->with('success', 'Data owner berhasil ditambahkan.');
    }

    // FORM EDIT
    public function edit(Owner $owner)
    {
        $umkm = Umkm::orderBy('nama')->get();
        return view('admin.pasar.owner.edit', compact('owner', 'umkm'));
    }

    // UPDATE DATA
    public function update(Request $request, Owner $owner)
    {
        $validated = $request->validate([
            'id_umkm' => 'required|exists:umkm,id',
            'nama'    => 'required|string|max:255',
            'no_hp'   => 'required|string|max:20',
            'alamat'  => 'required|string|max:255',
            'foto'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            if ($owner->foto && Storage::disk('public')->exists($owner->foto)) {
                Storage::disk('public')->delete($owner->foto);
            }
            $path = $request->file('foto')->store('owner_foto', 'public');
            $validated['foto'] = $path;
        }

        $owner->update($validated);

        return redirect()->route('admin.pasar.umkm.owner.index')->with('success', 'Data owner berhasil diperbarui.');
    }

    // HAPUS DATA
    public function destroy(Owner $owner)
    {
        if ($owner->foto) {
            Storage::disk('public')->delete($owner->foto);
        }

        $owner->delete();

        return redirect()->route('admin.pasar.umkm.owner.index')->with('success', 'Data owner berhasil dihapus.');
    }

    // ===================== API ===================== //

    // --- FUNGSI INI TELAH DIPERBAIKI ---
    public function apiIndex(Request $request)
    {
        // Mulai query builder
        $query = Owner::with('umkm')->orderBy('id', 'desc');

        // Cek apakah ada parameter 'umkm_id' di request
        if ($request->has('umkm_id')) {
            $query->where('id_umkm', $request->umkm_id);
        }

        // Eksekusi query
        $owners = $query->get()->map(function ($o) {
            $o->foto_url = $this->buildFotoUrl($o->foto);
            unset($o->foto);
            return $o;
        });

        return response()->json($owners);
    }

    public function apiShow($id = null)
    {
        if ($id) {
            $owner = Owner::with('umkm')->find($id);
            if (!$owner) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
            $owner->foto_url = $this->buildFotoUrl($owner->foto);
            unset($owner->foto);
            return response()->json($owner);
        }

        // Jika tidak ada ID, tampilkan semua (fallback)
        $owners = Owner::with('umkm')->get()->map(function ($o) {
            $o->foto_url = $this->buildFotoUrl($o->foto);
            unset($o->foto);
            return $o;
        });

        return response()->json($owners);
    }

    // --- FUNGSI TAMBAHAN SEPERTI DI DOKTERCONTROLLER ---
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
        return preg_replace_callback('/(<img\b[^>]\bsrc\s=\s*[\'"])([^\'"]+)([\'"][^>]*>)/i', function ($m) {
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
                    return $prefix + $new + $suffix;
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
            if (preg_match('#^(uploads/|foto_owner/|owner_foto/)#i', $parsedPath)) {
                $new = request()->getSchemeAndHttpHost() . '/storage/' . ltrim($parsedPath, '/');
                return $prefix . $new . $suffix;
            }
            return $m[0];
        }, $content);
    }

    // --- TAMBAHAN SESUAI PERMINTAAN ---
    public function apiShowByUmkm($umkmId)
    {
        $owner = Owner::with('umkm')->where('id_umkm', $umkmId)->first();

        if (!$owner) {
            return response()->json(['message' => 'Owner tidak ditemukan'], 404);
        }

        $owner->foto_url = $this->buildFotoUrl($owner->foto);
        unset($owner->foto);

        return response()->json($owner);
    }
}
