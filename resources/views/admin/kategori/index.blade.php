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

    {{-- Tabel per fitur --}}
    @forelse($kategoris->groupBy('fitur') as $fitur => $grouped)

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-primary text-white fw-semibold rounded-top">
            <h5 class="mb-0 text-uppercase fw-semibold text-white">
                <i class="bi me-2"></i>{{ $fitur }}
                <span class="badge bg-light text-primary ms-2">{{ $grouped->count() }} Kategori</span>
            </h5>
        </div>

        <div class="card-body p-0">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr class="text-center">
                        <tr class="text-center">
                        <th style="width:60px; color:#000; font-weight:450;">No</th>
                        <th style="color:#000; font-weight:450;">Nama Kategori</th>
                        <th style="width:150px; color:#000; font-weight:450;">Aksi</th>
                    </tr>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grouped as $index => $kategori)
                    <tr>
                         <td class="text-center" style="color:#000; font-weight:450;">
                            {{ $loop->iteration }}
                        </td>

                        <td style="color:#000; font-weight:450;">
                            {{ $kategori->nama }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.kategori.edit', $kategori->id) }}"
                                class="btn btn-sm btn-outline-warning px-3 me-2">
                                <i class="bi bi-pencil-square me-1"></i> Edit
                            </a>
                            <form action="{{ route('admin.kategori.destroy', $kategori->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger px-3">
                                    <i class="bi bi-trash3-fill me-1"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @empty
    <div class="text-center text-muted mt-5">
        <i class="bi bi-folder-x fs-1 d-block mb-2"></i>
        <p class="fw-semibold">Belum ada kategori yang ditambahkan.</p>
    </div>
    @endforelse

</div>

@endsection