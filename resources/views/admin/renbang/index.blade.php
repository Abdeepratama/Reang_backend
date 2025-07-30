@extends('admin.partials.app')

@section('title', 'Renbang-Yu')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Dashboard Fitur Renbang</h2>

    <a href="{{ route('admin.renbang.deskripsi.index') }}" class="btn btn-outline-primary">
    Lihat Deskripsi Rencana Pembangunan
</a>
</div>
@endsection