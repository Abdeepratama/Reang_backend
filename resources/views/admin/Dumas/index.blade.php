@extends('admin.layouts.app')

@section('title', 'Dumas-Yu')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Dashboard Dumas</h2>

    {{-- Tombol menuju daftar tempat --}}
    <a href="{{ route('admin.sekolah.aduan.index') }}" class="btn btn-outline-primary">
        Lihat Pengaduan Masyarakat
    </a>

</div>
@endsection