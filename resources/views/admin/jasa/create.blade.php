@extends('admin.partials.app')

@section('title', 'Tambah Jasa Pengiriman')

@section('content')
<div class="container mt-5">

    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Tambah Jasa Pengiriman</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.jasa.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Jasa</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary px-4">Simpan</button>
                <a href="{{ route('admin.jasa.index') }}" class="btn btn-secondary px-4">Kembali</a>
            </form>
        </div>
    </div>

</div>
@endsection
