@extends('admin.partials.app')

@section('title', 'Profil Admin')

@section('content')
<div class="container mt-5">

    {{-- Judul Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary mb-0">
            <i class="bi bi-person-circle me-2"></i> Profil Admin
        </h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Kartu Profil --}}
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-body p-4">
            <div class="row g-4 align-items-center">
                {{-- Foto Profil (opsional) --}}
                <div class="col-md-3 text-center">
                    <div class="position-relative d-inline-block">

                        @php
                        $photo = $admin->photo ? asset('storage/'.$admin->photo) : null;
                        $initial = strtoupper(substr($admin->name, 0, 1));
                        @endphp

                        @if($photo)
                        {{-- Foto Profil --}}
                        <img src="{{ $photo }}"
                            class="rounded-circle border border-3 border-primary shadow-sm"
                            style="width: 120px; height: 120px; object-fit: cover;"
                            alt="Foto Profil">
                        @else
                        {{-- Inisial jika tidak ada foto --}}
                        <div class="d-flex align-items-center justify-content-center 
                        rounded-circle bg-secondary text-white border border-3 border-primary shadow-sm"
                            style="width: 120px; height: 120px; font-size: 50px;">
                            {{ $initial }}
                        </div>
                        @endif
                    </div>

                    <p class="mt-3 mb-0 fw-bold text-capitalize fw-semibold">{{ $admin->name }}</p>
                </div>

                {{-- Info Detail --}}
                <div class="col-md-9">
                    <div class="row mb-3">
                        <div class="col-sm-6 mb-2">
                            <p class="mb-1 text-muted fw-semibold">
                                <i class="bi me-2"></i><strong>Email</strong>
                            </p>
                            <h6 class="fw-bold text-dark">{{ $admin->userData->email ?? '-' }}</h6>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <p class="mb-1 text-muted fw-semibold">
                                <i class="bi me-2"></i><strong>Nomer Handphone</strong>
                            </p>
                            <h6 class="fw-bold text-dark">{{ $admin->userData->no_hp ?? '-' }}</h6>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-6 mb-2">
                            <p class="mb-1 text-muted fw-semibold">
                                <i class="bi me-2"></i><strong>Role</strong>
                            </p>
                            <span class="fw-bold text-dark"
                                @if($admin->role === 'superadmin') 
                                @elseif($admin->role === 'admindinas')
                                @elseif($admin->role === 'puskesmas')
                                @else 
                                @endif>
                                {{ ucfirst($admin->role) }}
                            </span>
                        </div>

                        @if(!empty($admin->userData->instansi) || !empty($admin->userData->puskesmas))
                        <div class="col-sm-6 mb-2">
                            @if(!empty($admin->userData->instansi))
                            <p class="mb-1 text-muted fw-semibold">
                                <i class="bi me-2"></i><strong>Dinas</strong>
                            </p>
                            <h6>{{ $admin->userData->instansi->nama }}</h6>
                            @endif
                            @if(!empty($admin->userData->puskesmas))
                            <p class="mb-1 text-muted fw-semibold">
                                <i class="bi me-2"></i><strong>Puskesmas</strong>
                            </p>
                            <h6>{{ $admin->userData->puskesmas->nama }}</h6>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection