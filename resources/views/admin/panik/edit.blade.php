@extends('admin.partials.app')

@section('title', 'Edit Panik Button')

@section('content')
<div class="container mt-4">
    <h2>Edit Panik Button</h2>

    <form action="{{ route('admin.panik.update', $panik->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nama --}}
        <div class="form-group mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" 
                   value="{{ old('name', $panik->name) }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Nomor --}}
        <div class="form-group mb-3">
            <label>Nomor</label>
            <input type="text" name="nomer" class="form-control" 
                   value="{{ old('nomer', $panik->nomer) }}" required>
            @error('nomer') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Kategori --}}
        <div class="form-group mb-3">
            <label>Kategori</label>
            <select name="kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Ambulans" {{ old('kategori', $panik->kategori) == 'Ambulans' ? 'selected' : '' }}>Ambulans</option>
                <option value="Bpbd" {{ old('kategori', $panik->kategori) == 'Bpbd' ? 'selected' : '' }}>Bpbd</option>
                <option value="Pemadam" {{ old('kategori', $panik->kategori) == 'Pemadam' ? 'selected' : '' }}>Pemadam</option>
                <option value="Polisi" {{ old('kategori', $panik->kategori) == 'Polisi' ? 'selected' : '' }}>Polisi</option>
                <option value="Pmi" {{ old('kategori', $panik->kategori) == 'Pmi' ? 'selected' : '' }}>Pmi</option>
            </select>
            @error('kategori') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Tombol --}}
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('admin.panik.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
