@extends('admin.partials.app')

@section('title', 'Sekolah-Yu')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Dashboard Settings</h2>

    {{-- Tombol menuju daftar tempat --}}
    <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-primary">
        Lihat Kategori
    </a>

    <a href="{{ route('admin.slider.index') }}" class="btn btn-outline-primary">
        Lihat Sliders
    </a>
</div>
@endsection
