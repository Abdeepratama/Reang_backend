@extends('admin.partials.app')

@section('title', 'Edit Owner')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">✏️ Edit Owner</h3>

    <form action="{{ route('admin.pasar.umkm.owner.update', $owner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Pilih UMKM</label>
            <select name="id_umkm" class="form-control" required>
                @foreach($umkm as $u)
                    <option value="{{ $u->id }}" {{ $owner->id_umkm == $u->id ? 'selected' : '' }}>{{ $u->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Nama Owner</label>
            <input type="text" name="nama" class="form-control" value="{{ $owner->nama }}" required>
        </div>

        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="no_hp" class="form-control" value="{{ $owner->no_hp }}" required>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" rows="3" required>{{ $owner->alamat }}</textarea>
        </div>

        <div class="mb-3">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
            @if($owner->foto)
                <img src="{{ asset('storage/'.$owner->foto) }}" width="100" class="mt-2 rounded shadow-sm">
            @endif
        </div>

        <button class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('admin.pasar.umkm.owner.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
