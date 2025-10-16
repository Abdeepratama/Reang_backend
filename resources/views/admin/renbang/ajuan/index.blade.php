@extends('admin.partials.app')

@section('title', 'Ajuan RENBANG')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Daftar Ajuan RENBANG</h2>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped datatables" id="renbangTable">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th>Tanggapan</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ $item->lokasi }}</td>

                    {{-- Ubah status langsung di tabel --}}
                    <td>
                        <form action="{{ route('admin.renbang.ajuan.update', $item->id) }}" method="POST" class="d-flex align-items-center">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-select form-select-sm me-2">
                                <option value="menunggu" {{ $item->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="diproses" {{ $item->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ $item->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ $item->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary text-white">✔</button>
                        </form>
                    </td>

                    {{-- Isi tanggapan langsung di tabel --}}
                    <td>
                        <form action="{{ route('admin.renbang.ajuan.update', $item->id) }}" method="POST" class="d-flex align-items-center gap-2">
                            @csrf
                            @method('PUT')
                            <input type="text"
                                name="tanggapan"
                                class="form-control form-control-sm"
                                placeholder="Masukkan tanggapan"
                                value="{{ $item->tanggapan }}"
                                style="min-width: 250px;">
                            <button type="submit" class="btn btn-sm btn-success text-white">💾</button>
                        </form>
                    </td>

                    <td>{{ \Illuminate\Support\Str::limit($item->deskripsi, 60) }}</td>

                    {{-- Tombol aksi --}}
                    <td>
                        <a href="{{ route('admin.renbang.ajuan.show', $item->id) }}" class="btn btn-sm btn-info text-white">Detail</a>
                        <form action="{{ route('admin.renbang.ajuan.destroy', $item->id) }}"
                              method="POST"
                              style="display:inline;"
                              onsubmit="return confirm('Yakin ingin menghapus ajuan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger text-white">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#renbangTable').DataTable({
            autoWidth: true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ditemukan data",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Tidak ada data tersedia",
                "search": "Cari:",
                "paginate": { "next": "Berikutnya", "previous": "Sebelumnya" }
            }
        });
    });
</script>
@endsection
