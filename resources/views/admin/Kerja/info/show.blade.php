@extends('admin.partials.app')

@section('title', 'Detail Info Kerja')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Detail Info Kerja</h4>
                    <a href="{{ route('admin.kerja.info.index') }}" class="btn btn-light btn-sm">← Kembali</a>
                </div>
                <div class="card-body">

                    {{-- Foto --}}
                    <div class="mb-4 text-center">
                        @if($info->foto)
                            <img src="{{ Storage::url($info->foto) }}" 
                                 alt="Foto Info Kerja" 
                                 class="img-fluid rounded shadow-sm" 
                                 style="max-width: 400px;">
                        @else
                            <div class="text-muted">Tidak ada foto</div>
                        @endif
                    </div>

                    {{-- Nama Perusahaan --}}
                    <div class="mb-3">
                        <label class="fw-bold">Nama Perusahaan:</label>
                        <div class="form-control bg-light">{{ $info->name }}</div>
                    </div>

                    {{-- Posisi --}}
                    <div class="mb-3">
                        <label class="fw-bold">Posisi:</label>
                        <div class="form-control bg-light">{{ $info->judul }}</div>
                    </div>

                    {{-- Alamat --}}
                    <div class="mb-3">
                        <label class="fw-bold">Alamat:</label>
                        <div class="form-control bg-light">{{ $info->alamat }}</div>
                    </div>

                    {{-- Nomor Telepon --}}
                    <div class="mb-3">
                        <label class="fw-bold">Nomor Telepon:</label>
                        <div class="form-control bg-light">{{ $info->nomor_telepon ?? '-' }}</div>
                    </div>

                    {{-- Gaji --}}
                    <div class="mb-3">
                        <label class="fw-bold">Gaji:</label>
                        <div class="form-control bg-light">{{ $info->gaji ?? '-' }}</div>
                    </div>

                    {{-- Waktu Kerja --}}
                    <div class="mb-3">
                        <label class="fw-bold">Waktu Kerja:</label>
                        <div class="form-control bg-light">{{ $info->waktu_kerja ?? '-' }}</div>
                    </div>

                    {{-- Jenis Kerja --}}
                    <div class="mb-3">
                        <label class="fw-bold">Jenis Kerja:</label>
                        <div class="form-control bg-light">{{ $info->jenis_kerja ?? '-' }}</div>
                    </div>

                    {{-- Kategori --}}
                    <div class="mb-3">
                        <label class="fw-bold">Kategori:</label>
                        <div class="form-control bg-light">{{ $info->fitur ?? '-' }}</div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-3">
                        <label class="fw-bold">Deskripsi:</label>
                        <div class="p-3 border rounded bg-light">
                            {!! $info->deskripsi !!}
                        </div>
                    </div>

                    {{-- Waktu dibuat --}}
                    <div class="mb-3">
                        <label class="fw-bold">Dibuat pada:</label>
                        <div class="form-control bg-light">{{ $info->created_at->format('d M Y, H:i') }}</div>
                    </div>

                    {{-- Waktu diperbarui --}}
                    <div class="mb-3">
                        <label class="fw-bold">Diperbarui pada:</label>
                        <div class="form-control bg-light">{{ $info->updated_at->format('d M Y, H:i') }}</div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
