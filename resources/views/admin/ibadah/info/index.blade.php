@extends('admin.partials.app')

@section('title', 'Info Keagamaan')

@section('content')
<div class="container mt-4">
    <h2>Info Keagamaan</h2>

    <a href="{{ route('admin.ibadah.info.create') }}" class="btn btn-primary mb-3">+ Tambah Info</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Judul</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Lokasi</th>
                <th>Kategori</th>
                <th>Deskripsi</th> {{-- Tambah ini --}}
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($infoItems as $info)
                <tr>
                    <td><img src="{{ asset('storage/' . $info->foto) }}" width="100" alt="Foto"></td>
                    <td>{{ $info->judul }}</td>
                    <td>{{ $info->tanggal }}</td>
                    <td>{{ $info->waktu }}</td>
                    <td>{{ $info->lokasi }}</td>
                    <td>{{ $info->fitur }}</td>
                    <td>{{ Str::limit($info->deskripsi, 50) }}</td> {{-- Tambah ini --}}
                    <td>
                        <a href="{{ route('admin.ibadah.info.edit', $info->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.ibadah.info.destroy', $info->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center">Belum ada info.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
