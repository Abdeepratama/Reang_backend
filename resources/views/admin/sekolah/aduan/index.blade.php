@extends('admin.layouts.app')

@section('title', 'Aduan Sekolah')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Daftar Aduan Sekolah</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Jenisa Laporan</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Status</th>
                <th>Bukti</th>
                <th>Deskripsi</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->jenis_laporan }}</td>
                <td>{{ $item->kategori_laporan }}</td>
                <td>{{ $item->lokasi_laporan ?? '-' }}</td>
                <td>
                    <form action="{{ route('admin.sekolah.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="d-flex">
                            <select name="status" class="form-select form-select-sm me-1">
                                <option value="menunggu" {{ $item->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="diproses" {{ $item->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ $item->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ $item->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">✔</button>
                        </div>
                    </form>
                </td>
                <td>
                    @if($item->bukti_laporan)
                    <img src="{{ asset('storage/' . $item->bukti_laporan) }}" alt="Bukti" width="80">
                    @else
                    <span class="text-muted">Tidak ada</span>
                    @endif
                </td>
                <td>{{ \Illuminate\Support\Str::limit($item->deskripsi, 80) }}</td>
                <td class="text-center">
                    <form action="{{ route('admin.sekolah.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">Belum ada aduan sekolah.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection