@extends('admin.layouts.app')

@section('title', 'IBADAH-YU')

@section('content')
<div class="container">
    <h2>{{ isset($item) ? 'Edit Tempat Ibadah' : 'Tambah Tempat Ibadah' }}</h2>

    <form method="POST" action="{{ isset($item) ? route('admin.ibadah.update', $item->id) : route('admin.ibadah.store') }}">
        @csrf
        @if(isset($item))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $item->name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="address" class="form-control">{{ old('address', $item->address ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Latitude</label>
            <input type="text" name="latitude" class="form-control" value="{{ old('latitude', $item->latitude ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Longitude</label>
            <input type="text" name="longitude" class="form-control" value="{{ old('longitude', $item->longitude ?? '') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
