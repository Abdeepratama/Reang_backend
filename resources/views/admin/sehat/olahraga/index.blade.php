@extends('admin.partials.app')

@section('title', 'Data Tempat Olahraga')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">🏟️ Data Tempat Olahraga</h3>

    <a href="{{ route('admin.sehat.olahraga.create') }}" class="btn btn-primary mb-3">➕ Tambah Data</a>

    <div class="table-responsive">
        <table class="table datatables" id="infoTable">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->latitude }}</td>
                        <td>{{ $item->longitude }}</td>
                        <td>{{ $item->address }}</td>
                        <td>
                            <a href="{{ route('admin.sehat.olahraga.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.sehat.olahraga.destroy', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data tempat olahraga</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
