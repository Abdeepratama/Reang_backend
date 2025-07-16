@extends('admin.layouts.app')

@section('title', 'Kelola Slider')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Daftar Slider</h3>
    <a href="{{ route('admin.slider.create') }}" class="btn btn-primary">+ Tambah Gambar</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    @forelse ($items as $item)
    <div class="col-md-4 mb-4">
        <div class="card">
            <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
            <div class="card-body text-center">
                <a href="{{ route('admin.slider.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>

                <form action="{{ route('admin.slider.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus gambar ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <p class="text-muted">Belum ada slider ditambahkan.</p>
    @endforelse
</div>
@endsection
