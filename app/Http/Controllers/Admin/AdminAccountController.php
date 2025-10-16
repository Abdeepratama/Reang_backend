<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Instansi;
use App\Models\Puskesmas;
use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAccountController extends Controller
{
    // LIST SEMUA ADMIN
    public function index()
{
    $admins = Admin::with(['userData.instansi', 'userData.puskesmas'])->get();
    return view('admin.accounts.index', compact('admins'));
}

// FORM TAMBAH AKUN
public function create()
{
    $instansi = Instansi::orderBy('nama')->get();
    $puskesmas = Puskesmas::orderBy('nama')->get();

    return view('admin.accounts.create', compact('instansi', 'puskesmas'));
}

// SIMPAN AKUN BARU
public function store(Request $request)
{
    $validated = $request->validate([
        'name'         => 'required|string|max:255',
        'password'     => 'required|string|min:6|confirmed',
        'role'         => 'required|in:superadmin,admindinas,puskesmas',
        'id_instansi'  => 'nullable|exists:instansi,id',
        'id_puskesmas' => 'nullable|exists:puskesmas,id',
        'email'        => 'required|email|max:255',
        'no_hp'        => 'required|string|max:20',
    ]);

    $admin = Admin::create([
        'name'     => $validated['name'],
        'password' => Hash::make($validated['password']),
        'role'     => $validated['role'],
    ]);

    if ($validated['role'] === 'admindinas' && $request->filled('id_instansi')) {
        UserData::create([
            'id_admin'    => $admin->id,
            'id_instansi' => $validated['id_instansi'],
            'nama'        => $validated['name'],
            'email'       => $validated['email'],
            'no_hp'       => $validated['no_hp'],
        ]);
    } elseif ($validated['role'] === 'puskesmas' && $request->filled('id_puskesmas')) {
        UserData::create([
            'id_admin'     => $admin->id,
            'id_puskesmas' => $validated['id_puskesmas'],
            'nama'         => $validated['name'],
            'email'        => $validated['email'],
            'no_hp'        => $validated['no_hp'],
        ]);
    } else {
        UserData::create([
            'id_admin' => $admin->id,
            'nama'     => $validated['name'],
            'email'    => $validated['email'],
            'no_hp'    => $validated['no_hp'],
        ]);
    }

    return redirect()->route('admin.accounts.index')->with('success', 'Akun berhasil dibuat dan data user terhubung.');
}

// FORM EDIT
public function edit(Admin $account)
{
    $instansi = Instansi::orderBy('nama')->get();
    $puskesmas = Puskesmas::orderBy('nama')->get();

    return view('admin.accounts.edit', compact('account', 'instansi', 'puskesmas'));
}

// UPDATE
public function update(Request $request, $id)
{
    $account = Admin::findOrFail($id);

    $validated = $request->validate([
        'name'         => 'required|string|max:255',
        'password'     => 'nullable|string|min:6|confirmed',
        'role'         => 'required|in:superadmin,admindinas,puskesmas',
        'id_instansi'  => 'nullable|exists:instansi,id',
        'id_puskesmas' => 'nullable|exists:puskesmas,id',
        'email'        => 'required|email|max:255',
        'no_hp'        => 'required|string|max:20',
    ]);

    $account->update([
        'name'     => $validated['name'],
        'role'     => $validated['role'],
        'password' => !empty($validated['password']) ? Hash::make($validated['password']) : $account->password,
    ]);

    $userData = UserData::firstOrNew(['id_admin' => $account->id]);
    $userData->fill([
        'nama'        => $validated['name'],
        'email'       => $validated['email'],
        'no_hp'       => $validated['no_hp'],
        'id_instansi' => $validated['id_instansi'] ?? null,
        'id_puskesmas' => $validated['id_puskesmas'] ?? null,
    ]);
    $userData->save();

    return redirect()->route('admin.accounts.index')->with('success', 'Akun berhasil diperbarui.');
}

// HAPUS AKUN
public function destroy(Admin $account)
{
    UserData::where('id_admin', $account->id)->delete();
    $account->delete();

    return redirect()->route('admin.accounts.index')->with('success', 'Akun dan data user berhasil dihapus.');
}
}
