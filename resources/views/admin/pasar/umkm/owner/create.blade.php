@extends('admin.partials.app')

@section('title', 'Tambah Owner UMKM')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">➕ Tambah Owner</h3>

    <form action="{{ route('admin.pasar.umkm.owner.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="id_umkm" class="form-label">Pilih UMKM</label>
            <select name="id_umkm" class="form-control" required>
                <option value="">-- Pilih UMKM --</option>
                @foreach($umkm as $u)
                    <option value="{{ $u->id }}">{{ $u->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Nama Owner</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="no_hp" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
        </div>

        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
