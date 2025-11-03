<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Puskesmas;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Aktivitas;
use App\Models\NotifikasiAktivitas;

class PuskesmasController extends Controller
{
    // ==========================================================
    // 🧭 BAGIAN PANEL ADMIN
    // ==========================================================
    public function index()
    {
        $user = Auth::guard('admin')->user();

        // Hanya superadmin & dinas kesehatan yang boleh mengakses
        if ($user->role === 'superadmin' || $user->role === 'kesehatan') {
            $puskesmas = Puskesmas::orderBy('id', 'desc')->get();
        } else {
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

        $this->logAktivitas("Puskesmas telah ditambahkan");
        $this->logNotifikasi("Puskesmas telah ditambahkan");

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

        $this->logAktivitas("Puskesmas telah diupdate");
        $this->logNotifikasi("Puskesmas telah diupdate");

        return redirect()->route('admin.sehat.puskesmas.index')
            ->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(Puskesmas $puskesmas)
    {
        $puskesmas->delete();

        $this->logAktivitas("Puskesmas telah dihapus");
        $this->logNotifikasi("Puskesmas telah dihapus");

        return redirect()->route('admin.sehat.puskesmas.index')
            ->with('success', 'Data berhasil dihapus');
    }

    // ==========================================================
    // 🔎 Helper: cari admin_id yang mengait ke puskesmas
    // ==========================================================
    protected function findAdminIdByPuskesmasId($puskesmasId)
    {
        $admin = Admin::whereHas('userData', function ($q) use ($puskesmasId) {
            $q->where('id_puskesmas', $puskesmasId);
        })->first();

        return $admin ? $admin->id : null;
    }

    // ==========================================================
    // 📡 BAGIAN API DATA PUSKESMAS
    // ==========================================================
    public function apiIndex()
    {
        $paginator = Puskesmas::withCount('dokter as dokter_tersedia')
            ->orderBy('id', 'desc')
            ->paginate(10);

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

            $data->admin_id = $this->findAdminIdByPuskesmasId($data->id);
            return response()->json($data);
        }

        $paginator = Puskesmas::withCount('dokter as dokter_tersedia')->paginate(10);

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
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                    ->orWhere('alamat', 'like', "%{$keyword}%")
                    ->orWhere('jam', 'like', "%{$keyword}%");
            });
        }

        $paginator = $query->orderBy('id', 'desc')->paginate(10);

        $collection = $paginator->getCollection()->map(function ($item) {
            $item->admin_id = $this->findAdminIdByPuskesmasId($item->id);
            return $item;
        });

        $paginator->setCollection($collection);

        return response()->json($paginator);
    }

    // ==========================================================
    // 🔐 BAGIAN API LOGIN / LOGOUT / PROFILE ADMIN KESEHATAN
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

        // Hanya role superadmin atau dinas kesehatan
        if (!in_array($admin->role, ['superadmin', 'kesehatan'])) {
            Auth::guard('admin')->logout();
            return response()->json(['message' => 'Hanya admin dinas kesehatan yang dapat login di sini.'], 403);
        }

        $token = $admin->createToken('AdminKesehatanToken')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
            'admin' => $admin,
        ]);
    }

    public function apiProfile(Request $request)
    {
        $admin = $request->user();

        if (!in_array($admin->role, ['superadmin', 'kesehatan'])) {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }

        return response()->json([
            'admin' => $admin,
        ]);
    }

    public function apiLogout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout berhasil']);
    }

    // ==========================================================
    // 🔍 API: cari puskesmas berdasarkan admin_id
    // ==========================================================
    public function apiShowByAdmin($adminId)
    {
        $admin = Admin::find($adminId);
        if (!$admin) {
            return response()->json(['message' => 'Admin tidak ditemukan'], 404);
        }

        $puskesmasId = optional($admin->userData)->id_puskesmas;
        if (!$puskesmasId) {
            return response()->json(['message' => 'Admin ini tidak terhubung ke puskesmas manapun'], 404);
        }

        $puskesmas = Puskesmas::find($puskesmasId);

        if (!$puskesmas) {
            return response()->json(['message' => 'Puskesmas tidak ditemukan'], 404);
        }

        $puskesmas->admin_id = $admin->id;

        return response()->json($puskesmas);
    }

    // ==========================================================
    // 🧾 Log Aktivitas dan Notifikasi
    // ==========================================================
    protected $aktivitasTipe = 'puskesmas';

    protected function logAktivitas($pesan)
    {
        if (auth()->check()) {
            $user = auth()->user();

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
            'url'          => route('admin.sehat.puskesmas.index'),
            'role'         => $user->role,
            'id_instansi'  => $user->id_instansi,
        ]);
    }
}
