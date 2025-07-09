@extends('admin.layouts.app')

@section('title', 'Edit Data Sehat-Yu')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Data Sehat-Yu</h2>

    <form action="{{ route('admin.sehat.update', $sehat->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Tempat</label>
            <input type="text" name="nama" class="form-control" value="{{ $sehat->nama }}" required>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" rows="3" required>{{ $sehat->alamat }}</textarea>
        </div>

        <div class="mb-3">
            <label for="latitude" class="form-label">Latitude</label>
            <input type="text" name="latitude" class="form-control" value="{{ $sehat->latitude }}" required>
        </div>

        <div class="mb-3">
            <label for="longitude" class="form-label">Longitude</label>
            <input type="text" name="longitude" class="form-control" value="{{ $sehat->longitude }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('admin.sehat.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
