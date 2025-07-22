@extends('admin.layouts.app')

@section('title', 'PLESIR-YU')

@section('content')
<div class="container">
    <h2>Edit Lokasi Plesir</h2>

    <form method="POST" action="{{ route('admin.plesir.update', $item->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $item->name) }}" required>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="address" class="form-control">{{ old('address', $item->address) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Latitude</label>
            <input type="text" name="latitude" class="form-control" value="{{ old('latitude', $item->latitude) }}" required>
        </div>

        <div class="mb-3">
            <label>Longitude</label>
            <input type="text" name="longitude" class="form-control" value="{{ old('longitude', $item->longitude) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
    </form>
</div>
@endsection
