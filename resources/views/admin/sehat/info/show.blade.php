@extends('admin.partials.app')

@section('title', 'Detail Info Sehat')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Detail Info Sehat</h4>
                    <a href="{{ route('admin.sehat.info.index') }}" class="btn btn-light btn-sm">← Kembali</a>
                </div>
                <div class="card-body">
                    {{-- Foto --}}
                    <div class="mb-4 text-center">
                        @if($info->foto)
                            <img src="{{ Storage::url($info->foto) }}" alt="Foto Info" class="img-fluid rounded" style="max-width: 350px;">
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
                        <div class="form-control bg-light">
                            {{ $info->kategori->nama ?? $info->fitur }}
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-3">
                        <label class="fw-bold">Deskripsi:</label>
                        <div class="p-3 border rounded bg-light">
                            {!! $info->deskripsi !!}
                        </div>
                    </div>

                    {{-- Tanggal --}}
                    <div class="mb-3">
                        <label class="fw-bold">Dibuat pada:</label>
                        <div class="form-control bg-light">{{ $info->created_at->format('d M Y, H:i') }}</div>
                    </div>

                    <div class="text-end mt-4">
                        <a href="{{ route('admin.sehat.info.edit', $info->id) }}" class="btn btn-warning">
                            ✏️ Edit
                        </a>
                        <form action="{{ route('admin.sehat.info.destroy', $info->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger">
                                🗑 Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
