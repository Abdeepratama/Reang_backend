@extends('admin.partials.app')

@section('title', 'PLESIR-YU')

@section('content')
<div class="container">
    <div class="mb-3 text-start">
        <a href="{{ route('admin.plesir.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
    <h2>Daftar Lokasi Plesir</h2>
    <a href="{{ route('admin.plesir.create') }}" class="btn btn-primary mb-3">Tambah Lokasi</a>
    <table class="table table-bordered">
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
            @foreach($items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->address }}</td>
                <td>{{ $item->latitude }}</td>
                <td>{{ $item->longitude }}</td>
                <td>
                    <a href="{{ route('admin.plesir.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.plesir.destroy', $item->id) }}" method="POST" style="display:inline-block">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
