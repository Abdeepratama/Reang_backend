@extends('admin.partials.app')

@section('title', 'Edit Jasa Pengiriman')

@section('content')
<div class="container mt-5">

    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0">Edit Jasa Pengiriman</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.jasa.update', $jasa->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Jasa</label>
                    <input type="text" name="nama"
                        value="{{ $jasa->nama }}"
                        class="form-control @error('nama') is-invalid @enderror">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-warning text-white px-4">Update</button>
                <a href="{{ route('admin.jasa.index') }}" class="btn btn-secondary px-4">Kembali</a>
            </form>
        </div>
    </div>

</div>
@endsection
