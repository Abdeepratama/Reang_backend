@extends('admin.partials.app')

@section('title', 'IBADAH-YU')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Dashboard Fitur Ibadah</h2>

    {{-- ubahh menggunakan tab --}}
    <a href="{{ route('admin.ibadah.tempat.index') }}" class="btn btn-outline-primary">
        Lihat Daftar Tempat Ibadah
    </a>
</div>
@endsection
