@extends('admin.partials.app')

@section('title', 'Sekolah-Yu')

@section('content')
<div class="container mt-5">
    <h2 class="mb-5 text-center fw-bold">
        Dashboard Settings
    </h2>

    {{-- Grid Tombol --}}
    <div class="row g-4 mt-4">

        {{-- Kategori --}}
        <div class="col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-tags-fill fs-1 text-primary"></i>
                    </div>
                    <h5 class="card-title fw-bold">Kategori</h5>
                    <p class="card-text text-muted">Kelola kategori untuk seluruh fitur aplikasi</p>
                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-primary w-100">Kelola</a>
                </div>
            </div>
        </div>

        {{-- Kategori DUMAS --}}
        <div class="col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-collection-fill fs-1 text-success"></i>
                    </div>
                    <h5 class="card-title fw-bold">Kategori Dumas</h5>
                    <p class="card-text text-muted">Atur kategori untuk pengaduan masyarakat</p>
                    <a href="{{ route('admin.kategori_dumas.index') }}" class="btn btn-success w-100">Kelola</a>
                </div>
            </div>
        </div>

        {{-- Sliders (hanya Superadmin) --}}
        @if(Auth::guard('admin')->user()->role === 'superadmin')
        <div class="col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-images fs-1 text-warning"></i>
                    </div>
                    <h5 class="card-title fw-bold">Sliders</h5>
                    <p class="card-text text-muted">Kelola tampilan slider pada beranda utama</p>
                    <a href="{{ route('admin.slider.index') }}" class="btn btn-warning text-white w-100">Kelola</a>
                </div>
            </div>
        </div>
        @endif

        {{-- Banner --}}
        @if(Auth::guard('admin')->user()->role === 'superadmin')
        <div class="col-md-4 col-sm-6 mt-4">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-megaphone-fill fs-1 text-danger"></i>
                    </div>
                    <h5 class="card-title fw-bold">Banner</h5>
                    <p class="card-text text-muted">Atur banner informasi pada tampilan aplikasi</p>
                    <a href="{{ route('admin.banner.index') }}" class="btn btn-danger w-100">Kelola</a>
                </div>
            </div>
        </div>
        @endif

        {{-- Panik Button --}}
        @if(Auth::guard('admin')->user()->role === 'superadmin')
        <div class="col-md-4 col-sm-6 mt-4">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-exclamation-triangle-fill fs-1 text-secondary"></i>
                    </div>
                    <h5 class="card-title fw-bold">Panik Button</h5>
                    <p class="card-text text-muted">Kelola tombol panggilan darurat</p>
                    <a href="{{ route('admin.panik.index') }}" class="btn btn-secondary w-100">Kelola</a>
                </div>
            </div>
        </div>
        @endif

        @if(Auth::guard('admin')->user()->role === 'superadmin')
        <div class="col-md-4 col-sm-6 mt-4">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-truck fs-1 text-secondary"></i>
                    </div>
                    <h5 class="card-title fw-bold">Jasa Pengiriman</h5>
                    <p class="card-text text-muted">Tombol kelola jasa pengiriman</p>
                    <a href="{{ route('admin.jasa.index') }}" class="btn btn-secondary w-100">Kelola</a>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

{{-- Style tambahan --}}
<style>
    .hover-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-radius: 15px;
    }
    .hover-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
</style>
@endsection
