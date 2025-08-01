@extends('admin.partials.app')

@section('title', 'Tambah Info Keagamaan')

@section('content')
<div class="container mt-4">
    <h2>Tambah Info Keagamaan</h2>

    <form action="{{ route('admin.ibadah.info.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Waktu</label>
            <input type="time" name="waktu" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
        </div>

        <div class="form-group">
            <label>Lokasi</label>
            <input type="text" name="lokasi" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="fitur" class="form-label">Kategori</label>
            <select name="fitur" class="form-control" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategoriIbadah as $kategori)
                <option value="{{ $kategori->nama }}" {{ old('fitur') == $kategori->nama ? 'selected' : '' }}>
                    {{ $kategori->nama }}
                </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection