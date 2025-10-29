<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Aktivitas;
use App\Models\NotifikasiAktivitas;

class UmkmController extends Controller
{
    // Menampilkan semua data
    public function index()
{
    $umkms = Umkm::orderBy('created_at', 'asc')->get();
    return view('admin.pasar.umkm.toko.index', compact('umkms'));
}

    // Form tambah data
    public function create()
    {
        return view('admin.pasar.umkm.toko.create');
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('umkm', 'public');
        }

        Umkm::create($data);

        $this->logAktivitas("Umkm telah ditambahkan");
        $this->logNotifikasi("Umkm telah ditambahkan");

        return redirect()->route('admin.pasar.umkm.toko.index')->with('success', 'Data UMKM berhasil ditambahkan!');
    }

    // Form edit data
    public function edit($id)
    {
        $umkm = Umkm::findOrFail($id);
        return view('admin.pasar.umkm.toko.edit', compact('umkm'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        $umkm = Umkm::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($umkm->foto && Storage::disk('public')->exists($umkm->foto)) {
                Storage::disk('public')->delete($umkm->foto);
            }
            $data['foto'] = $request->file('foto')->store('umkm', 'public');
        }

        $umkm->update($data);

        $this->logAktivitas("Umkm telah diupdate");
        $this->logNotifikasi("Umkm telah diupdate");

        return redirect()->route('admin.pasar.umkm.toko.index')->with('success', 'Data UMKM berhasil diperbarui!');
    }

    // Hapus data
    public function destroy($id)
    {
        $umkm = Umkm::findOrFail($id);
        if ($umkm->foto && Storage::disk('public')->exists($umkm->foto)) {
            Storage::disk('public')->delete($umkm->foto);
        }
        $umkm->delete();

        $this->logAktivitas("Umkm telah dihapus");
        $this->logNotifikasi("Umkm telah dihapus");

        return redirect()->route('admin.pasar.umkm.toko.index')->with('success', 'Data UMKM berhasil dihapus!');
    }

    protected $aktivitasTipe = 'umkm';

    protected function logAktivitas($pesan)
    {
        if (auth()->check()) {
            $user = auth()->user();

            // untuk role/dinas yang melakukan aksi
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
            'url'          => route('admin.pasar.umkm.toko.index'),
            'role'         => $user->role,
            'id_instansi'  => $user->id_instansi,
        ]);
    }
}
