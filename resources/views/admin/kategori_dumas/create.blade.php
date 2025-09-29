@extends('admin.partials.app')

@section('title', 'Tambah Kategori DUMAS')

@section('content')
<div class="container mt-4">
    <h2>Tambah Kategori DUMAS</h2>

    <form action="{{ route('admin.kategori_dumas.store') }}" method="POST">
        @csrf

        {{-- Pilih Instansi --}}
        <div class="mb-3">
            <label for="id_instansi" class="form-label">Instansi</label>
            <select class="form-select" id="id_instansi" name="id_instansi" required>
                <option value="" selected disabled>Pilih Instansi</option>
                @foreach($instansis as $instansi)
                    <option value="{{ $instansi->id }}">{{ $instansi->nama }}</option>
                @endforeach
            </select>
        </div>

        {{-- Nama Kategori --}}
        <div class="mb-3">
            <label for="nama_kategori" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required placeholder="Contoh: Jalan Rusak, Banjir, Sampah">
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.kategori_dumas.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
