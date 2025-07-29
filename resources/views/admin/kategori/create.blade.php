@extends('admin.partials.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="container mt-4">
    <h2>Tambah Kategori</h2>

    <form action="{{ route('admin.kategori.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="fitur" class="form-label">Fitur</label>
            <input type="text" class="form-control" id="fitur" name="fitur" required placeholder="Contoh: ibadah, sehat, pasar, plesir">
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control" id="nama" name="nama" required placeholder="Contoh: Masjid, Klinik, Wisata Alam">
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
