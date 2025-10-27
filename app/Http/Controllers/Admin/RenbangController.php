<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Renbang;
use App\Models\RenbangAjuan;
use App\Models\RenbangLike;
use App\Models\Aktivitas;
use App\Models\NotifikasiAktivitas;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class RenbangController extends Controller
{
    /**
     * ==================================================================================================
     * BAGIAN INI UNTUK ADMIN PANEL (TIDAK ADA PERUBAHAN)
     * ==================================================================================================
     */
    public function InfoIndex()
    {
        $renbangItems = Renbang::latest()->get();
        $kategoriRenbangs = Kategori::where('fitur', 'Info renbang')
            ->orderBy('nama')
            ->get();
        return view('admin.renbang.info.index', compact('renbangItems', 'kategoriRenbangs'));
    }

    public function infoCreate()
    {
        $kategoriRenbangs = Kategori::where('fitur', 'info renbang')
            ->orderBy('nama')
            ->get();
        return view('admin.renbang.info.create', compact('kategoriRenbangs'));
    }

    public function infoEdit($id)
    {
        $item = Renbang::findOrFail($id);
        $kategoriRenbangs = Kategori::where('fitur', 'info renbang')
            ->orderBy('nama')
            ->get();
        return view('admin.renbang.info.edit', compact('item', 'kategoriRenbangs'));
    }

    public function infoStore(Request $request)
    {
        $data = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'fitur'     => 'required|string|max:255',
            'gambar'    => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,svg,bmp|max:5120',
            'alamat'    => 'required|string|max:255',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('renbang', 'public');
        }

        Renbang::create($data);

        $this->logAktivitas("Info Renbang telah ditambahkan");
        $this->logNotifikasi("Info Renbang telah ditambahkan");

        return redirect()->route('admin.renbang.info.index')
            ->with('success', 'Info Renbang berhasil ditambahkan.');
    }

    public function infoUpdate(Request $request, $id)
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

        $this->logAktivitas("Info Renbang telah diperbarui");
        $this->logNotifikasi("Info Renbang telah diperbarui");

        return redirect()->route('admin.renbang.info.index')
            ->with('success', 'Info Renbang berhasil diperbarui');
    }

    public function infoDestroy($id)
    {
        $item = Renbang::findOrFail($id);

        if ($item->gambar && Storage::disk('public')->exists($item->gambar)) {
            Storage::disk('public')->delete($item->gambar);
        }

        $item->delete();

        $this->logAktivitas("Info Renbang telah dihapus");
        $this->logNotifikasi("Info Renbang telah dihapus");

        return redirect()->route('admin.renbang.info.index')
            ->with('success', 'Info Renbang berhasil dihapus');
    }

    public function infoShowDetail($id)
    {
        $item = Renbang::findOrFail($id);
        return view('admin.renbang.info.show', compact('item'));
    }

    public function infoShow($id = null)
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
                'gambar'    => $data->gambar ? $this->buildFotoUrl($data->gambar) : null,
                'alamat'    => $data->alamat,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            ];
            return response()->json($arr, 200);
        } else {
            $data = Renbang::with('kategori')->latest()->get()->map(function ($item) {
                return [
                    'id'        => $item->id,
                    'judul'     => $item->judul,
                    'deskripsi' => $this->replaceImageUrlsInHtml($item->deskripsi),
                    'fitur'     => $item->kategori->nama ?? ($item->fitur ?? null),
                    'gambar'    => $item->gambar ? $this->buildFotoUrl($item->gambar) : null,
                    'alamat'    => $item->alamat,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return response()->json($data, 200);
        }
    }

    public function infoUpload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . preg_replace('/\s+/', '', $file->getClientOriginalName());
            $path = $file->storeAs('renbangs', $filename, 'public');
            $url = request()->getSchemeAndHttpHost() . '/storage/' . $path;
            return response()->json([
                'uploaded' => true,
                'url'      => $url
            ]);
        }
        return response()->json([
            'uploaded' => false,
            'error'    => ['message' => 'No file uploaded']
        ], 400);
    }

    // Ajuan renbang
    // =======================
    // 🔹 BAGIAN WEB
    // =======================
    public function index()
    {
        $user = Auth::guard('admin')->user();

        if ($user->role === 'superadmin') {
            $items = RenbangAjuan::with('user')
                ->withCount('likes')
                ->orderByRaw("CASE WHEN status = 'selesai' THEN 1 ELSE 0 END")
                ->latest()
                ->get();
        } else {
            $items = RenbangAjuan::with('user')
                ->withCount('likes')
                ->whereHas('user.userData', function ($q) use ($user) {
                    $q->where('id_admin', $user->id);
                })
                ->orderByRaw("CASE WHEN status = 'selesai' THEN 1 ELSE 0 END")
                ->latest()
                ->get();
        }

        return view('admin.renbang.ajuan.index', compact('items'));
    }

    public function show($id)
    {
        $ajuan = RenbangAjuan::with('user')->findOrFail($id);
        return view('admin.renbang.ajuan.show', compact('ajuan'));
    }

    public function update(Request $request, $id)
    {
        $ajuan = RenbangAjuan::findOrFail($id);

        $request->validate([
            'status' => 'nullable|in:menunggu,diproses,selesai,ditolak',
            'tanggapan' => 'nullable|string|max:1000',
        ]);

        if ($request->filled('status')) {
            $ajuan->status = $request->status;
        }

        if ($request->filled('tanggapan')) {
            $ajuan->tanggapan = $request->tanggapan;
        }

        $ajuan->save();

        return back()->with('success', 'Status atau tanggapan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $ajuan = RenbangAjuan::findOrFail($id);
        $ajuan->delete();

        return back()->with('success', 'Ajuan berhasil dihapus!');
    }

    // =======================
    // 🔹 BAGIAN API (Flutter)
    // =======================
    
    // --- PERUBAHAN UTAMA DI FUNGSI INI ---
    public function apiIndex(Request $request)
    {
        $perPage = 10;
        $user = auth('sanctum')->user();

        // 1. Ambil data usulan seperti biasa dengan paginasi
        $data = RenbangAjuan::with(['user'])
            ->withCount('likes')
            ->latest()
            ->paginate($perPage);

        // 2. Jika user login, cari tahu usulan mana saja yang sudah di-like
        $likedAjuanIds = collect(); // Defaultnya koleksi kosong
        if ($user) {
            $ajuanIdsOnPage = $data->pluck('id'); // Ambil semua ID usulan di halaman ini
            if ($ajuanIdsOnPage->isNotEmpty()) {
                // Cari di tabel 'renbang_likes' hanya untuk ID user dan ID usulan yang ada di halaman ini
                $likedAjuanIds = RenbangLike::where('id_user', $user->id)
                    ->whereIn('id_renbang', $ajuanIdsOnPage)
                    ->pluck('id_renbang');
            }
        }
        
        // 3. Tambahkan properti 'is_liked_by_user' ke setiap item
        $data->getCollection()->transform(function ($ajuan) use ($likedAjuanIds) {
            $ajuan->is_liked_by_user = $likedAjuanIds->contains($ajuan->id);
            return $ajuan;
        });

        return response()->json(['success' => true, 'data' => $data], 200);
    }

    public function apiStore(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'required|string|max:255',
            'lokasi'    => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $user = auth('sanctum')->user();

        $ajuan = RenbangAjuan::create([
            'judul'     => $request->judul,
            'kategori'  => $request->kategori,
            'lokasi'    => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'status'    => 'menunggu',
            'user_id'   => $user?->id,
        ]);

        return response()->json([
            'message' => 'Ajuan berhasil dikirim',
            'data' => $ajuan,
        ], 201);
    }

    public function apiajuanShow($id)
    {
        $user = auth('sanctum')->user();

        $ajuan = RenbangAjuan::with('user')
            ->withCount('likes')
            ->find($id);

        if (!$ajuan) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $liked = $user
            ? RenbangLike::where('id_user', $user->id)
            ->where('id_renbang', $id)
            ->exists()
            : false;
        
        // Menambahkan properti 'is_liked_by_user' ke objek ajuan
        $ajuan->is_liked_by_user = $liked;

        return response()->json([
            'success' => true,
            'data' => $ajuan
        ]);
    }

    public function apiToggleLike($id)
    {
        $user = auth('sanctum')->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $existing = RenbangLike::where('id_user', $user->id)
            ->where('id_renbang', $id)
            ->first();

        if ($existing) {
            $existing->delete();
            $status = 'unliked';
        } else {
            RenbangLike::create([
                'id_user' => $user->id,
                'id_renbang' => $id,
            ]);
            $status = 'liked';
        }

        $count = RenbangLike::where('id_renbang', $id)->count();

        return response()->json([
            'status' => $status,
            'likes_count' => $count,
        ]);
    }

    public function apiLikes($id)
    {
        $user = auth('sanctum')->user();

        $count = RenbangLike::where('id_renbang', $id)->count();
        $liked = $user
            ? RenbangLike::where('id_user', $user->id)->where('id_renbang', $id)->exists()
            : false;

        return response()->json([
            'likes_count' => $count,
            'liked' => $liked,
        ]);
    }

    /**
     * ==================================================================================================
     * BAGIAN INI UNTUK API (YANG DIPERBARUI)
     * ==================================================================================================
     */
    public function apiGetFitur()
    {
        $fitur = Renbang::select('fitur')
            ->groupBy('fitur')
            ->orderByRaw('MIN(created_at) asc')
            ->pluck('fitur');

        return response()->json($fitur, 200);
    }

    public function apiShow(Request $request, $id = null)
    {
        if ($id) {
            $data = Renbang::with('kategori')->find($id);
            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
            $formattedData = [
                'id'        => $data->id,
                'judul'     => $data->judul,
                'deskripsi' => $this->replaceImageUrlsInHtml($data->deskripsi),
                'fitur'     => $data->kategori->nama ?? ($data->fitur ?? null),
                'gambar'    => $data->gambar ? $this->buildFotoUrl($data->gambar) : null,
                'alamat'    => $data->alamat,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            ];
            return response()->json($formattedData, 200);
        }

        $query = Renbang::with('kategori')->latest();

        if ($request->has('fitur') && $request->fitur != '') {
            $query->where('fitur', $request->fitur);
        }

        $paginatedData = $query->paginate(10);

        $paginatedData->getCollection()->transform(function ($item) {
            return [
                'id'        => $item->id,
                'judul'     => $item->judul,
                'deskripsi' => strip_tags($item->deskripsi),
                'fitur'     => $item->kategori->nama ?? ($item->fitur ?? null),
                'gambar'    => $item->gambar ? $this->buildFotoUrl($item->gambar) : null,
                'alamat'    => $item->alamat,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });

        return response()->json($paginatedData, 200);
    }

    /**
     * ==================================================================================================
     * HELPER & LOGGING FUNCTIONS (TIDAK ADA PERUBAHAN)
     * ==================================================================================================
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

    private function buildFotoUrl($path)
    {
        return request()->getSchemeAndHttpHost() . '/storage/' . ltrim($path, '/');
    }

    protected $aktivitasTipe = 'renbang';

    protected function logAktivitas($pesan)
    {
        if (auth()->check()) {
            $user = auth()->user();
            Aktivitas::create([
                'user_id'     => $user->id,
                'tipe'        => $this->aktivitasTipe,
                'keterangan'  => $pesan,
                'role'        => $user->role,
                'id_instansi' => $user->id_instansi,
            ]);
        }
    }

    protected function logNotifikasi($pesan)
    {
        $user = auth()->user();
        NotifikasiAktivitas::create([
            'keterangan'  => $pesan,
            'dibaca'      => false,
            'url'         => route('admin.renbang.info.index'),
            'role'        => $user->role,
            'id_instansi' => $user->id_instansi,
        ]);
    }
}