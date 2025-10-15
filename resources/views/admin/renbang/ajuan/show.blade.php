@extends('admin.partials.app')

@section('content')
<div class="container mt-4">
    <h3>Detail Ajuan</h3>

    <div class="card mt-3">
        <div class="card-body">
            <p><strong>Judul:</strong> {{ $ajuan->judul }}</p>
            <p><strong>Kategori:</strong> {{ $ajuan->kategori }}</p>
            <p><strong>Lokasi:</strong> {{ $ajuan->lokasi }}</p>
            <p><strong>Deskripsi:</strong> {{ $ajuan->deskripsi }}</p>
            <p><strong>Status:</strong> {{ ucfirst($ajuan->status) }}</p>
            <p><strong>Tanggapan:</strong> {{ $ajuan->tanggapan ?? '-' }}</p>
        </div>
    </div>

    <a href="{{ route('admin.renbang.ajuan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
