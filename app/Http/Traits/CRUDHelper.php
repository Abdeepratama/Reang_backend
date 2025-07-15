<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use App\Models\NotifikasiAktivitas;
use App\Models\Aktivitas;

trait CRUDHelper
{
    protected $model;
    protected $routePrefix;
    protected $viewPrefix;
    protected $viewSubfolder = ''; // 👈 ini opsional
    protected $aktivitasTipe;
    protected $aktivitasCreateMessage;
    protected $validationRules = [];

    protected function getViewPath($page)
    {
        // contoh hasil: admin.sekolah.aduan.index atau admin.ibadah.index
        return 'admin.' . $this->viewPrefix .
            ($this->viewSubfolder ? '.' . $this->viewSubfolder : '') .
            '.' . $page;
    }

    protected function getRouteName($suffix = 'index')
    {
        // contoh hasil: admin.ibadah.index atau admin.ibadah.tempat.index
        return 'admin.' . $this->routePrefix .
            ($this->viewSubfolder ? '.' . $this->viewSubfolder : '') .
            '.' . $suffix;
    }

    public function index()
    {
        $items = ($this->model)::oldest()->get();
        return view($this->getViewPath('index'), compact('items'));
    }

    public function create()
    {
        return view($this->getViewPath('create'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules);
        ($this->model)::create($validated);

        $this->logAktivitas("Menambahkan {$this->aktivitasTipe}");
        $this->logNotifikasi("{$this->aktivitasTipe} baru telah ditambahkan.");

        return redirect()
            ->route($this->getRouteName())
            ->with('success', $this->aktivitasCreateMessage ?? "{$this->aktivitasTipe} berhasil ditambahkan.");
    }

    public function show($id)
    {
        $item = ($this->model)::findOrFail($id);
        $varName = strtolower(class_basename($this->model));

        return view($this->getViewPath('show'), [
            $varName => $item,
        ]);
    }

    public function edit($id)
    {
        $item = ($this->model)::findOrFail($id);
        return view($this->getViewPath('edit'), compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate($this->validationRules);
        $item = ($this->model)::findOrFail($id);
        $item->update($validated);

        $this->logAktivitas("Mengubah {$this->aktivitasTipe}");
        $this->logNotifikasi("{$this->aktivitasTipe} telah diubah.");

        return redirect()
            ->route($this->getRouteName())
            ->with('success', "{$this->aktivitasTipe} berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $item = ($this->model)::findOrFail($id);
        $item->delete();

        $this->logAktivitas("Menghapus {$this->aktivitasTipe}");
        $this->logNotifikasi("{$this->aktivitasTipe} telah dihapus.");

        return redirect()
            ->route($this->getRouteName())
            ->with('success', "{$this->aktivitasTipe} berhasil dihapus.");
    }

    protected function logAktivitas($pesan)
    {
        if (auth()->check()) {
            Aktivitas::create([
                'user_id' => auth()->id(),
                'tipe' => $this->aktivitasTipe,
                'keterangan' => $pesan,
            ]);
        }
    }

    protected function logNotifikasi($pesan)
    {
        NotifikasiAktivitas::create([
            'keterangan' => $pesan,
            'dibaca' => false,
            'url' => route($this->getRouteName())
        ]);
    }
}
