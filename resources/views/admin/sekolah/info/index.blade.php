@extends('admin.partials.app')

@section('title', 'Info Sekolah')

@section('content')
<div class="container mt-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">Info Sekolah</h2>
                <div class="row my-4">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <a href="{{ route('admin.sekolah.info.create') }}" class="btn btn-primary mb-3">+ Tambah Info Sekolah</a>

                                @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <table class="table datatables" id="infoTable">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Foto</th>
                                            <th>Judul</th>
                                            <th>Deskripsi</th>
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
                                            <td>{{ Str::limit($info->deskripsi, 50) }}</td>
                                            <td>
                                                <a href="{{ route('admin.sekolah.info.show', $info->id) }}" class="btn btn-info btn-sm">Detail</a>
                                                <a href="{{ route('admin.sekolah.info.edit', $info->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('admin.sekolah.info.destroy', $info->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Belum ada info sekolah</td>
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
        $('#infoTable').DataTable({
            autoWidth: true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
        });
    });
</script>
@endsection