@extends('admin.layouts.app')

@section('title', 'Deskripsi Renbang')

@section('content')
<div class="container">
    <h1>Data Deskripsi Renbang</h1>
    <a href="{{ route('admin.renbang.deskripsi.create') }}" class="btn btn-primary mb-3">Tambah Data</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thea>
            <tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>
                        @if($item->gambar)
                            <img src="{{ asset('storage/' . $items->gambar) }}" width="100">
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.renbang.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
