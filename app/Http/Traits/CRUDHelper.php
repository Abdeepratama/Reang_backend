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
    protected $aktivitasTipe;
    protected $aktivitasCreateMessage;
    protected $validationRules = [];

    public function index()
    {
        $items = ($this->model)::latest()->get();
        return view("admin.{$this->viewPrefix}.index", compact('items'));
    }

    public function create()
    {
        return view("admin.{$this->viewPrefix}.create");
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules);
        ($this->model)::create($validated);

        $this->logAktivitas("Menambahkan {$this->aktivitasTipe}");
        $this->logNotifikasi("{$this->aktivitasTipe} baru telah ditambahkan.");;

        return redirect()
            ->route("admin.{$this->routePrefix}.index")
            ->with('success', $this->aktivitasCreateMessage ?? "{$this->aktivitasTipe} berhasil ditambahkan.");
    }

    public function show($id)
    {
        $item = ($this->model)::findOrFail($id);
        $varName = strtolower(class_basename($this->model));

        return view("admin.{$this->viewPrefix}.show", [
            $varName => $item,
        ]);
    }

    public function edit($id)
    {
        $item = ($this->model)::findOrFail($id);
        return view("admin.{$this->viewPrefix}.edit", compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate($this->validationRules);
        $item = ($this->model)::findOrFail($id);
        $item->update($validated);

        $this->logAktivitas("Mengubah {$this->aktivitasTipe}");
        $this->logNotifikasi("{$this->aktivitasTipe} baru telah diubah.");

        return redirect()
            ->route("admin.{$this->routePrefix}.index")
            ->with('success', "{$this->aktivitasTipe} berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $item = ($this->model)::findOrFail($id);
        $item->delete();

        $this->logAktivitas("Menghapus {$this->aktivitasTipe}");
        $this->logNotifikasi("{$this->aktivitasTipe} baru telah dihapus.");

        return redirect()
            ->route("admin.{$this->routePrefix}.index")
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
            'url' => route("admin.{$this->routePrefix}.index") // Pastikan URL lengkap
        ]);
    }
}
