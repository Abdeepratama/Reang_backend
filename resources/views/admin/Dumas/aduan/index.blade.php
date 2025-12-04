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
                    <th class="text-center">No</th>
                    <th class="text-center">kategori</th>
                    <th class="text-center">Jenis Laporan</th>
                    <th class="text-center">Alamat</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Bukti</th>
                    <th class="text-center">Rating</th>
                    <th class="text-center">Comment</th>
                    <th class="text-center">Tanggapan</th>
                    <th class="text-center">Deskripsi</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>

                        @if(auth('admin')->user()->role === 'superadmin')

                        {{-- SUPERADMIN: boleh ubah kategori --}}
                        <form action="{{ route('admin.dumas.aduan.update.instansi', $item->id) }}" method="POST">
                            @csrf

                            <div class="d-flex">
                                <select name="id_instansi" class="form-select form-select-sm me-1">
                                    @foreach($instansiList as $ins)
                                    <option value="{{ $ins->id }}"
                                        {{ $item->kategori->id_instansi == $ins->id ? 'selected' : '' }}>
                                        {{ $ins->nama }}
                                    </option>
                                    @endforeach
                                </select>

                                <button class="btn btn-primary btn-sm">✔</button>
                            </div>
                        </form>

                        @else

                        {{-- ADMIN DINAS: hanya melihat, tidak bisa mengubah --}}
                        <span class="color:#000; font-weight:450;">
                            {{ $item->kategori->nama_kategori }}
                        </span>

                        @endif

                    </td>
                    <td>{{ $item->jenis_laporan }}</td>
                    <td>{{ $item->lokasi_laporan ?? '-' }}</td>
                    <td>
                        <form action="{{ route('admin.dumas.aduan.update.status', $item->id) }}" method="POST">
                            @csrf
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
                    <td class="align-top">

                        {{-- Foto Tanggapan --}}
                        <div class="text-center mb-3">
                            @if($item->foto_tanggapan)
                            <img src="{{ asset('storage/'.$item->foto_tanggapan) }}"
                                class="rounded border"
                                style="width: 100%; max-width: 170px;">
                            @else
                            <div class="text-muted small">Belum ada foto</div>
                            @endif
                        </div>

                        {{-- Form untuk tanggapan & foto --}}
                        <form action="{{ route('admin.dumas.aduan.update.tanggapan_foto', $item->id) }}"
                            method="POST" enctype="multipart/form-data"
                            class="p-2 border rounded" style="width:170px;margin:auto;">

                            @csrf

                            <div class="mb-2">
                                <input type="text" name="tanggapan"
                                    value="{{ $item->tanggapan }}"
                                    class="form-control form-control-sm text-center"
                                    placeholder="Masukkan tanggapan">
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Foto Tanggapan</label>
                                <input type="file"
                                    name="foto_tanggapan"
                                    class="form-control form-control-sm validate-image @error('foto_tanggapan') is-invalid @enderror"
                                    accept="image/*">

                                @error('foto_tanggapan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success btn-sm w-100 mt-2">
                                Simpan
                            </button>

                        </form>
                    </td>
                    <td>{{ \Illuminate\Support\Str::limit($item->deskripsi, 80) }}</td>
                    <td>
                        <a href="{{ route('admin.dumas.aduan.show', $item->id) }}" class="btn btn-info btn-sm text-white">Detail</a>
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
    document.querySelectorAll('.validate-image').forEach(input => {
        input.addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;

            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];

            if (!allowedTypes.includes(file.type)) {
                alert('File harus berupa gambar (jpeg, png, jpg, atau gif).');
                this.value = ""; // reset input
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran maksimal 2MB.');
                this.value = "";
                return;
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#infoTable').DataTable({
            autoWidth: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });
    });
</script>
@endsection