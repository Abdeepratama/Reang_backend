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
            <p><strong>Email:</strong> {{ $admin->userData->email ?? '-' }}</p>
            <p><strong>No. HP:</strong> {{ $admin->userData->no_hp ?? '-' }}</p>

            <p><strong>Role:</strong>
                @if($admin->role === 'superadmin')
                <span class="text-bg-primary rounded px-2">Super Admin</span>
                @elseif($admin->role === 'admindinas')
                <span class="text-bg-success rounded px-2">Admin Dinas</span>
                @elseif($admin->role === 'puskesmas')
                <span class="text-bg-warning rounded px-2">Puskesmas</span>
                @else
                <span class="text-bg-secondary rounded px-2">{{ ucfirst($admin->role) }}</span>
                @endif
            </p>

            @if(!empty($admin->userData->instansi) || !empty($admin->userData->puskesmas))
            <p>
                @if(!empty($admin->userData->instansi))
                <strong>Dinas:</strong> {{ $admin->userData->instansi->nama }} <br>
                @endif
                @if(!empty($admin->userData->puskesmas))
                <strong>Puskesmas:</strong> {{ $admin->userData->puskesmas->nama }}
                @endif
            </p>
            @endif
        </div>
    </div>

    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
</div>
@endsection