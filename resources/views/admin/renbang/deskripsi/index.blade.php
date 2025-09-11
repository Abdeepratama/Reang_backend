@extends('admin.partials.app')

@section('title', 'Deskripsi Renbang')

@section('content')
<div class="container mt-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">Deskripsi Renbang</h2>
                <div class="row my-4">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <a href="{{ route('admin.renbang.deskripsi.create') }}" class="btn btn-primary mb-3">+ Tambah Deskripsi</a>

                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <table class="table datatables" id="renbangTable">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Foto</th>
                                            <th>Judul</th>
                                            <th>Kategori</th>
                                            <th>Alamat</th>
                                            <th>Deskripsi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($renbangItems as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if($item->gambar)
                                                    <img src="{{ Storage::url($item->gambar) }}" width="100" alt="Foto" style="border-radius:8px;">
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->judul }}</td>
                                            <td>{{ $item->fitur }}</td>
                                            <td>{{ $item->alamat }}</td>
                                            <td>{{ Str::limit(strip_tags($item->deskripsi), 50) }}</td>
                                            <td>
                                                <a href="{{ route('admin.renbang.deskripsi.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('admin.renbang.deskripsi.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Belum ada deskripsi renbang.</td>
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
        $('#renbangTable').DataTable({
            autoWidth: true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "order": [[0, "asc"]]
        });
    });
</script>
@endsection
