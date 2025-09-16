<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAccountController extends Controller
{
    // LIST
    public function index()
    {
        $admins = Admin::all();
        return view('admin.accounts.index', compact('admins'));
    }

    // CREATE FORM
    public function create()
    {
        return view('admin.accounts.create');
    }

    // STORE DATA
    public function store(Request $request)
{
    $validated = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:admins',
        'password' => 'required|string|min:6|confirmed',
        'role'     => 'required|in:superadmin,admindinas',
        'dinas'    => 'nullable|string|max:255', // tambahkan validasi dinas
    ]);

    Admin::create([
        'name'     => $validated['name'],
        'email'    => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role'     => $validated['role'],
        'dinas'    => $validated['dinas'] ?? null, // simpan dinas
    ]);

    return redirect()->route('admin.accounts.index')->with('success', 'Akun berhasil dibuat');
}

// UPDATE DATA
public function update(Request $request, $id)
{
    $account = Admin::findOrFail($id);

    $validated = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:admins,email,' . $account->id,
        'password' => 'nullable|string|min:6|confirmed',
        'role'     => 'required|in:superadmin,admindinas',
        'dinas'    => 'nullable|string|max:255', // tambahkan validasi dinas
    ]);

    $account->name  = $validated['name'];
    $account->email = $validated['email'];
    $account->role  = $validated['role'];
    $account->dinas = $validated['dinas'] ?? null; // update dinas

    if (!empty($validated['password'])) {
        $account->password = Hash::make($validated['password']);
    }

    $account->save();

    return redirect()->route('admin.accounts.index')->with('success', 'Akun berhasil diperbarui');
}

    // EDIT FORM
    public function edit(Admin $account)
    {
        return view('admin.accounts.edit', compact('account'));
    }

    // DELETE DATA
    public function destroy(Admin $account)
    {
        $account->delete();
        return redirect()->route('admin.accounts.index')->with('success', 'Akun berhasil dihapus');
    }
}
