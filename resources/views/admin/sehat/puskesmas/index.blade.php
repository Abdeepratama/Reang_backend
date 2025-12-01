@extends('admin.partials.app')

@section('title', 'Daftar Puskesmas')

@section('content')
<div class="container mt-4">
    <h2>Daftar Puskesmas</h2>

    <a href="{{ route('admin.sehat.puskesmas.map') }}" class="btn btn-primary mb-3">Lihat Peta</a>
    <a href="{{ route('admin.sehat.puskesmas.create') }}" class="btn btn-primary mb-3">Tambah Puskesmas</a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table datatables" id="infoTable">
        <thead class="table-dark">
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Alamat</th>
                <th class="text-center">Jam Operasional</th>
                <th class="text-center">Latitude</th>
                <th class="text-center">Longitude</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($puskesmas as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->alamat }}</td>
                <td>{{ $item->jam }}</td>
                <td>{{ $item->latitude }}</td>
                <td>{{ $item->longitude }}</td>
                <td>
                    <a href="{{ route('admin.sehat.puskesmas.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.sehat.puskesmas.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Belum ada data Puskesmas.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
