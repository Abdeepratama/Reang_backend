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
                                <a href="{{ route('admin.plesir.info.map') }}">🗺️ Lihat Peta</a>
                                <a href="{{ route('admin.plesir.info.create') }}" class="btn btn-primary mb-3">+ Tambah Info Plesir</a>

                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <table class="table datatables" id="plesirTable">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Foto</th>
                                            <th>Judul</th>
                                            <th>Alamat</th>
                                            <th>Latitude</th>
                                            <th>Longitude</th>
                                            <th>Fitur</th>
                                            <th>Rating</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($infoItems as $info)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if($info->foto)
                                                    <img src="{{ Storage::url($info->foto) }}" width="100" alt="Foto">
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $info->judul }}</td>
                                            <td>{{ $info->alamat }}</td>
                                            <td>{{ $info->latitude }}</td>
                                            <td>{{ $info->longitude }}</td>
                                            <td>{{ $info->fitur }}</td>
                                            <td>{{ $info->rating }}</td>
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
                                            <td colspan="9" class="text-center">Belum ada info plesir.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div> <!-- col-md-12 -->
                </div> <!-- row -->
            </div> <!-- col-12 -->
        </div> <!-- row -->
    </div> 
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
            ],
            "order": [[0, "asc"]] // urut No dari kecil ke besar (baru di bawah)
        });
    });
</script>
@endsection
