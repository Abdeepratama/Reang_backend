@extends('admin.partials.app')

@section('title', 'Edit UMKM')

@section('content')
<div class="container mt-4">
    <h2>Edit UMKM</h2>
    <form action="{{ route('admin.pasar.umkm.toko.update', $umkm->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ $umkm->nama }}" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ $umkm->deskripsi }}</textarea>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control" value="{{ $umkm->alamat }}" required>
        </div>

        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="no_hp" class="form-control" value="{{ $umkm->no_hp }}" required>
        </div>

        <div class="mb-3">
            <label>Foto</label><br>
            @if ($umkm->foto)
                <img src="{{ asset('storage/' . $umkm->foto) }}" width="80" class="mb-2"><br>
            @endif
            <input type="file" name="foto" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('admin.pasar.umkm.toko.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
