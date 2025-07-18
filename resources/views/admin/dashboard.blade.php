@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="row">
    @php
        $cards = [
            ['title' => 'Total Pengguna', 'value' => $stats['total_users'], 'color' => 'primary', 'icon' => 'bi-people'],
            ['title' => 'Jumlah Tempat Ibadah', 'value' => $stats['jumlah_ibadah'] > 0 ? $stats['jumlah_ibadah'] . ' lokasi' : 'Belum ada', 'color' => 'success', 'icon' => 'fas fa-mosque'],
            ['title' => 'Jumlah Rumah Sakit', 'value' => $stats['jumlah_sehat'] > 0 ? $stats['jumlah_sehat'] . ' lokasi' : 'Belum ada', 'color' => 'info', 'icon' => 'bi-heart-pulse'],
            ['title' => 'Jumlah Lokasi Pasar', 'value' => $stats['jumlah_pasar'] > 0 ? $stats['jumlah_pasar'] . ' lokasi' : 'Belum ada', 'color' => 'warning', 'icon' => 'bi-shop'],
            ['title' => 'Jumlah Lokasi Plesir', 'value' => $stats['jumlah_plesir'] > 0 ? $stats['jumlah_plesir'] . ' lokasi' : 'Belum ada', 'color' => 'info', 'icon' => 'bi-geo-alt-fill'],
            ['title' => 'Jumlah Aduan Masyarakat', 'value' => $stats['jumlah_dumas'] > 0 ? $stats['jumlah_dumas'] . ' aduan' : 'Belum ada', 'color' => 'danger', 'icon' => 'bi-exclamation-circle'],
            ['title' => 'Jumlah Aduan Sekolah', 'value' => $stats['jumlah_sekolah'] > 0 ? $stats['jumlah_sekolah'] . ' aduan' : 'Belum ada', 'color' => 'warning text-dark', 'icon' => 'bi-book'],
        ];
    @endphp

    {{-- Kelola Slider --}}
    <div class="col-md-3 mb-4">
        <a href="{{ route('admin.slider.index') }}" class="text-decoration-none">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center" style="min-height: 120px;">
                    <i class="bi bi-images fs-1 text-primary mb-2"></i>
                    <h6 class="text-primary">Kelola Slider</h6>
                </div>
            </div>
        </a>
    </div>

    {{-- Kartu Statistik --}}
    @foreach ($cards as $card)
        <div class="col-md-3 mb-4">
            <div class="card bg-{{ $card['color'] }} text-white h-100">
                <div class="card-body d-flex justify-content-between align-items-center" style="min-height: 120px;">
                    <div>
                        <h6 class="card-title">{{ $card['title'] }}</h6>
                        <h2 class="mb-0">{{ $card['value'] }}</h2>
                    </div>
                    <i class="{{ $card['icon'] }} fs-1"></i>
                </div>
            </div>
        </div>
    @endforeach
</div>


{{-- Aktivitas & Modul Aplikasi --}}
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="mb-0">Aktivitas Terkini</h6>
            </div>
            <div class="card-body overflow-auto" style="max-height: 400px;">
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
        <div class="card h-100 d-flex flex-column">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Modul Aplikasi</h6>
                <a href="{{ route('admin.fitur.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body d-flex flex-column justify-content-center">
                <div class="row g-3">
                    <div class="col-6">
                        <a href="{{ route('admin.ibadah.index') }}" class="text-decoration-none">
                            <div class="p-3 border rounded text-center hover-shadow d-flex flex-column align-items-center justify-content-center" style="height: 120px;">
                                <i class="fas fa-mosque fs-3 text-primary"></i>
                                <p class="mb-0 mt-2 fw-semibold text-primary">Ibadah-Yu</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.sehat.index') }}" class="text-decoration-none">
                            <div class="p-3 border rounded text-center hover-shadow d-flex flex-column align-items-center justify-content-center" style="height: 120px;">
                                <i class="bi bi-heart-pulse fs-3"></i>
                                <p class="mb-0 mt-2 fw-semibold text-primary">Sehat-Yu</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.pasar.index') }}" class="text-decoration-none">
                            <div class="p-3 border rounded text-center hover-shadow d-flex flex-column align-items-center justify-content-center" style="height: 120px;">
                                <i class="bi bi-cart fs-3"></i>
                                <p class="mb-0 mt-2 fw-semibold text-primary">Pasar-Yu</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.adminduk.index') }}" class="text-decoration-none">
                            <div class="p-3 border rounded text-center hover-shadow d-flex flex-column align-items-center justify-content-center" style="height: 120px;">
                                <i class="bi bi-card-list fs-3"></i>
                                <p class="mb-0 mt-2 fw-semibold text-primary">Adminduk-Yu</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-6">
                        <a href="{{ route('admin.plesir.index') }}" class="text-decoration-none">
                            <div class="p-3 border rounded text-center hover-shadow d-flex flex-column align-items-center justify-content-center" style="height: 120px;">
                                <i class="bi bi-geo-alt-fill fs-3"></i>
                                <p class="mb-0 mt-2 fw-semibold text-primary">Plesir-Yu</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-6">
                        <a href="{{ route('admin.dumas.index') }}" class="text-decoration-none">
                            <div class="p-3 border rounded text-center hover-shadow d-flex flex-column align-items-center justify-content-center" style="height: 120px;">
                                <i class="bi bi-exclamation-circle fs-3"></i>
                                <p class="mb-0 mt-2 fw-semibold text-primary">Dumas-Yu</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.getElementById('sidebarToggle').addEventListener('click', function () {
        document.querySelector('.sidebar').classList.toggle('d-none');
    });
</script>
@endsection
