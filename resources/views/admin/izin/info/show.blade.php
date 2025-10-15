@extends('admin.partials.app')

@section('title', 'Detail Info Perizinan')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Detail Info Perizinan</h4>
                    <a href="{{ route('admin.izin.info.index') }}" class="btn btn-light btn-sm">← Kembali</a>
                </div>
                <div class="card-body">

                    {{-- Foto --}}
                    <div class="mb-4 text-center">
                        @if($info->foto)
                            <img src="{{ Storage::url($info->foto) }}" 
                                 alt="Foto Info Perizinan" 
                                 class="img-fluid rounded shadow-sm" 
                                 style="max-width: 500px;">
                        @else
                            <div class="text-muted">Tidak ada foto</div>
                        @endif
                    </div>

                    {{-- Judul --}}
                    <div class="mb-3">
                        <label class="fw-bold">Judul:</label>
                        <div class="form-control bg-light">{{ $info->judul }}</div>
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

                    {{-- Waktu --}}
                    <div class="mb-3">
                        <label class="fw-bold">Dibuat pada:</label>
                        <div class="form-control bg-light">{{ $info->created_at->format('d M Y, H:i') }}</div>
                    </div>

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
