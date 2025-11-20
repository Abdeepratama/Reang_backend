@extends('admin.partials.app')

@section('title', 'Kategori DUMAS')

@section('content')
<div class="container mt-5">

    {{-- Header & Tombol Tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-success mb-0">
            <i class="bi bi-tags-fill me-2"></i> Daftar Kategori DUMAS
        </h2>
        <a href="{{ route('admin.kategori_dumas.create') }}" class="btn btn-success shadow-sm px-4 py-2 text-white">
            <i class="bi bi-plus-circle me-1 text-white"></i> Tambah Kategori
        </a>
    </div>

    {{-- Pesan sukses --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm text-center" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- TABLE berdasarkan instansi --}}
    @forelse($kategoris->groupBy('id_instansi') as $idInstansi => $grouped)
    <div class="card border-0 shadow-sm mb-4">

        {{-- Header Instansi --}}
        <div class="card-header bg-success text-white fw-semibold rounded-top">
            <h5 class="mb-0 text-uppercase fw-semibold text-white">
                <i class="bi me-2"></i>
                {{ strtoupper(optional($grouped->first()->instansi)->nama ?? 'TANPA INSTANSI') }}
                <span class="badge bg-light text-success ms-2">{{ $grouped->count() }} Kategori</span>
            </h5>
        </div>

        {{-- Table --}}
        <div class="card-body p-0">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr class="text-center">
                        <th style="width:60px; color:#000; font-weight:450;">No</th>
                        <th style="color:#000; font-weight:450;">Nama Kategori</th>
                        <th style="width:150px; color:#000; font-weight:450;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grouped as $kategori)
                    <tr>
                        <td class="text-center" style="color:#000; font-weight:450;">
                            {{ $loop->iteration }}
                        </td>

                        <td style="color:#000; font-weight:450;">
                            {{ $kategori->nama_kategori }}
                        </td>

                        <td class="text-center d-flex justify-content-center" style="color:#000; font-weight:450;">

                            {{-- Edit --}}
                            <a href="{{ route('admin.kategori_dumas.edit', $kategori->id) }}"
                                class="btn btn-sm btn-outline-warning px-3 me-2">
                                <i class="bi bi-pencil-square me-1"></i> Edit
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('admin.kategori_dumas.destroy', $kategori->id) }}"
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

    {{-- Jika Kosong --}}
    <div class="text-center text-muted mt-5">
        <i class="bi bi-folder-x fs-1 d-block mb-2"></i>
        <p class="fw-semibold">Belum ada kategori DUMAS yang ditambahkan</p>
    </div>

    @endforelse
</div>
@endsection