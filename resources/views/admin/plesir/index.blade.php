@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Dashboard Fitur Plesir</h2>

    {{-- Tombol menuju daftar tempat --}}
    <a href="{{ route('admin.admin.plesir.tempat.index') }}" class="btn btn-outline-primary">
        Lihat Daftar Lokasi Plesir
    </a>
</div>
@endsection
