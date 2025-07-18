@extends('admin.layouts.app')

@section('title', 'Dumas-Yu')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Dashboard Fitur Dumas</h2>

    {{-- Tombol menuju daftar tempat --}}
    <a href="{{ route('admin.dumas.aduan.index') }}" class="btn btn-outline-primary">
        Lihat Daftar Pengaduan
    </a>
</div>
@endsection
