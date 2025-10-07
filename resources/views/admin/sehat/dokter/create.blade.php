@extends('admin.partials.app')

@section('title', 'Tambah Dokter')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">👨‍⚕️ Tambah Dokter</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tambahkan enctype agar upload file bisa --}}
    <form action="{{ route('admin.sehat.dokter.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="id_puskesmas" class="form-label">Puskesmas</label>
            <select name="id_puskesmas" class="form-control" required>
                <option value="">-- Pilih Puskesmas --</option>
                @foreach($puskesmas as $p)
                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Dokter</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
        </div>

        <div class="mb-3">
            <label for="pendidikan" class="form-label">Pendidikan</label>
            <input type="text" name="pendidikan" class="form-control" value="{{ old('pendidikan') }}" required>
        </div>

        <div class="mb-3">
            <label for="fitur" class="form-label">Kategori / Spesialisasi</label>
            <select name="fitur" id="fitur" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategoriDokter as $kategori)
                    <option value="{{ $kategori->nama }}" {{ old('fitur') == $kategori->nama ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="masa_kerja" class="form-label">Masa Kerja</label>
            <input type="text" name="masa_kerja" class="form-control" value="{{ old('masa_kerja') }}" required>
        </div>

        <div class="mb-3">
            <label for="nomer" class="form-label">Nomor STR</label>
            <input type="text" name="nomer" class="form-control" value="{{ old('nomer') }}" required>
        </div>

        {{-- Tambahkan kembali input foto --}}
        <div class="mb-3">
            <label for="foto" class="form-label">Foto Dokter</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
            <small class="text-muted">Format: JPG, PNG, WEBP | Maks: 5MB</small>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
