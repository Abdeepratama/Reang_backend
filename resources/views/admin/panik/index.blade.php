@extends('admin.partials.app')

@section('title', 'Daftar Panik Button')

@section('content')
<div class="container mt-4">
    <h2>Daftar Panik Button</h2>

    <a href="{{ route('admin.panik.create') }}" class="btn btn-primary mb-3">Tambah Panik Button</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Nomor</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($panikButtons as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ $item->nomer }}</td>
                    <td>
                        <a href="{{ route('admin.panik.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.panik.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Belum ada data Panik Button</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
