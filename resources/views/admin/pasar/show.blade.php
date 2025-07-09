@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Detail Lokasi Pasar</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $pasar->name }}</p>
            <p><strong>Alamat:</strong> {{ $pasar->address }}</p>
            <p><strong>Latitude:</strong> {{ $pasar->latitude }}</p>
            <p><strong>Longitude:</strong> {{ $pasar->longitude }}</p>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.pasar.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
        <a href="{{ route('admin.pasar.edit', $pasar->id) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('admin.pasar.destroy', $pasar->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pasar ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
    </div>
</div>
@endsection
