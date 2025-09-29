@extends('admin.partials.app')

@section('title', 'DUMAS-YU')

@section('content')
<div class="container">

    <h2 class="mb-4">Daftar Pengaduan Masyarakat (DUMAS-YU)</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table datatables" id="infoTable">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>kategori</th>
                    <th>Judul Laporan</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th>Bukti</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Tanggapan</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->kategori->nama ?? '-' }}</td>
                    <td>{{ $item->jenis_laporan }}</td>
                    <td>{{ $item->lokasi_laporan ?? '-' }}</td>
                    <td>
                        <form action="{{ route('admin.dumas.aduan.update', $item->id) }}" method="POST">
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
                        <img src="{{ asset('storage/' . $item->bukti_laporan) }}" alt="Bukti" width="80">
                        @else
                        <span class="text-muted">Tidak ada</span>
                        @endif
                    </td>
                    <td>
                        @php
                        $avgRating = $item->ratings->avg('rating');
                        @endphp
                        @if($avgRating)
                        ⭐ {{ number_format($avgRating, 1) }}/5
                        @else
                        <span class="text-muted">Belum ada</span>
                        @endif
                    </td>
                    <td>
                        @if($item->ratings->whereNotNull('comment')->count())
                        <ul class="list-unstyled mb-0">
                            @foreach($item->ratings->whereNotNull('comment')->take(2) as $rating)
                            <li>- {{ \Illuminate\Support\Str::limit($rating->comment, 50) }}</li>
                            @endforeach
                            @if($item->ratings->whereNotNull('comment')->count() > 2)
                            <small class="text-muted">
                                +{{ $item->ratings->whereNotNull('comment')->count() - 2 }} komentar lagi
                            </small>
                            @endif
                        </ul>
                        @else
                        <span class="text-muted">Belum ada</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.dumas.aduan.update', $item->id) }}" method="POST" class="d-flex align-items-center gap-2">
                            @csrf
                            @method('PUT')
                            <div class="input-group w-100">
                                <input type="text" name="tanggapan"
                                    value="{{ $item->tanggapan }}"
                                    class="form-control form-control-lg"
                                    style="min-width: 300px; font-size: 1rem;"
                                    placeholder="Masukkan tanggapan">
                                <button type="submit" class="btb btn-success px-6">💾</button>
                            </div>
                        </form>
                    </td>
                    <td>{{ \Illuminate\Support\Str::limit($item->deskripsi, 80) }}</td>
                    <td>
                        <form action="{{ route('admin.dumas.aduan.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
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