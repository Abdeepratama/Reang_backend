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

        // Simpan akun admin
        $admin = Admin::create([
            'name'         => $validated['name'],
            'password'     => Hash::make($validated['password']),
            'role'         => $validated['role'],
            'id_instansi'  => $validated['id_instansi'] ?? null,
            'id_dokter'    => $validated['id_dokter'] ?? null,
        ]);

        // Simpan otomatis ke tabel user_data
        UserData::create([
            'id_admin'     => $admin->id,
            'id_instansi'  => $admin->id_instansi,
            'nama'         => $validated['name'],
            'email'        => $validated['email'] ?? null,
            'no_hp'        => $validated['no_hp'] ?? null,
        ]);

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
            'name'        => $validated['name'],
            'role'        => $validated['role'],
            'id_instansi' => $validated['id_instansi'] ?? null,
            'id_dokter'   => $validated['id_dokter'] ?? null,
            'password'    => !empty($validated['password']) ? Hash::make($validated['password']) : $account->password,
        ]);

        // Update juga tabel user_data terkait admin ini
        $userData = UserData::where('id_admin', $account->id)->first();
        if ($userData) {
            $userData->update([
                'nama'        => $validated['name'],
                'email'       => $validated['email'] ?? $userData->email,
                'no_hp'       => $validated['no_hp'] ?? $userData->no_hp,
                'id_instansi' => $validated['id_instansi'] ?? $userData->id_instansi,
            ]);
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
