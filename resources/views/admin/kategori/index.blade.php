@extends('admin.partials.app')

@section('title', 'Kategori')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0 text-primary">
            <i class="bi bi-tags-fill me-2"></i>Daftar Kategori
        </h2>
        <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Kategori
        </a>
    </div>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Daftar kategori berdasarkan fitur --}}
    @foreach($kategoris->groupBy('fitur') as $fitur => $grouped)
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-secondary text-uppercase">
                    <i class="bi bi-grid-3x3-gap-fill me-2 text-primary"></i>{{ $fitur }}
                </h5>
                <span class="badge bg-primary rounded-pill">{{ $grouped->count() }}</span>
            </div>
            <ul class="list-group list-group-flush">
                @foreach($grouped as $kategori)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">{{ $kategori->nama }}</span>
                        <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger px-3">
                                <i class="bi bi-trash me-1"></i> Hapus
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach

    @if($kategoris->isEmpty())
        <div class="alert alert-info text-center mt-4 shadow-sm">
            <i class="bi bi-info-circle me-2"></i>Belum ada kategori yang ditambahkan.
        </div>
    @endif
</div>
@endsection
