@extends('admin.partials.app')

@section('title', 'Edit Data Dokter')

@section('content')
<div class="container-fluid px-4">
    <h4 class="mt-4 mb-4">Edit Data Dokter</h4>

    <form action="{{ route('admin.sehat.dokter.update', $dokter->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <!-- Puskesmas -->
                <div class="mb-3">
                    <label for="id_puskesmas" class="form-label">Puskesmas</label>
                    <select name="id_puskesmas" class="form-control" required>
                        <option value="">-- Pilih Puskesmas --</option>
                        @foreach($puskesmas as $p)
                            <option value="{{ $p->id }}" {{ old('id_puskesmas', $dokter->id_puskesmas) == $p->id ? 'selected' : '' }}>
                                {{ $p->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Nama -->
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Dokter</label>
                    <input type="text" name="nama" id="nama" class="form-control"
                           value="{{ old('nama', $dokter->nama) }}" required>
                </div>

                <!-- Pendidikan -->
                <div class="mb-3">
                    <label for="pendidikan" class="form-label">Pendidikan</label>
                    <input type="text" name="pendidikan" id="pendidikan" class="form-control"
                           value="{{ old('pendidikan', $dokter->pendidikan) }}" required>
                </div>

                <!-- Kategori / Spesialisasi -->
                <div class="mb-3">
                    <label for="fitur" class="form-label">Kategori / Spesialisasi</label>
                    <select name="fitur" id="fitur" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoriDokter as $kategori)
                            <option value="{{ $kategori->nama }}" {{ old('fitur', $dokter->fitur) == $kategori->nama ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Umur -->
                <div class="mb-3">
                    <label for="umur" class="form-label">Umur</label>
                    <input type="number" name="umur" id="umur" class="form-control"
                           value="{{ old('umur', $dokter->umur) }}" required>
                </div>

                <!-- Nomor HP -->
                <div class="mb-3">
                    <label for="nomer" class="form-label">Nomor HP</label>
                    <input type="text" name="nomer" id="nomer" class="form-control"
                           value="{{ old('nomer', $dokter->nomer) }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Update Data</button>
            </div>
        </div>
    </form>
</div>
@endsection
