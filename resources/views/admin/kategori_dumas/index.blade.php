@extends('admin.partials.app')

@section('title', 'Kategori DUMAS')

@section('content')
<div class="container mt-4">
    <h2>Kategori DUMAS</h2>

    <a href="{{ route('admin.kategori_dumas.create') }}" class="btn btn-primary mb-3">Tambah Kategori</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @foreach($kategoris->groupBy('id_instansi') as $idInstansi => $grouped)
        <h4>
            {{ strtoupper(optional($grouped->first()->instansi)->nama ?? 'TANPA INSTANSI') }}
        </h4>
        <ul class="list-group mb-3">
            @foreach($grouped as $kategori)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $kategori->nama_kategori }}
                    <form action="{{ route('admin.kategori_dumas.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
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
