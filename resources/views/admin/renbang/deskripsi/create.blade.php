@extends('admin.layouts.app')

@section('title', 'Tambah Deskripsi Renbang')

@section('content')
<div class="container">
    <h1>Tambah Deskripsi Renbang</h1>

    <form action="{{ route('admin.renbang.deskripsi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Isi</label>
            <textarea name="isi" class="form-control" rows="5" required></textarea>
        </div>

        <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori" class="form-control">
                <option value="Infrastruktur">Infrastruktur</option>
                <option value="Pendidikan">Pendidikan</option>
                <option value="Kesehatan">Kesehatan</option>
                <option value="Ekonomi">Ekonomi</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Gambar</label>
            <input type="file" name="gambar" class="form-control">
        </div>

        <button class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
