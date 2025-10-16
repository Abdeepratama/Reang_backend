<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Instansi;
use App\Models\Dokter;
use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAccountController extends Controller
{
    // LIST SEMUA ADMIN
    public function index()
    {
        $admins = Admin::with(['instansi', 'dokter'])->get();
        return view('admin.accounts.index', compact('admins'));
    }

    // FORM TAMBAH AKUN
    public function create()
    {
        $instansi = Instansi::orderBy('nama')->get();
        $dokters = Dokter::orderBy('fitur')->get();

        return view('admin.accounts.create', compact('instansi', 'dokters'));
    }

    // SIMPAN AKUN BARU
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'password'     => 'required|string|min:6|confirmed',
            'role'         => 'required|in:superadmin,admindinas,dokter',
            'id_instansi'  => 'nullable|exists:instansi,id',
            'id_dokter'    => 'nullable|exists:dokter,id',
            'email'        => 'required|email|max:255',
            'no_hp'        => 'required|string|max:20',
        ]);

        // 🔹 Simpan admin
        $admin = Admin::create([
            'name'     => $validated['name'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        // 🔹 Buat atau sambungkan relasi sesuai role
        if ($validated['role'] === 'admindinas' && $request->filled('id_instansi')) {
            UserData::create([
                'id_admin'    => $admin->id,
                'id_instansi' => $validated['id_instansi'],
                'nama'        => $validated['name'],
                'email'       => $validated['email'],
                'no_hp'       => $validated['no_hp'],
            ]);
        } else {
            // Untuk superadmin & dokter tetap disimpan user_data minimal
            UserData::create([
                'id_admin' => $admin->id,
                'nama'     => $validated['name'],
                'email'    => $validated['email'],
                'no_hp'    => $validated['no_hp'],
            ]);
        }

        // 🔹 Jika role dokter, update tabel dokter agar terkait
        if ($validated['role'] === 'dokter' && $request->filled('id_dokter')) {
            $dokter = Dokter::find($validated['id_dokter']);
            $dokter->id_admin = $admin->id;
            $dokter->save();
        }

        return redirect()->route('admin.accounts.index')->with('success', 'Akun berhasil dibuat dan data user terhubung.');
    }

    // FORM EDIT AKUN
    public function edit(Admin $account)
    {
        $instansi = Instansi::orderBy('nama')->get();
        $dokters = Dokter::orderBy('fitur')->get();

        return view('admin.accounts.edit', compact('account', 'instansi', 'dokters'));
    }

    // UPDATE AKUN
    public function update(Request $request, $id)
    {
        $account = Admin::findOrFail($id);

        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'password'     => 'nullable|string|min:6|confirmed',
            'role'         => 'required|in:superadmin,admindinas,dokter',
            'id_instansi'  => 'nullable|exists:instansi,id',
            'id_dokter'    => 'nullable|exists:dokter,id',
            'email'        => 'required|email|max:255',
            'no_hp'        => 'required|string|max:20',
        ]);

        $account->update([
            'name'     => $validated['name'],
            'role'     => $validated['role'],
            'password' => !empty($validated['password']) ? Hash::make($validated['password']) : $account->password,
        ]);

        // Update user_data
        $userData = UserData::firstOrNew(['id_admin' => $account->id]);
        $userData->fill([
            'nama'        => $validated['name'],
            'email'       => $validated['email'],
            'no_hp'       => $validated['no_hp'],
            'id_instansi' => $validated['id_instansi'] ?? null,
        ]);
        $userData->save();

        // Jika role dokter, sambungkan ke tabel dokter
        if ($validated['role'] === 'dokter' && $request->filled('id_dokter')) {
            $dokter = Dokter::find($validated['id_dokter']);
            $dokter->id_admin = $account->id;
            $dokter->save();
        }

        return redirect()->route('admin.accounts.index')->with('success', 'Akun berhasil diperbarui.');
    }

    // HAPUS AKUN
    public function destroy(Admin $account)
    {
        // Hapus juga data user_data yang terkait
        UserData::where('id_admin', $account->id)->delete();
        $account->delete();

        return redirect()->route('admin.accounts.index')->with('success', 'Akun dan data user berhasil dihapus.');
    }
}
