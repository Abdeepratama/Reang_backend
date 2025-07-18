@extends('admin.layouts.app')

@section('title', 'Edit Deskripsi Renbang')

@section('content')
<div class="container">
    <h1>Edit Deskripsi Renbang</h1>

    <form action="{{ route('admin.renbang.update', $item->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul', $item->judul) }}" required>
        </div>

        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select name="kategori" class="form-control" required>
                @foreach(['Infrastruktur','Pendidikan','Kesehatan','Ekonomi'] as $kategori)
                    <option value="{{ $kategori }}" {{ $kategori == $item->kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="isi" class="form-label">Isi</label>
            <textarea name="isi" class="form-control" rows="5" required>{{ old('isi', $item->isi) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar (optional)</label>
            <input type="file" name="gambar" class="form-control">
            @if ($item->gambar)
                <p class="mt-2">Gambar lama:</p>
                <img src="{{ asset('storage/' . $item->gambar) }}" width="150">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('admin.renbang.deskripsi.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
