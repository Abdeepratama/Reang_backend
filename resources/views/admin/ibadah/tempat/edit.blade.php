@extends('admin.layouts.app')

@section('title', 'IBADAH-YU')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Tempat Ibadah</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.ibadah.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama Tempat Ibadah</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $item->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Alamat</label>
            <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $item->address) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="latitude" class="form-label">Latitude</label>
            <input type="text" class="form-control" id="latitude" name="latitude" value="{{ old('latitude', $item->latitude) }}" required>
        </div>

        <div class="mb-3">
            <label for="longitude" class="form-label">Longitude</label>
            <input type="text" class="form-control" id="longitude" name="longitude" value="{{ old('longitude', $item->longitude) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Perbarui</button>
        <a href="{{ route('admin.ibadah.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
