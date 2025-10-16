@extends('admin.partials.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">👤 Daftar Akun Admin</h3>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.accounts.create') }}" class="btn btn-primary mb-3">
        ➕ Tambah Akun
    </a>

    <table class="table table-bordered table-striped datatables" id="infoTable">
        <thead class="table-dark">
            <tr>
                <th style="width: 60px;">No</th>
                <th>Nama</th>
                <th>Role</th>
                <th>Dinas / Dokter</th>
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
                        <span class="badge bg-success">Super Admin</span>
                    @elseif($admin->role === 'admindinas')
                        <span class="badge bg-info">Admin Dinas</span>
                    @elseif($admin->role === 'dokter')
                        <span class="badge bg-danger">Dokter</span>
                    @endif
                </td>
                <td>
                    {{-- tampilkan nama instansi atau nama dokter tergantung role --}}
                    @if($admin->role === 'admindinas')
                        {{ $admin->instansi->nama ?? '-' }}
                    @elseif($admin->role === 'dokter')
                        {{ $admin->dokter->fitur ?? '-' }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.accounts.edit', $admin->id) }}" class="btn btn-sm btn-warning">
                        ✏️ Edit
                    </a>
                    <form action="{{ route('admin.accounts.destroy', $admin->id) }}" method="POST" style="display:inline;">
                        @csrf 
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus akun ini?')">
                            🗑️ Hapus
                        </button>
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
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "Semua"]
            ],
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ada data ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data tersedia",
                "infoFiltered": "(difilter dari total _MAX_ data)"
            }
        });
    });
</script>
@endsection
