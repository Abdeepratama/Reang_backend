@extends('admin.partials.app')

@section('title', 'Tambah Dokter')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">👨‍⚕️ Tambah Dokter</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.sehat.dokter.store') }}" method="POST">
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
            <label for="umur" class="form-label">Umur</label>
            <input type="number" name="umur" class="form-control" value="{{ old('umur') }}" required>
        </div>

        <div class="mb-3">
            <label for="nomer" class="form-label">Nomor HP</label>
            <input type="text" name="nomer" class="form-control" value="{{ old('nomer') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
