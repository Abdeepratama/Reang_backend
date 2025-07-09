@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Pengguna</h6>
                        <h2 class="mb-0">{{ $stats['total_users'] }}</h2>
                    </div>
                    <i class="bi bi-people fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Jumlah Tempat Ibadah</h6>
                        <h2 class="mb-0">
                            {{ $stats['jumlah_ibadah'] > 0 ? $stats['jumlah_ibadah'] . ' lokasi' : 'Belum ada' }}
                        </h2>
                    </div>
                    <i class="bi bi-house-door fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Jumlah Rumah Sakit</h6>
                        <h2 class="mb-0">
                            {{ $stats['jumlah_sehat'] > 0 ? $stats['jumlah_sehat'] . ' lokasi' : 'Belum ada' }}
                        </h2>
                    </div>
                    <i class="bi bi-heart-pulse fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Lokasi Pasar</h6>
                        <h2 class="mb-0">
                            {{ $stats['jumlah_pasar'] > 0 ? $stats['jumlah_pasar'] . ' lokasi' : 'Belum ada' }}
                        </h2>
                    </div>
                    <i class="bi bi-shop fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Jumlah Lokasi Plesir</h6>
                        <h2 class="mb-0">
                            {{ $stats['jumlah_plesir'] > 0 ? $stats['jumlah_plesir'] . ' lokasi' : 'Belum ada' }}
                        </h2>
                    </div>
                    <i class="bi bi-image fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Jumlah DUMAS-YU</h6>
                        <h2 class="mb-0">
                            {{ $stats['jumlah_dumas'] > 0 ? $stats['jumlah_dumas'] . ' aduan' : 'Belum ada' }}
                        </h2>
                    </div>
                    <i class="bi bi-exclamation-circle fs-1"></i>
                </div>
            </div>
        </div>
    </div>


</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h6>Aktivitas Terkini</h6>
            </div>
            <div class="card-body">
                @if($aktivitas->isEmpty())
                <p class="text-muted">Belum ada aktivitas</p>
                @else
                <ul class="list-group list-group-flush">
                    @foreach($aktivitas as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $item->keterangan }}
                        <span class="text-muted small">{{ $item->created_at->diffForHumans() }}</span>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6>Modul Aplikasi</h6>
                <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6">
                        <a href="{{ route('admin.ibadah.index') }}" class="text-decoration-none">
                            <div class="p-3 border rounded text-center hover-shadow">
                                <i class="bi bi-house-door fs-3 text-primary"></i>
                                <p class="mb-0 mt-2 text-primary">Ibadah-Yu</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.sehat.index') }}" class="text-decoration-none">
                            <div class="p-3 border rounded text-center hover-shadow">
                                <i class="bi bi-heart-pulse fs-3 text-success"></i>
                                <p class="mb-0 mt-2 text-primary">Sehat-Yu</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-6">
                        <a href="{{ route('admin.pasar.index') }}" class="text-decoration-none">
                            <div class="p-3 border rounded text-center hover-shadow">
                                <i class="bi bi-cart fs-3 text-warning"></i>
                                <p class="mb-0 mt-2 text-primary">Pasar-Yu</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-6">
                        <a href="#" class="text-decoration-none">
                            <div class="p-3 border rounded text-center hover-shadow">
                                <i class="bi bi-file-earmark-text fs-3 text-info"></i>
                                <p class="mb-0 mt-2">Adminduk-Yu</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Sidebar toggle untuk mobile
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('d-none');
    });
</script>
@endsection
@endsection