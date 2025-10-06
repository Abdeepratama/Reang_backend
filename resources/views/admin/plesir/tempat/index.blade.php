@extends('admin.partials.app')

@section('title', 'Daftar Tempat Plesir')

@section('content')
<div class="container mt-4">
    <h2>Daftar Tempat Plesir</h2>

    <a href="{{ route('admin.plesir.tempat.map') }}">🗺️ Lihat Peta</a>

    <a href="{{ route('admin.plesir.tempat.create') }}" class="btn btn-primary mb-3">+ Tambah Tempat Plesir</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table datatables" id="infoTable">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Kategori</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->address }}</td>
                    <td>{{ $item->latitude }}</td>
                    <td>{{ $item->longitude }}</td>
                    <td>{{ $item->fitur }}</td>
                    <td>
                        @if($item->foto)
                            <img src="{{ Storage::url($item->foto) }}" alt="Foto {{ $item->name }}" style="max-width:80px; height:auto;">
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.plesir.tempat.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">Edit</a>
                        <a href="{{ route('admin.plesir.tempat.show', $item->id) }}"
                            class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                        <form action="{{ route('admin.plesir.tempat.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-danger btn-sm" title="Hapus">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center">Belum ada data tempat plesir.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#plesirTable').DataTable({
            autoWidth: true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });
    });
</script>
@endsection
