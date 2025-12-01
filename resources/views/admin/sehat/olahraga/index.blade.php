@extends('admin.partials.app')

@section('title', 'Data Tempat Olahraga')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Daftar Tempat Olahraga</h3>

    <a href="{{ route('admin.sehat.olahraga.map') }}" class="btn btn-primary mb-3">Lihat Peta</a>
    <a href="{{ route('admin.sehat.olahraga.create') }}" class="btn btn-primary mb-3">Tambah Data</a>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
        {{ session('error') }}
    </div>
    @endif

    <div class="table-responsive">
        <table class="table datatables" id="infoTable">
            <thead class="table-dark">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Latitude</th>
                    <th class="text-center">Longitude</th>
                    <th class="text-center">Alamat</th>
                    <th class="text-center">Foto</th>
                    <th class="text-center">Kategori</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $olahraga)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $olahraga->name }}</td>
                    <td>{{ $olahraga->latitude }}</td>
                    <td>{{ $olahraga->longitude }}</td>
                    <td>{{ $olahraga->address }}</td>
                    <td>
                        @if($olahraga->foto)
                        <img src="{{ $olahraga->foto ? asset('storage/'.$olahraga->foto) : '/images/placeholder.png' }}"
                            alt="Foto {{ $olahraga->name }}" width="80" height="80"
                            onerror="this.onerror=null; this.src='/images/placeholder.png';">
                        @else
                        <span class="text-muted">Tidak ada foto</span>
                        @endif
                    </td>
                    <td>{{ $olahraga->fitur }}</td>
                    <td>
                        <a href="{{ route('admin.sehat.olahraga.edit', $olahraga->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <a href="{{ route('admin.sehat.olahraga.show', $olahraga->id) }}"
                            class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                        <form action="{{ route('admin.sehat.olahraga.destroy', $olahraga->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data tempat olahraga</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection