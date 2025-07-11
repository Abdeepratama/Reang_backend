@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Dashboard Fitur Sehat</h2>

    {{-- Tombol menuju daftar tempat --}}
    <a href="{{ route('admin.sehat.tempat.index') }}" class="btn btn-outline-primary">
        Lihat Daftar Lokasi Kesehatan
    </a>
</div>
@endsection
