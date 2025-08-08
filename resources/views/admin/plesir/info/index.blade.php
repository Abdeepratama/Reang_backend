@extends('admin.partials.app')

@section('title', 'Info Plesir')

@section('content')
<div class="container mt-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">Info Plesir</h2>
                <div class="row my-4">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <a href="{{ route('admin.plesir.info.create') }}" class="btn btn-primary mb-3">+ Tambah Info</a>

                                @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <table class="table datatables" id="infoTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Foto</th>
                                            <th>Judul</th>
                                            <th>Alamat</th>
                                            <th>Rating</th>
                                            <th>Kategori</th>
                                            <th>Deskripsi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($infoItems as $info)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><img src="{{ asset('storage/' . $info->foto) }}" width="100" alt="Foto"></td>
                                            <td>{{ $info->judul }}</td>
                                            <td>{{ $info->alamat }}</td>
                                            <td>{{ $info->rating }}</td>
                                            <td>{{ $info->fitur }}</td>
                                            <td>{{ Str::limit($info->deskripsi, 50) }}</td>
                                            <td>
                                                <a href="{{ route('admin.plesir.info.edit', $info->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('admin.plesir.info.destroy', $info->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Belum ada info.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- end section -->
            </div>
        </div>
    </div>
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
