@extends('admin.partials.app')

@section('title', 'Sekolah-Yu')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Dashboard Settings</h2>

    {{-- Tombol menuju daftar tempat --}}
    <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-primary">
        Kategori
    </a>

    <a href="{{ route('admin.kategori_dumas.index') }}" class="btn btn-outline-primary">
        Kategori Untuk Dumas
    </a>

    @if(Auth::guard('admin')->user()->role === 'superadmin')
    <a href="{{ route('admin.slider.index') }}" class="btn btn-outline-primary">
        Sliders
    </a>
    @endif

    <a href="{{ route('admin.banner.index') }}" class="btn btn-outline-primary">
        Banner
    </a>

    <a href="{{ route('admin.panik.index') }}" class="btn btn-outline-primary">
        Panik botton
    </a>
</div>
@endsection
