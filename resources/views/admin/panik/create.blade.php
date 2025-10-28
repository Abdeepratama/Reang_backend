@extends('admin.partials.app')

@section('title', 'Tambah Panik Button')

@section('content')
<div class="container mt-4">
    <h2>Tambah Panik Button</h2>

    <form action="{{ route('admin.panik.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" placeholder="Masukkan nama" value="{{ old('name') }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group mb-3">
            <label>Nomor</label>
            <input type="text" name="nomer" class="form-control" placeholder="Masukkan nomor telepon" value="{{ old('nomer') }}" required>
            @error('nomer') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Tambah Dropdown Kategori --}}
        <div class="form-group mb-3">
            <label>Kategori</label>
            <select name="kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Ambulans" {{ old('kategori') == 'Ambulans' ? 'selected' : '' }}>Ambulans</option>
                <option value="Bpbd" {{ old('kategori') == 'Bpbd' ? 'selected' : '' }}>Bpbd</option>
                <option value="Pemadam" {{ old('kategori') == 'Pemadam' ? 'selected' : '' }}>Pemadam</option>
                <option value="Polisi" {{ old('kategori') == 'Polisi' ? 'selected' : '' }}>Polisi</option>
                <option value="Pmi" {{ old('kategori') == 'Pmi' ? 'selected' : '' }}>Pmi</option>
            </select>
            @error('kategori') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.panik.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
