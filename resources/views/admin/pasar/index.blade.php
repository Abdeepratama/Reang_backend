@extends('admin.partials.app')

@section('title', 'Pasar-Yu')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Dashboard Fitur Pasar</h2>

    {{-- Tombol menuju daftar tempat --}}
    <a href="{{ route('admin.pasar.tempat.index') }}" class="btn btn-outline-primary">
        Lihat Daftar Lokasi Pasar
    </a>
</div>
@endsection
