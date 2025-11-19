@extends('admin.partials.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="container mt-4">
    <h2>Edit Kategori</h2>

    <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Pilih Fitur --}}
        <div class="mb-3">
            <label for="fitur" class="form-label">Kategori Fitur</label>
            <select class="form-select" id="fitur" name="fitur" required>
                <option value="" disabled>Pilih Fitur</option>

                @foreach (fitur_list() as $fitur)
                    <option value="{{ $fitur }}"
                        {{ $kategori->fitur == $fitur ? 'selected' : '' }}>
                        {{ ucfirst($fitur) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Nama Kategori --}}
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Kategori</label>
            <input type="text"
                   class="form-control"
                   id="nama"
                   name="nama"
                   value="{{ old('nama', $kategori->nama) }}"
                   required>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
