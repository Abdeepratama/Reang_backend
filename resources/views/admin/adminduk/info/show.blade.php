@extends('admin.partials.app')

@section('title', 'Detail Info Adminduk')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detail Info Adminduk</h4>
        </div>
        <div class="card-body">

            <div class="mb-3 text-center">
                @if($item->foto)
                    <img src="{{ asset('storage/' . $item->foto) }}" class="img-fluid rounded shadow-sm" style="max-width: 400px;" alt="Foto Info">
                @else
                    <p class="text-muted fst-italic">Tidak ada foto</p>
                @endif
            </div>

            <div class="mb-3">
                <h5><strong>Judul:</strong></h5>
                <p>{{ $item->judul }}</p>
            </div>

            <div class="mb-3">
                <h5><strong>Deskripsi:</strong></h5>
                <div class="border rounded p-3 bg-light">
                    {!! $item->deskripsi !!}
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Dibuat pada:</strong> {{ $item->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div class="col-md-6 text-end">
                    <p><strong>Terakhir diubah:</strong> {{ $item->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('admin.adminduk.info.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
