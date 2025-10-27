<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Instansi;
use App\Models\Puskesmas;
use App\Models\Umkm;
use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAccountController extends Controller
{
    // 🔹 LIST SEMUA ADMIN
    public function index()
    {
        $admins = Admin::with(['userData.instansi', 'userData.puskesmas', 'userData.umkm'])->get();
        return view('admin.accounts.index', compact('admins'));
    }

    // 🔹 FORM TAMBAH AKUN
    public function create()
    {
        $instansi = Instansi::orderBy('nama')->get();
        $puskesmas = Puskesmas::orderBy('nama')->get();
        $umkm = Umkm::orderBy('nama')->get();

        return view('admin.accounts.create', compact('instansi', 'puskesmas', 'umkm'));
    }

    // 🔹 SIMPAN AKUN BARU
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'password'     => 'required|string|min:6|confirmed',
            'role'         => 'required|in:superadmin,admindinas,puskesmas,dokter,umkm',
            'id_instansi'  => 'nullable|exists:instansi,id',
            'id_puskesmas' => 'nullable|exists:puskesmas,id',
            'id_umkm'      => 'nullable|exists:umkm,id',
            'email'        => 'required|email|max:255',
            'no_hp'        => 'required|string|max:20',
            'alamat'       => 'nullable|string|max:255',
        ]);

        // Simpan ke tabel admin
        $admin = Admin::create([
            'name'     => $validated['name'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        // Simpan ke tabel user_data
        UserData::create([
            'id_admin'     => $admin->id,
            'id_instansi'  => $validated['id_instansi'] ?? null,
            'id_puskesmas' => $validated['id_puskesmas'] ?? null,
            'id_umkm'      => $validated['id_umkm'] ?? null,
            'nama'         => $validated['name'],
            'email'        => $validated['email'],
            'no_hp'        => $validated['no_hp'],
            'alamat'       => $validated['alamat'] ?? null,
        ]);

        return redirect()->route('admin.accounts.index')->with('success', 'Akun berhasil dibuat.');
    }

    // 🔹 FORM EDIT
    public function edit(Admin $account)
    {
        $instansi = Instansi::orderBy('nama')->get();
        $puskesmas = Puskesmas::orderBy('nama')->get();
        $umkm = Umkm::orderBy('nama')->get();

        return view('admin.accounts.edit', compact('account', 'instansi', 'puskesmas', 'umkm'));
    }

    // 🔹 UPDATE AKUN
    public function update(Request $request, $id)
    {
        $account = Admin::findOrFail($id);

        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'password'     => 'nullable|string|min:6|confirmed',
            'role'         => 'required|in:superadmin,admindinas,puskesmas,dokter,umkm',
            'id_instansi'  => 'nullable|exists:instansi,id',
            'id_puskesmas' => 'nullable|exists:puskesmas,id',
            'id_umkm'      => 'nullable|exists:umkm,id',
            'email'        => 'required|email|max:255',
            'no_hp'        => 'required|string|max:20',
            'alamat'       => 'nullable|string|max:255',
        ]);

        // Update tabel admin
        $account->update([
            'name'     => $validated['name'],
            'role'     => $validated['role'],
            'password' => $validated['password']
                ? Hash::make($validated['password'])
                : $account->password,
        ]);

        // Update atau buat data user_data
        UserData::updateOrCreate(
            ['id_admin' => $account->id],
            [
                'id_instansi'  => $validated['id_instansi'] ?? null,
                'id_puskesmas' => $validated['id_puskesmas'] ?? null,
                'id_umkm'      => $validated['id_umkm'] ?? null,
                'nama'         => $validated['name'],
                'email'        => $validated['email'],
                'no_hp'        => $validated['no_hp'],
                'alamat'       => $validated['alamat'] ?? null,
            ]
        );

        return redirect()->route('admin.accounts.index')->with('success', 'Akun berhasil diperbarui.');
    }

    // 🔹 HAPUS AKUN
    public function destroy(Admin $account)
    {
        UserData::where('id_admin', $account->id)->delete();
        $account->delete();

        return redirect()->route('admin.accounts.index')->with('success', 'Akun berhasil dihapus.');
    }
}
