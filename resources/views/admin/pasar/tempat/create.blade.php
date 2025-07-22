@extends('admin.layouts.app')

@section('title', 'PASAR-YU')

@section('content')
<div class="container">
    <h2>Tambah Pasar</h2>

    <form method="POST" action="{{ route('admin.pasar.store') }}">
        @csrf

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="address" class="form-control" required>{{ old('address') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Latitude</label>
            <input type="text" name="latitude" class="form-control" value="{{ old('latitude') }}" required>
        </div>

        <div class="mb-3">
            <label>Longitude</label>
            <input type="text" name="longitude" class="form-control" value="{{ old('longitude') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
