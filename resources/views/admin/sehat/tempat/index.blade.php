@extends('admin.layouts.app')

@section('title', 'Data Lokasi Sehat')

@section('content')
<div class="container">
    <div class="mb-3 text-start">
        <a href="{{ route('admin.sehat.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
    
    <a href="{{ route('admin.sehat.create') }}" class="btn btn-primary mb-3">Tambah Lokasi</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->address }}</td>
                <td>{{ $item->latitude }}</td>
                <td>{{ $item->longitude }}</td>
                <td>
                    <a href="{{ route('admin.sehat.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.sehat.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada data lokasi sehat.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
