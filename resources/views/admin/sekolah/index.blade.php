@extends('admin.layouts.app')

@section('title', 'Sekolah-Yu')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Dashboard Fitur Sekolah</h2>

    {{-- Tombol menuju daftar tempat --}}
    <a href="{{ route('admin.sekolah.aduan.index') }}" class="btn btn-outline-primary">
        Lihat Daftar Lokasi Kesehatan
    </a>
</div>
@endsection
