@extends('admin.partials.app')

@section('title', 'Tambah Puskesmas')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">🏥 Tambah Puskesmas</h3>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.sehat.puskesmas.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Puskesmas</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="jam" class="form-label">Jam Operasional</label>
            <input type="text" name="jam" class="form-control" placeholder="08:00 - 16:00" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
