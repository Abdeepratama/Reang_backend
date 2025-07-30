@extends('admin.partials.app')

@section('title', 'Edit Info Keagamaan')

@section('content')
<div class="container mt-4">
    <h2>Edit Info Keagamaan</h2>

    <form action="{{ route('admin.ibadah.info.update', $info->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Foto Lama</label><br>
            <img src="{{ asset('storage/' . $info->foto) }}" width="150" class="mb-2"><br>
            <label>Ganti Foto (Opsional)</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <div class="form-group">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" value="{{ $info->judul }}" required>
        </div>

        <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $info->tanggal }}" required>
        </div>

        <div class="form-group">
            <label>Waktu</label>
            <input type="time" name="waktu" class="form-control" value="{{ $info->waktu }}" required>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" required>{{ $info->deskripsi }}</textarea>
        </div>

        <div class="form-group">
            <label>Lokasi</label>
            <input type="text" name="lokasi" class="form-control" value="{{ $info->lokasi }}" required>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control" value="{{ $info->alamat }}" required>
        </div>

        <div class="mb-3">
                    <label for="fitur" class="form-label">Kategori</label>
                    <select name="fitur" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoriIbadah as $kategori)
                        <option value="{{ $kategori->nama }}" {{ $info->fitur == $kategori->nama ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>

        <button type="submit" class="btn btn-success">Perbarui</button>
    </form>
</div>
@endsection