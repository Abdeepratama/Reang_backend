@extends('admin.partials.app')

@section('title', 'Daftar Akun Admin')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Daftar Akun Admin</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.accounts.create') }}" class="btn btn-primary mb-3">Tambah Akun</a>

    <table class="table table-bordered table-striped datatables" id="infoTable">
        <thead class="table-dark">
            <tr>
                <th width="60">No</th>
                <th>Nama</th>
                <th>Role</th>
                <th>Instansi / Puskesmas / UMKM</th>
                <th width="180">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($admins as $admin)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $admin->name }}</td>
                <td>
                    @if($admin->role === 'superadmin')
                        <span class="text-bg-primary rounded px-2">Super Admin</span>
                    @elseif($admin->role === 'admindinas')
                        <span class="text-bg-primary rounded px-2">Admin Dinas</span>
                    @elseif($admin->role === 'puskesmas')
                        <span class="text-bg-primary rounded px-2">Puskesmas</span>
                    @elseif($admin->role === 'dokter')
                        <span class="text-bg-primary rounded px-2">Dokter</span>
                    @elseif($admin->role === 'umkm')
                        <span class="text-bg-primary rounded px-2">UMKM</span>
                    @endif
                </td>
                <td>
                    @if($admin->role === 'admindinas')
                        {{ $admin->userData->instansi->nama ?? '-' }}
                    @elseif($admin->role === 'puskesmas' || $admin->role === 'dokter')
                        {{ $admin->userData->puskesmas->nama ?? '-' }}
                    @elseif($admin->role === 'umkm')
                        {{ $admin->userData->umkm->nama ?? '-' }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.accounts.edit', $admin->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.accounts.destroy', $admin->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus akun ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada akun terdaftar</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#infoTable').DataTable({
            autoWidth: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
            language: {
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Tidak ada data ditemukan",
                info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                infoEmpty: "Tidak ada data tersedia",
                infoFiltered: "(difilter dari total _MAX_ data)"
            }
        });
    });
</script>
@endsection
