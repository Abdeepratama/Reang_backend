@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($ibadah) ? 'Edit Tempat Ibadah' : 'Tambah Tempat Ibadah' }}</h2>

    <form method="POST" action="{{ isset($ibadah) ? route('admin.ibadah.update', $ibadah->id) : route('admin.ibadah.store') }}">
        @csrf
        @if(isset($ibadah))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $ibadah->name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="address" class="form-control">{{ old('address', $ibadah->address ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Latitude</label>
            <input type="text" name="latitude" class="form-control" value="{{ old('latitude', $ibadah->latitude ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Longitude</label>
            <input type="text" name="longitude" class="form-control" value="{{ old('longitude', $ibadah->longitude ?? '') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
