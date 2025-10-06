@extends('admin.partials.app')

@section('title', 'Detail Tempat Sekolah')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-bank"></i> Detail Tempat Sekolah</h2>

    <div class="card mt-3" style="max-width: 800px;">
        <div class="card-body">
            <h4>{{ $data->name }}</h4>
            <p><strong>Alamat:</strong> {{ $data->address }}</p>
            <p><strong>Latitude:</strong> {{ $data->latitude }}</p>
            <p><strong>Longitude:</strong> {{ $data->longitude }}</p>
            <p><strong>Kategori:</strong> {{ $data->kategori->nama ?? $data->fitur }}</p>

            @if($data->foto)
                <div class="mb-3">
                    <img src="{{ asset('storage/'.$data->foto) }}" 
                         alt="{{ $data->name }}" 
                         class="img-fluid rounded shadow">
                </div>
            @else
                <p><em>Tidak ada foto</em></p>
            @endif

            <div class="mt-4">
                <a href="{{ route('admin.sekolah.tempat.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('admin.sekolah.tempat.edit', $data->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
