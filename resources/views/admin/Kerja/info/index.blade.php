@extends('admin.partials.app')

@section('title', 'Daftar Info Kerja')

@section('content')
<div class="container mt-4">
    <h2>Daftar Info Kerja</h2>

    <a href="{{ route('admin.kerja.info.create') }}" class="btn btn-primary mb-3">
        Tambah Info Kerja
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table datatables" id="infoTable">
        <thead class="table-dark">
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama Perusahaan</th>
                <th class="text-center">Posisi</th>
                <th class="text-center">Alamat</th>
                <th class="text-center">Gaji</th>
                <th class="text-center">Nomor Telepon</th>
                <th class="text-center">Kategori</th>
                <th class="text-center">Foto</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($infoItems as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>{{ $item->gaji ?? '-' }}</td>
                    <td>{{ $item->nomor_telepon ?? '-' }}</td>
                    <td>{{ $item->kategori->nama ?? $item->fitur }}</td>
                    <td>
                        @if($item->foto)
                            <img src="{{ asset('storage/'.$item->foto) }}" 
                                 alt="Foto {{ $item->judul }}" 
                                 width="80" height="80"
                                 onerror="this.onerror=null; this.src='/images/placeholder.png';">
                        @else
                            <span class="text-muted">Tidak ada foto</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.kerja.info.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                            Edit
                        </a>
                        <a href="{{ route('admin.kerja.info.show', $item->id) }}" class="btn btn-info btn-sm" title="Detail">
                            Detail
                        </a>
                        <form action="{{ route('admin.kerja.info.destroy', $item->id) }}" 
                              method="POST" 
                              style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Yakin ingin menghapus info kerja ini?')" 
                                    class="btn btn-danger btn-sm" 
                                    title="Hapus">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Belum ada data info kerja.</td>
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
            ],
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ditemukan data yang cocok",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Tidak ada data tersedia",
                "infoFiltered": "(difilter dari total _MAX_ data)"
            }
        });
    });
</script>
@endsection
