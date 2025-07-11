@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Dashboard Sekolah</h2>

    {{-- Tombol menuju daftar tempat --}}
    <a href="{{ route('admin.sekolah.aduan.index') }}" class="btn btn-outline-primary">
        Lihat Pengaduan Terhadap Sekolah
    </a>
</div>
@endsection
