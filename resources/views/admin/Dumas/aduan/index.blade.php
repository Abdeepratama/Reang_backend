@extends('admin.partials.app')

@section('title', 'DUMAS-YU')

@section('content')
<div class="container">
    <div class="mb-3 text-start">
        <a href="{{ route('admin.dumas.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
    
    <h2 class="mb-4">Daftar Pengaduan Masyarakat (DUMAS-YU)</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table datatables" id="infoTable">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Jenis Laporan</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Status</th>
                <th>Bukti</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->jenis_laporan }}</td>
                <td>{{ $item->kategori_laporan }}</td>
                <td>{{ $item->lokasi_laporan ?? '-' }}</td>
                <td>
                    <form action="{{ route('admin.dumas.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="d-flex">
                            <select name="status" class="form-select form-select-sm me-1">
                                <option value="menunggu" {{ $item->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="diproses" {{ $item->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ $item->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ $item->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary text-white">✔</button>
                        </div>
                    </form>
                </td>
                <td>
                    @if($item->bukti_laporan)
                        <img src="{{ asset($item->bukti_laporan) }}" alt="Bukti" width="80">
                    @else
                        <span class="text-muted">Tidak ada</span>
                    @endif
                </td>
                <td>{{ \Illuminate\Support\Str::limit($item->deskripsi, 80) }}</td>
                <td>
                    <form action="{{ route('admin.dumas.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
