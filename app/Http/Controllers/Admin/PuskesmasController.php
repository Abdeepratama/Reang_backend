<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Puskesmas;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PuskesmasController extends Controller
{
    // ==========================================================
    // 🧭 BAGIAN PANEL ADMIN (TIDAK DIUBAH)
    // ==========================================================
    public function index()
    {
        $user = Auth::guard('admin')->user();

        // Superadmin: tampilkan semua
        if ($user->role === 'superadmin') {
            $puskesmas = Puskesmas::orderBy('id', 'desc')->get();
        }
        // Role puskesmas: tampilkan hanya miliknya
        elseif ($user->role === 'puskesmas') {
            $idPuskesmas = optional($user->userData)->id_puskesmas;
            if (!$idPuskesmas) {
                abort(403, 'Akun Anda belum terhubung dengan data puskesmas.');
            }
            $puskesmas = Puskesmas::where('id', $idPuskesmas)->get();
        }
        else {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('admin.sehat.puskesmas.index', compact('puskesmas'));
    }

    public function create()
    {
        return view('admin.sehat.puskesmas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'jam' => 'required|string',
        ]);

        Puskesmas::create($request->only(['nama', 'alamat', 'jam']));

        return redirect()->route('admin.sehat.puskesmas.index')
            ->with('success', 'Data puskesmas berhasil ditambahkan');
    }

    public function edit(Puskesmas $puskesmas)
    {
        return view('admin.sehat.puskesmas.edit', compact('puskesmas'));
    }

    public function update(Request $request, Puskesmas $puskesmas)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'jam' => 'required|string',
        ]);

        $puskesmas->update($request->all());

        return redirect()->route('admin.sehat.puskesmas.index')
            ->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(Puskesmas $puskesmas)
    {
        $puskesmas->delete();
        return redirect()->route('admin.sehat.puskesmas.index')
            ->with('success', 'Data berhasil dihapus');
    }

    // ==========================================================
    // 🔎 Helper: cari admin_id yang mengait ke puskesmas
    // ==========================================================
    /**
     * Cari admin yang punya userData.id_puskesmas == $puskesmasId
     * Mengembalikan id admin atau null jika tidak ditemukan.
     */
    protected function findAdminIdByPuskesmasId($puskesmasId)
    {
        // Asumsi model Admin punya relasi userData yang menyimpan id_puskesmas
        $admin = Admin::whereHas('userData', function ($q) use ($puskesmasId) {
            $q->where('id_puskesmas', $puskesmasId);
        })->first();

        return $admin ? $admin->id : null;
    }

    // ==========================================================
    // 📡 BAGIAN API DATA PUSKESMAS (meng-include admin_id)
    // ==========================================================
    public function apiIndex()
    {
        $paginator = Puskesmas::withCount('dokter as dokter_tersedia')
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Tambahkan admin_id untuk setiap item di collection paginator
        $collection = $paginator->getCollection()->map(function ($item) {
            $item->admin_id = $this->findAdminIdByPuskesmasId($item->id);
            return $item;
        });

        $paginator->setCollection($collection);

        return response()->json($paginator);
    }

    public function apiShow($id = null)
    {
        if ($id) {
            $data = Puskesmas::withCount('dokter as dokter_tersedia')->find($id);
            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            // tambahkan admin_id
            $data->admin_id = $this->findAdminIdByPuskesmasId($data->id);

            return response()->json($data);
        }

        $paginator = Puskesmas::withCount('dokter as dokter_tersedia')->paginate(10);

        // tambahkan admin_id untuk setiap item
        $collection = $paginator->getCollection()->map(function ($item) {
            $item->admin_id = $this->findAdminIdByPuskesmasId($item->id);
            return $item;
        });

        $paginator->setCollection($collection);

        return response()->json($paginator);
    }

    public function apiSearch(Request $request)
    {
        $keyword = $request->query('q');

        $query = Puskesmas::withCount('dokter as dokter_tersedia');

        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhere('alamat', 'like', "%{$keyword}%")
                  ->orWhere('jam', 'like', "%{$keyword}%");
            });
        }

        $paginator = $query->orderBy('id', 'desc')->paginate(10);

        // tambahkan admin_id untuk setiap item
        $collection = $paginator->getCollection()->map(function ($item) {
            $item->admin_id = $this->findAdminIdByPuskesmasId($item->id);
            return $item;
        });

        $paginator->setCollection($collection);

        return response()->json($paginator);
    }

    // ==========================================================
    // 🔐 BAGIAN API LOGIN / LOGOUT / PROFILE PUSKESMAS
    //    (tidak diubah kecuali menambahkan admin_id di puskesmas response)
    // ==========================================================
    public function apiLogin(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('name', 'password');

        if (!Auth::guard('admin')->attempt($credentials)) {
            return response()->json(['message' => 'Login gagal. Periksa nama dan password.'], 401);
        }

        $admin = Auth::guard('admin')->user();

        // Hanya untuk role puskesmas
        if ($admin->role !== 'puskesmas') {
            Auth::guard('admin')->logout();
            return response()->json(['message' => 'Hanya admin puskesmas yang dapat login di sini.'], 403);
        }

        // Ambil data puskesmas yang terhubung lewat userData (jika ada)
        $puskesmasId = optional($admin->userData)->id_puskesmas;
        $puskesmas = $puskesmasId ? Puskesmas::find($puskesmasId) : null;

        if (!$puskesmas) {
            return response()->json(['message' => 'Akun belum terhubung dengan data puskesmas.'], 404);
        }

        // Token Sanctum
        $token = $admin->createToken('PuskesmasToken')->plainTextToken;

        // tambahkan admin_id pada puskesmas response (jika ada admin lain yang berelasi,
        // tetap akan mengembalikan admin yang dipetakan oleh findAdminIdByPuskesmasId)
        $puskesmas->admin_id = $this->findAdminIdByPuskesmasId($puskesmas->id);

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
            'admin' => $admin,
            'puskesmas' => $puskesmas,
        ]);
    }

    public function apiProfile(Request $request)
    {
        $admin = $request->user();

        if ($admin->role !== 'puskesmas') {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }

        $puskesmasId = optional($admin->userData)->id_puskesmas;
        $puskesmas = $puskesmasId ? Puskesmas::find($puskesmasId) : null;

        if ($puskesmas) {
            $puskesmas->admin_id = $this->findAdminIdByPuskesmasId($puskesmas->id);
        }

        return response()->json([
            'admin' => $admin,
            'puskesmas' => $puskesmas,
        ]);
    }

    public function apiLogout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout berhasil']);
    }
    public function apiShowByAdmin($adminId)
    {
        // 1. Cari Admin berdasarkan ID
        $admin = Admin::find($adminId);
        if (!$admin) {
            return response()->json(['message' => 'Admin tidak ditemukan'], 404);
        }

        // 2. Ambil ID Puskesmas dari relasi userData
        // (Saya asumsikan relasi 'userData' sudah ada di model Admin Anda
        // berdasarkan kode Anda yang lain)
        $puskesmasId = optional($admin->userData)->id_puskesmas;
        if (!$puskesmasId) {
             return response()->json(['message' => 'Admin ini tidak terhubung ke puskesmas manapun'], 404);
        }
        
        // 3. Cari Puskesmas
        $puskesmas = Puskesmas::find($puskesmasId);

        if (!$puskesmas) {
            return response()->json(['message' => 'Puskesmas tidak ditemukan'], 404);
        }
        
        // 4. Tambahkan admin_id secara manual agar konsisten
        $puskesmas->admin_id = $admin->id;

        return response()->json($puskesmas);
    }

}