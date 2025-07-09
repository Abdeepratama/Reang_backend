@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($sehat) ? 'Edit Tempat Sehat' : 'Tambah Tempat Sehat' }}</h2>

    <form method="POST" action="{{ isset($sehat) ? route('admin.sehat.update', $sehat->id) : route('admin.sehat.store') }}">
        @csrf
        @if(isset($sehat))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $sehat->name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="address" class="form-control">{{ old('address', $sehat->address ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Latitude</label>
            <input type="text" name="latitude" class="form-control" value="{{ old('latitude', $sehat->latitude ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Longitude</label>
            <input type="text" name="longitude" class="form-control" value="{{ old('longitude', $sehat->longitude ?? '') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
