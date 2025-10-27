@extends('admin.partials.app')

@section('title', 'Info Keagamaan')

@section('content')
<div class="container mt-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">Info Keagamaan</h2>
                <!-- <p class="card-text"></p> -->
                <div class="row my-4">
                    <!-- Small table -->
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <a href="{{ route('admin.ibadah.info.map') }}" class="btn btn-primary mb-3">Lihat Peta</a>
                                <a href="{{ route('admin.ibadah.info.create') }}" class="btn btn-primary mb-3">Tambah Info</a>

                                @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                <!-- table -->
                                <div class="table-responsive">
                                    <table class="table datatables" id="infoTable">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Foto</th>
                                                <th>Judul</th>
                                                <th>Tanggal</th>
                                                <th>Waktu</th>
                                                <th>Lokasi</th>
                                                <th>Kategori</th>
                                                <th>Deskripsi</th>
                                                <th>Latitude</th>
                                                <th>Longitude</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($infoItems as $info)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><img src="{{ asset('storage/' . $info->foto) }}" width="100" alt="Foto"></td>
                                                <td>{{ $info->judul }}</td>
                                                <td>{{ $info->tanggal }}</td>
                                                <td>{{ \Carbon\Carbon::parse($info->waktu)->format('H:i') }}</td>
                                                <td>{{ $info->lokasi }}</td>
                                                <td>{{ $info->fitur }}</td>
                                                <td>{{ Str::limit($info->deskripsi, 50) }}</td>
                                                <td>{{ $info->latitude }}</td>
                                                <td>{{ $info->longitude }}</td>
                                                <td>
                                                    <a href="{{ route('admin.ibadah.info.edit', $info->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                    <a href="{{ route('admin.ibadah.info.show', $info->id) }}" class="btn btn-info btn-sm">Detail</a>
                                                    <form action="{{ route('admin.ibadah.info.destroy', $info->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="9" class="text-center">Belum ada info.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> <!-- simple table -->
                </div> <!-- end section -->
            </div> <!-- .col-12 -->
        </div> <!-- .row -->
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
            "order": [
                [0, "desc"]
            ]
        });
    });
</script>
@endsection