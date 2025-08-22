@extends('admin.partials.app')

@section('title', 'Tambah Info Sehat-Yu')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-hospital"></i> Tambah Info Sehat</h2>

    <form action="{{ route('admin.sehat.info.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="max-width: 500px;">
            <!-- Judul -->
            <div class="form-group mb-3">
                <label>Judul</label>
                <input type="text" name="judul" id="judul" class="form-control" required>
            </div>

            <!-- Kategori -->
            <div class="form-group mb-3">
                <label>Kategori</label>
                <select name="fitur" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoriKesehatan as $kategori)
                        <option value="{{ $kategori->nama }}" {{ old('fitur') == $kategori->nama ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Foto -->
            <div class="form-group mb-3">
                <label>Foto</label>
                <input type="file" name="foto" class="form-control" required>
            </div>

            <!-- Deskripsi -->
            <div class="form-group mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
            </div>

            <!-- Tombol -->
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Simpan Data
            </button>
        </div>
    </form>
</div>
@endsection
