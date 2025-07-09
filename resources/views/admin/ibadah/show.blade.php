@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Detail Tempat Ibadah</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $ibadah->name }}</p>
            <p><strong>Alamat:</strong> {{ $ibadah->address }}</p>
            <p><strong>Latitude:</strong> {{ $ibadah->latitude }}</p>
            <p><strong>Longitude:</strong> {{ $ibadah->longitude }}</p>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.ibadah.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('admin.ibadah.edit', $ibadah->id) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('admin.ibadah.destroy', $ibadah->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
    </div>
</div>
@endsection
