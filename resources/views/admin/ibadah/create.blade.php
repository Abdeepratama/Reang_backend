@extends('admin.layouts.app')

@section('title', 'Edit Tempat Ibadah')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Tempat Ibadah</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
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
            <input type="text" name="name" class="form-control" value="{{ old('name', $item->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Alamat</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $item->address) }}">
        </div>

        <div class="mb-3">
            <label for="latitude" class="form-label">Latitude</label>
            <input type="text" name="latitude" class="form-control" value="{{ old('latitude', $item->latitude) }}" required>
        </div>

        <div class="mb-3">
            <label for="longitude" class="form-label">Longitude</label>
            <input type="text" name="longitude" class="form-control" value="{{ old('longitude', $item->longitude) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('admin.ibadah.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
