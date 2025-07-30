@extends('admin.partials.app')

@section('title', 'Deskripsi Renbang')

@section('content')
<div class="container">
    <div class="mb-3 text-start">
        <a href="{{ route('admin.renbang.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
    <h1>Data Deskripsi Renbang</h1>
    <a href="{{ route('admin.renbang.create') }}" class="btn btn-primary mb-3">Tambah Data</a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr>
                <td>{{ $item->judul }}</td>
                <td>{{ $item->kategori }}</td>
                <td>{{ Str::limit(strip_tags($item->isi), 100) }}</td> {{-- tampilkan ringkasan isi --}}
                <td>
                    @if ($item->gambar)
                    <img src="{{ asset('storage/' . $item->gambar) }}" width="100">
                    @else
                    Tidak ada gambar
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.renbang.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('admin.renbang.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
