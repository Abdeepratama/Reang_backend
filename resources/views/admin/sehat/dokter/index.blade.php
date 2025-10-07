@extends('admin.partials.app')

@section('title', 'Daftar Dokter')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">👨‍⚕️ Daftar Dokter</h3>

    {{-- Tombol Tambah --}}
    <a href="{{ route('admin.sehat.dokter.create') }}" class="btn btn-primary mb-3">
        ➕ Tambah Dokter
    </a>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tabel Dokter --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="dokterTable" class="table table-bordered table-striped align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>Puskesmas</th>
                            <th>Nama</th>
                            <th>Pendidikan</th>
                            <th>Spesialisasi</th>
                            <th>Masa Kerja</th>
                            <th>Nomor STR</th>
                            <th>Foto</th>
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dokter as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->puskesmas->nama ?? '-' }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->pendidikan }}</td>
                                <td>{{ $item->fitur }}</td>
                                <td class="text-center">{{ $item->masa_kerja }}</td>
                                <td>{{ $item->nomer }}</td>
                                <td class="text-center">
                                    @if($item->foto)
                                        <img src="{{ asset('storage/'.$item->foto) }}" alt="Foto Dokter" width="60" class="rounded">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.sehat.dokter.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                        ✏️ Edit
                                    </a>
                                    <form action="{{ route('admin.sehat.dokter.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">Belum ada data dokter.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#dokterTable').DataTable({
            autoWidth: false,
            responsive: true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "Semua"]
            ]
        });
    });
</script>
@endsection
