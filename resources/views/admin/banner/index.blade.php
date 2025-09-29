@extends('admin.partials.app')

@section('title', 'Daftar Banner')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-image"></i> Daftar Banner</h2>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.banner.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Tambah Banner
    </a>

    
    <table class="table datatables" id="infoTable">
            <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Foto</th>
                <th>Deskripsi</th>
                <th width="180">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>
                        @if($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="Banner" width="120" class="rounded">
                        @endif
                    </td>
                    <td>{!! Str::limit($item->deskripsi, 80) !!}</td>
                    <td>
                        <a href="{{ route('admin.banner.edit', $item->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <form action="{{ route('admin.banner.destroy', $item->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus banner ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada data banner</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#infoTable').DataTable({
            autoWidth: true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });
    });
</script>
@endsection