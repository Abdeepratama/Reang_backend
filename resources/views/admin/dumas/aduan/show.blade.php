@extends('admin.partials.app')

@section('title', 'Detail DUMAS-YU')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header text-white">
            <h4 class="mb-0">Detail Pengaduan Masyarakat</h4>
        </div>
        <div class="card-body">
            <a href="{{ route('admin.dumas.aduan.index') }}" class="btn btn-secondary mb-3">← Kembali</a>

            <table class="table table-bordered">
                <tr>
                    <th width="25%">Kategori</th>
                    <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Judul Laporan</th>
                    <td>{{ $item->jenis_laporan }}</td>
                </tr>
                <tr>
                    <th>Alamat / Lokasi</th>
                    <td>{{ $item->lokasi_laporan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Dibuat</th>
                    <td>{{ $item->created_at->format('d M Y, H:i') }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge 
                            @if($item->status == 'menunggu') bg-warning text-dark
                            @elseif($item->status == 'diproses') bg-info
                            @elseif($item->status == 'selesai') bg-success
                            @elseif($item->status == 'ditolak') bg-danger
                            @endif">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Deskripsi Laporan</th>
                    <td>{{ $item->deskripsi }}</td>
                </tr>
                <tr>
                    <th>Bukti Laporan</th>
                    <td>
                        @if($item->bukti_laporan)
                        <img src="{{ asset('storage/' . $item->bukti_laporan) }}"
                            alt="Bukti Laporan" class="img-fluid rounded"
                            style="max-width: 400px;">
                        @else
                        <span class="text-muted">Tidak ada bukti laporan</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Tanggapan Admin</th>
                    <td>
                        @if($item->tanggapan)
                        <div class="alert alert-success p-3">{{ $item->tanggapan }}</div>
                        @else
                        <span class="text-muted">Belum ada tanggapan</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Foto Tanggapan</th>
                    <td>
                        @if($item->foto_tanggapan)
                        <img src="{{ asset('storage/' . $item->foto_tanggapan) }}"
                            alt="Foto Tanggapan"
                            class="img-fluid rounded border"
                            style="max-width: 400px;">
                        @else
                        <span class="text-muted">Belum ada foto tanggapan</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Rating & Komentar</th>
                    <td>
                        @php $avgRating = $item->ratings->avg('rating'); @endphp
                        @if($avgRating)
                        <p><strong>⭐ {{ number_format($avgRating, 1) }}/5</strong></p>
                        <ul>
                            @foreach($item->ratings as $rating)
                            <li>
                                ⭐ {{ $rating->rating }} — {{ $rating->comment ?? 'Tidak ada komentar' }}
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <span class="text-muted">Belum ada rating atau komentar</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection