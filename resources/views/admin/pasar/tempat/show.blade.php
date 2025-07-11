@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Detail Lokasi Pasar</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $item->name }}</p>
            <p><strong>Alamat:</strong> {{ $item->address }}</p>
            <p><strong>Latitude:</strong> {{ $item->latitude }}</p>
            <p><strong>Longitude:</strong> {{ $item->longitude }}</p>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.pasar.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
        <a href="{{ route('admin.pasar.edit', $item->id) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('admin.pasar.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pasar ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
    </div>
</div>
@endsection
