@extends('admin.layouts.app')

@section('title', 'Edit Slider')

@section('content')
<h3 class="mb-4">Edit Gambar Slider</h3>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.slider.update', $item->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="gambar" class="form-label">Ganti Gambar (Opsional)</label>
        <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
    </div>

    <div class="mb-3">
        <img src="{{ asset('storage/' . $item->gambar) }}" class="img-fluid rounded" style="max-height: 300px;">
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('admin.slider.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
