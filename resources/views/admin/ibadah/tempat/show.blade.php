@extends('admin.partials.app')

@section('title', 'IBADAH-YU')

@section('content')
<div class="container mt-4">
    <h2>Detail Tempat Ibadah</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $item->name }}</p>
            <p><strong>Alamat:</strong> {{ $item->address }}</p>
            <p><strong>Latitude:</strong> {{ $item->latitude }}</p>
            <p><strong>Longitude:</strong> {{ $item->longitude }}</p>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.ibadah.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('admin.ibadah.edit', $item->id) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('admin.ibadah.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
    </div>
</div>
@endsection
