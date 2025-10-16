@extends('admin.partials.app')

@section('title', 'Edit Puskesmas')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">✏️ Edit Puskesmas</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.sehat.puskesmas.update', $puskesmas->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Puskesmas</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $puskesmas->nama) }}" required>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" required>{{ old('alamat', $puskesmas->alamat) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="jam" class="form-label">Jam Operasional</label>
            <input type="text" name="jam" class="form-control" value="{{ old('jam', $puskesmas->jam) }}" placeholder="08:00 - 16:00" required>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.sehat.puskesmas.index') }}" class="btn btn-secondary">← Kembali</a>
            <button type="submit" class="btn btn-primary">💾 Update</button>
        </div>
    </form>
</div>
@endsection
