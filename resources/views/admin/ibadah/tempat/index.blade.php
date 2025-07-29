@extends('admin.partials.app')

@section('title', 'Daftar Tempat Ibadah')

@section('content')
<div class="container mt-4">
    <h2>Daftar Tempat Ibadah</h2>

    <a href="{{ route('admin.ibadah.tempat.map') }}">Lihat Peta</a>


    <a href="{{ route('admin.ibadah.create') }}" class="btn btn-primary mb-3">+ Tambah Tempat Ibadah</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Agama</th>
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
                    <td>{{ $item->fitur }}</td>
                    <td>
                        <a href="{{ route('admin.ibadah.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.ibadah.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
