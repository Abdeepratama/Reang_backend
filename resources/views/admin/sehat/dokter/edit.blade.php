@extends('admin.partials.app')

@section('title', 'Edit Data Dokter')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Edit Data Dokter</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.sehat.dokter.update', $dokter->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

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

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Dokter</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $dokter->nama) }}" required>
        </div>

        <div class="mb-3">
            <label for="pendidikan" class="form-label">Pendidikan</label>
            <input type="text" name="pendidikan" class="form-control" value="{{ old('pendidikan', $dokter->pendidikan) }}" required>
        </div>

        <div class="mb-3">
            <label for="fitur" class="form-label">Spesialisasi</label>
            <select name="fitur" id="fitur" class="form-control" required>
                <option value="">-- Pilih Spesialisasi --</option>
                @foreach($kategoriDokter as $kategori)
                    <option value="{{ $kategori->nama }}" {{ old('fitur', $dokter->fitur) == $kategori->nama ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="masa_kerja" class="form-label">Masa Kerja</label>
            <input type="text" name="masa_kerja" class="form-control" value="{{ old('masa_kerja', $dokter->masa_kerja) }}" required>
        </div>

        <div class="mb-3">
            <label for="nomer" class="form-label">Nomor STR</label>
            <input type="text" name="nomer" class="form-control" value="{{ old('nomer', $dokter->nomer) }}" required>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto Dokter</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
            <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>

            @if($dokter->foto)
                <div class="mt-2">
                    <img src="{{ asset('storage/'.$dokter->foto) }}" alt="Foto Dokter" width="120" class="rounded shadow-sm border">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('admin.sehat.dokter.index') }}" class="btn btn-secondary ms-2">Kembali</a>
    </form>
</div>
@endsection
