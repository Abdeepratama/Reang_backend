@extends('admin.partials.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Form DUMES-YU - Pengaduan Masyarakat</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('dumas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="jenis_laporan" class="form-label">Jenis Laporan</label>
            <input type="text" name="jenis_laporan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="kategori_laporan" class="form-label">Kategori Laporan</label>
            <input type="text" name="kategori_laporan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="lokasi_laporan" class="form-label">Lokasi Kejadian</label>
            <input type="text" name="lokasi_laporan" class="form-control">
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi Laporan</label>
            <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="bukti_laporan" class="form-label">Bukti Laporan (Foto)</label>
            <input type="file" name="bukti_laporan" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Kirim Pengaduan</button>
    </form>
</div>
@endsection
