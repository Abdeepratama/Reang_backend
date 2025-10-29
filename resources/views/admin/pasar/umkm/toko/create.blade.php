@extends('admin.partials.app')

@section('title', 'Tambah UMKM')

@section('content')
<div class="container mt-4">
    <h2>Tambah UMKM</h2>
    <form action="{{ route('admin.pasar.umkm.toko.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="no_hp" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.pasar.umkm.toko.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
