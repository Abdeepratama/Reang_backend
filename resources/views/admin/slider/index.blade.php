@extends('admin.partials.app')

@section('title', 'Kelola Slider')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <div class="mb-3 text-start">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
    <h3>Daftar Slider</h3>
    <a href="{{ route('admin.slider.create') }}" class="btn btn-primary d-flex align-items-center gap-2 px-4 py-2 rounded-pill shadow-sm">
        <i class="bi bi-plus-circle"></i>
        <span>Tambah Gambar</span>
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    @forelse ($items as $item)
    <div class="col-md-4 mb-4">
        <div class="card">
            <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
            <div class="card-body text-center">
                <a href="{{ route('admin.slider.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>

                <form action="{{ route('admin.slider.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus gambar ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <p class="text-muted">Belum ada slider ditambahkan.</p>
    @endforelse
</div>
@endsection