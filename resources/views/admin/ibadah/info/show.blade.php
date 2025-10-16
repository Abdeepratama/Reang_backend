@extends('admin.partials.app')

@section('title', 'Detail Info Keagamaan')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10"> {{-- dibuat lebih lebar --}}
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Detail Info Keagamaan</h4>
                    <a href="{{ route('admin.ibadah.info.index') }}" class="btn btn-light btn-sm">← Kembali</a>
                </div>
                <div class="card-body">

                    {{-- Foto --}}
                    <div class="mb-4 text-center">
                        @if($info->foto)
                            <img src="{{ Storage::url($info->foto) }}" 
                                 alt="Foto Info Keagamaan" 
                                 class="img-fluid rounded shadow-sm" 
                                 style="max-width: 450px;">
                        @else
                            <div class="text-muted">Tidak ada foto</div>
                        @endif
                    </div>

                    {{-- Judul --}}
                    <div class="mb-3">
                        <label class="fw-bold">Judul:</label>
                        <div class="form-control bg-light">{{ $info->judul }}</div>
                    </div>

                    {{-- Tanggal dan Waktu --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Tanggal:</label>
                            <div class="form-control bg-light">{{ \Carbon\Carbon::parse($info->tanggal)->format('d M Y') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Waktu:</label>
                            <div class="form-control bg-light">{{ \Carbon\Carbon::parse($info->waktu)->format('H:i') }}</div>
                        </div>
                    </div>

                    {{-- Lokasi & Alamat --}}
                    <div class="mb-3">
                        <label class="fw-bold">Lokasi:</label>
                        <div class="form-control bg-light">{{ $info->lokasi }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Alamat:</label>
                        <div class="form-control bg-light">{{ $info->alamat }}</div>
                    </div>

                    {{-- Kategori / Fitur --}}
                    <div class="mb-3">
                        <label class="fw-bold">Kategori / Fitur:</label>
                        <div class="form-control bg-light">{{ $info->fitur ?? '-' }}</div>
                    </div>

                    {{-- Koordinat --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Latitude:</label>
                            <div class="form-control bg-light">{{ $info->latitude }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Longitude:</label>
                            <div class="form-control bg-light">{{ $info->longitude }}</div>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-3">
                        <label class="fw-bold">Deskripsi:</label>
                        <div class="p-3 border rounded bg-light">
                            {!! $info->deskripsi !!}
                        </div>
                    </div>

                    {{-- Tanggal Buat & Update --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Dibuat pada:</label>
                            <div class="form-control bg-light">{{ $info->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Diperbarui pada:</label>
                            <div class="form-control bg-light">{{ $info->updated_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
