@extends('admin.partials.app')

@section('title', 'PLESIR-YU')

@section('content')
<div class="container">
    <h2>Tambah Lokasi Plesir</h2>

    <form method="POST" action="{{ route('admin.plesir.store') }}">
        @csrf

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="address" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Latitude</label>
            <input type="text" name="latitude" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Longitude</label>
            <input type="text" name="longitude" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
