@extends('admin.partials.app')

@section('title', 'Kategori')

@section('content')
<div class="container mt-4">
    <h2>Kategori</h2>

    <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary mb-3">Tambah Kategori</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @foreach($kategoris->groupBy('fitur') as $fitur => $grouped)
        <h4>{{ strtoupper($fitur) }}</h4>
        <ul class="list-group mb-3">
            @foreach($grouped as $kategori)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $kategori->nama }}
                    <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endforeach
</div>
@endsection
