@extends('admin.partials.app')

@section('title', 'Kategori')

@section('content')
<div class="container mt-5">

    {{-- Header dan tombol tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary mb-0">
            <i class="bi bi-tags-fill me-2"></i> Daftar Kategori
        </h2>
        <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary shadow-sm px-4 py-2">
            <i class="bi bi-plus-circle me-1"></i> Tambah Kategori
        </a>
    </div>

    {{-- Pesan sukses --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm text-center" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Daftar kategori per fitur --}}
    @forelse($kategoris->groupBy('fitur') as $fitur => $grouped)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-primary text-white fw-semibold d-flex justify-content-between align-items-center rounded-top">
            <h5 class="mb-0 text-uppercase fw-semibold text-white">
                <i class="bi bi-grid-3x3-gap-fill me-2 text-white"></i>{{ $fitur }}
            </h5>
            <span class="badge bg-light text-primary">{{ $grouped->count() }} Kategori</span>
        </div>

        <ul class="list-group list-group-flush">
            @foreach($grouped as $kategori)
            <li class="list-group-item d-flex justify-content-between align-items-center hover-list-item">
                <div>
                    <i class="bi bi-tag-fill text-secondary me-2"></i>
                    <span class="fw-semibold">{{ $kategori->nama }}</span>
                </div>
                <form action="{{ route('admin.kategori.destroy', $kategori->id) }}"
                    method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger px-3">
                        <i class="bi bi-trash3-fill me-1"></i> Hapus
                    </button>
                </form>
            </li>
            @endforeach
        </ul>
    </div>
    @empty
    <div class="text-center text-muted mt-5">
        <i class="bi bi-folder-x fs-1 d-block mb-2"></i>
        <p class="fw-semibold">Belum ada kategori yang ditambahkan.</p>
    </div>
    @endforelse
</div>

{{-- Style tambahan --}}
<style>
    .hover-list-item {
        transition: background-color 0.2s ease, transform 0.1s ease;
        border-left: 4px solid transparent;
    }

    .hover-list-item:hover {
        background-color: #f8f9fa;
        transform: translateX(3px);
        border-left: 4px solid #0d6efd;
    }

    .card-header {
        border-radius: 10px 10px 0 0;
    }

    .card {
        border-radius: 15px;
    }
</style>
@endsection