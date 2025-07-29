@extends('admin.partials.app')

@section('title', 'Tambah Slider')

@section('content')
<h3 class="mb-4">Tambah Gambar Slider</h3>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.slider.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="gambar" class="form-label">Pilih Gambar</label>
        <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.slider.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection