@extends('admin.partials.app')

@section('title', 'Edit Info Sehat-Yu')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-heart-pulse"></i> Edit Info Sehat</h2>

    <form action="{{ route('admin.sehat.info.update', $info->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul', $info->judul) }}" required>
        </div>

        <div class="form-group mb-3">
            <label>Kategori</label>
            <select name="fitur" class="form-control" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategoriKesehatan as $kategori)
                    <option value="{{ $kategori->nama }}" {{ (old('fitur', $info->fitur) == $kategori->nama) ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control">
            @if($info->foto)
                <small>Foto saat ini:</small><br>
                <img src="{{ $info->foto }}" alt="Foto" width="150" style="border-radius:8px; margin-top:5px;">
            @endif
        </div>

        <div class="form-group mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" required>{{ old('deskripsi', $info->deskripsi) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Update Data</button>
        <a href="{{ route('admin.sehat.info.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
