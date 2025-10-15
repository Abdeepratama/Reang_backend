@extends('admin.partials.app')

@section('title', 'Info Kerja')

@section('content')
<div class="container mt-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">Info Kerja</h2>
                <div class="row my-4">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <a href="{{ route('admin.kerja.info.create') }}" class="btn btn-primary mb-3">+ Tambah Info Kerja</a>

                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <div class="table-responsive">
                                  <table class="table datatables" id="infoTable">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Perusahaan</th>
                                            <th>Foto</th>
                                            <th>Posisi</th>
                                            <th>Alamat</th>
                                            <th>Nomor telepon</th>
                                            <th>Gaji</th>
                                            <th>Waktu Kerja</th>
                                            <th>Jenis Kerja</th>
                                            <th>Kategori</th>
                                            <th>Deskripsi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($infoItems as $info)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $info->name }}</td>
                                            <td>
                                                @if($info->foto)
                                                    <img src="{{ Storage::url($info->foto) }}" width="100" alt="Foto">
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $info->judul }}</td>
                                            <td>{{ $info->alamat }}</td>
                                            <td>{{ $info->nomor_telepon ?? '-' }}</td>
                                            <td>{{ $info->gaji ?? '-' }}</td>
                                            <td>{{ $info->waktu_kerja ?? '-' }}</td>
                                            <td>{{ $info->jenis_kerja ?? '-' }}</td>
                                            <td>{{ $info->fitur }}</td>
                                            <td>{{ Str::limit($info->deskripsi, 50) }}</td>
                                            <td>
    <a href="{{ route('admin.kerja.info.show', $info->id) }}" class="btn btn-info btn-sm">Detail</a>
    <a href="{{ route('admin.kerja.info.edit', $info->id) }}" class="btn btn-warning btn-sm">Edit</a>
    <form action="{{ route('admin.kerja.info.destroy', $info->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm">Hapus</button>
    </form>
</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="10" class="text-center">Belum ada info kerja.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

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
        $('#infoKerjaTable').DataTable({
            autoWidth: true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "order": [[0, "asc"]] // urut No dari kecil ke besar
        });
    });
</script>
@endsection
