@extends('admin.partials.app')

@section('content')

@php
        $cards = [
            ['title' => 'Total Pengguna', 'value' => $stats['total_users'], 'color' => 'primary', 'icon' => 'fe fe-32 fe-users'],
            ['title' => 'Jumlah Tempat Ibadah', 'value' => $stats['jumlah_ibadah'] > 0 ? $stats['jumlah_ibadah']  : 'Belum ada', 'color' => 'success', 'icon' => 'fe fe-32 fas fe-home'],
            ['title' => 'Jumlah Rumah Sakit', 'value' => $stats['jumlah_sehat'] > 0 ? $stats['jumlah_sehat']  : 'Belum ada', 'color' => 'info', 'icon' => ' fe fe-32 fe-briefcase'],
            ['title' => 'Jumlah Lokasi Pasar', 'value' => $stats['jumlah_pasar'] > 0 ? $stats['jumlah_pasar']  : 'Belum ada', 'color' => 'warning', 'icon' => ' fe fe-32 fe-shopping-cart'],
            ['title' => 'Jumlah Lokasi Plesir', 'value' => $stats['jumlah_plesir'] > 0 ? $stats['jumlah_plesir']  : 'Belum ada', 'color' => 'info', 'icon' => ' fe fe-32 fe-map-pin'],
            ['title' => 'Jumlah Aduan Masyarakat', 'value' => $stats['jumlah_dumas'] > 0 ? $stats['jumlah_dumas'] : 'Belum ada', 'color' => 'danger', 'icon' => 'fe fe-32  fe-alert-circle']
        ];
    @endphp


<div class="container-fluid">

    <div class="row my-4">
        @foreach ($cards as $val)
            <div class="col-md-4">
                <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                    <div class="col">
                        <small class="text-muted mb-1">{{ $val['title'] }}</small>
                        <h3 class="card-title mb-0">{{ $val['value'] }}</h3>
                        <!-- <p class="small text-muted mb-0"><span class="fe fe-arrow-down fe-12 text-danger"></span><span>-18.9% Last week</span></p> -->
                    </div>
                    <div class="col-4 text-right">
                        <span class="sparkline {{ $val['icon'] }}"></span>
                    </div>
                    </div> <!-- /. row -->
                </div> <!-- /. card-body -->
                </div> <!-- /. card -->
            </div> <!-- /. col -->
            
            @endforeach
        </div>

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
                        <a href="{{ route('admin.ibadah.info.index') }}" class="text-decoration-none">
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
                        <a href="{{ route('admin.adminduk.info.index') }}" class="text-decoration-none">
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

</div>
@endsection