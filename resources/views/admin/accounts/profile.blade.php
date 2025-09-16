@extends('admin.partials.app')

@section('content')
<div class="container mt-4">
    <h2>Profil Admin</h2>

    {{-- Notifikasi sukses jika ada --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mt-3 shadow-sm">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $admin->name }}</p>
            <p><strong>Email:</strong> {{ $admin->email }}</p>
            
            <p><strong>Role:</strong> 
                @if($admin->role === 'superadmin')
                    <span class="badge bg-primary">Super Admin</span>
                @elseif($admin->role === 'admindinas')
                    <span class="badge bg-success">Admin Dinas</span>
                @else
                    <span class="badge bg-secondary">{{ $admin->role }}</span>
                @endif
            </p>

            @if(!empty($admin->dinas))
                <p><strong>Dinas:</strong> {{ $admin->dinas }}</p>
            @endif

        </div>
    </div>

    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
</div>
@endsection
