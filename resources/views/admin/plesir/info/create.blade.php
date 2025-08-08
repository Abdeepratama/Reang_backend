@extends('admin.partials.app')

@section('title', 'Tambah Info Plesir-Yu')

@section('content')
<div class="container mt-4">
    <h2>Tambah Info Plesir-Yu</h2>

    <form action="{{ route('admin.plesir.info.store') }}" method="POST" enctype="multipart/form-data">
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
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
        </div>

        <div class="form-group">
    <label>Rating</label>
    <input type="number" name="rating" class="form-control" min="0" max="5" step="0.1" required>
</div>

        <div class="mb-3">
                    <label for="fitur" class="form-label">Kategori</label>
                    <select name="fitur" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoriPlesir as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('fitur') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
