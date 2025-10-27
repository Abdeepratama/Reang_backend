@extends('admin.partials.app')

@section('title', 'Daftar Owner UMKM')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">👤 Daftar Owner UMKM</h3>

    <a href="{{ route('admin.pasar.umkm.owner.create') }}" class="btn btn-primary mb-3">➕ Tambah Owner</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>UMKM</th>
                            <th>Nama</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th>Foto</th>
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($owner as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->umkm->nama ?? '-' }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->no_hp }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td class="text-center">
                                    @if($item->foto)
                                        <img src="{{ asset('storage/'.$item->foto) }}" width="60" class="rounded">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.pasar.umkm.owner.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.pasar.umkm.owner.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted">Belum ada data Owner</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
