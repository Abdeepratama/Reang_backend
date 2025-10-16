@extends('admin.partials.app')

@section('title', 'Detail Info Sekolah')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Detail Info Sekolah</h4>
            <a href="{{ route('admin.sekolah.info.index') }}" class="btn btn-light btn-sm">← Kembali</a>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Kolom Foto -->
                <div class="col-md-4 mb-3 text-center">
                    @if($info->foto)
                        <img src="{{ Storage::url($info->foto) }}" alt="Foto" class="img-fluid rounded shadow-sm" style="max-height: 250px;">
                    @else
                        <p class="text-muted fst-italic">Tidak ada foto</p>
                    @endif
                </div>

                <!-- Kolom Detail -->
                <div class="col-md-8">
                    <h5 class="fw-bold">{{ $info->judul }}</h5>
                    <p class="text-muted">
                        <small><i class="fe fe-calendar"></i> 
                            Dibuat: {{ $info->created_at->format('d M Y, H:i') }}
                        </small>
                    </p>

                    <hr>
                    <h6 class="fw-bold">Deskripsi:</h6>
                    <div class="border p-2 rounded" style="background-color:#fafafa">
                        {!! $info->deskripsi !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
