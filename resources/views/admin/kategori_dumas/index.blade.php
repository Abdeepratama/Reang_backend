@extends('admin.partials.app')

@section('title', 'Kategori DUMAS')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center fw-bold text-primary">
        Kategori Dumas
    </h2>

    {{-- Tombol Tambah --}}
    <div class="text-start mb-4">
        <a href="{{ route('admin.kategori_dumas.create') }}" class="btn btn-primary shadow-sm px-4 py-2">
            <i class="bi bi-plus-circle me-1"></i> Tambah Kategori
        </a>
    </div>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success text-center shadow-sm rounded-3">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Daftar kategori --}}
    @forelse($kategoris->groupBy('id_instansi') as $idInstansi => $grouped)
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white fw-semibold d-flex justify-content-between align-items-center">
                <span>
                    <i class="bi bi-building me-2"></i>
                    {{ strtoupper(optional($grouped->first()->instansi)->nama ?? 'TANPA INSTANSI') }}
                </span>
                <span class="badge bg-light text-primary">{{ $grouped->count() }} Kategori</span>
            </div>

            <ul class="list-group list-group-flush">
                @foreach($grouped as $kategori)
                    <li class="list-group-item d-flex justify-content-between align-items-center hover-list-item">
                        <div>
                            <i class="bi bi-tag-fill text-secondary me-2"></i>
                            {{ $kategori->nama_kategori }}
                        </div>
                        <form action="{{ route('admin.kategori_dumas.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash3-fill"></i> Hapus
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    @empty
        <div class="text-center text-muted mt-5">
            <i class="bi bi-folder-x fs-1 d-block mb-2"></i>
            <p class="fw-semibold">Belum ada kategori DUMAS yang ditambahkan.</p>
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
