@extends('admin.partials.app')

@section('content')
<div class="container">
    <h2>Daftar Akun</h2>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.accounts.create') }}" class="btn btn-primary mb-3">Tambah Akun</a>

    <table class="table datatables" id="infoTable">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Dinas</th>
                <th width="180">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($admins as $admin)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $admin->name }}</td>
                <td>{{ $admin->email }}</td>
                <td>
                    @if($admin->role === 'superadmin')
                        <span class="badge bg-success">Super Admin</span>
                    @elseif($admin->role === 'admindinas')
                        <span class="badge bg-info">Admin Dinas</span>
                    @endif
                </td>
                <td>
                    {{ $admin->dinas ?? '-' }}
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
                <td colspan="5" class="text-center">Belum ada akun</td>
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
                [10, 25, 50, "All"]
            ]
        });
    });
</script>
@endsection