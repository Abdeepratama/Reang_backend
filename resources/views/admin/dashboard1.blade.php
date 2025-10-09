@extends('admin.partials.app')

@section('content')

@php
$cards = [];

// Kalau superadmin tampilkan semua
if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'superadmin') {
$cards = [
['title' => 'Total Pengguna', 'value' => $stats['total_users'], 'color' => 'primary', 'icon' => 'fe fe-32 fe-users'],
['title' => 'Jumlah Tempat Ibadah', 'value' => $stats['jumlah_lokasi_ibadah'] > 0 ? $stats['jumlah_lokasi_ibadah'] : 'Belum ada', 'color' => 'success', 'icon' => 'fe fe-32 fas fe-home'],
['title' => 'Jumlah Rumah Sakit', 'value' => $stats['jumlah_sehat'] > 0 ? $stats['jumlah_sehat'] : 'Belum ada', 'color' => 'info', 'icon' => 'fe fe-32 fe-briefcase'],
['title' => 'Jumlah Lokasi Pasar', 'value' => $stats['jumlah_lokasi_pasar'] > 0 ? $stats['jumlah_lokasi_pasar'] : 'Belum ada', 'color' => 'warning', 'icon' => 'fe fe-32 fe-shopping-cart'],
['title' => 'Jumlah Lokasi Plesir', 'value' => $stats['jumlah_lokasi_plesir'] > 0 ? $stats['jumlah_lokasi_plesir'] : 'Belum ada', 'color' => 'info', 'icon' => 'fe fe-32 fe-map-pin'],
['title' => 'Jumlah Aduan Masyarakat', 'value' => $stats['jumlah_dumas'] > 0 ? $stats['jumlah_dumas'] : 'Belum ada', 'color' => 'danger', 'icon' => 'fe fe-32 fe-alert-circle'],
];
}

// Kalau admin dinas kesehatan → hanya rumah sakit
elseif (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'admindinas' && Auth::guard('admin')->user()->dinas === 'kesehatan') {
$cards = [
['title' => 'Jumlah Rumah Sakit', 'value' => $stats['jumlah_sehat'] > 0 ? $stats['jumlah_sehat'] : 'Belum ada', 'color' => 'info', 'icon' => 'fe fe-32 fe-briefcase'],
['title' => 'Jumlah Info Kesehatan', 'value' => $stats['jumlah_info_kesehatan'] > 0 ? $stats['jumlah_info_kesehatan'] : 'Belum ada', 'color' => 'info', 'icon' => 'fe fe-32 fe-briefcase'],
['title' => 'Jumlah Lokasi Olahraga', 'value' => $stats['jumlah_lokasi_olahraga'] > 0 ? $stats['jumlah_lokasi_olahraga'] : 'Belum ada', 'color' => 'info', 'icon' => 'fe fe-32 fe-briefcase'],
];
}

elseif (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'admindinas' && Auth::guard('admin')->user()->dinas === 'pendidikan') {
$cards = [
['title' => 'Jumlah Sekolah', 'value' => $stats['jumlah_sekolah'] > 0 ? $stats['jumlah_sekolah'] : 'Belum ada', 'color' => 'info', 'icon' => 'fe fe-32 fe-briefcase'],
['title' => 'Jumlah Berita Sekolah', 'value' => $stats['jumlah_info_sekolah'] > 0 ? $stats['jumlah_info_sekolah'] : 'Belum ada', 'color' => 'info', 'icon' => 'fe fe-32 fe-briefcase'],
];
}

elseif (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'admindinas' && Auth::guard('admin')->user()->dinas === 'perpajakan') {
$cards = [
['title' => 'Jumlah Info Pajak', 'value' => $stats['jumlah_info_pajak'] > 0 ? $stats['jumlah_info_pajak'] : 'Belum ada', 'color' => 'info', 'icon' => 'fe fe-32 fe-briefcase'],
];
}

elseif (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'admindinas' && Auth::guard('admin')->user()->dinas === 'perdagangan') {
$cards = [
['title' => 'Jumlah Lokasi Pasar', 'value' => $stats['jumlah_lokasi_pasar'] > 0 ? $stats['jumlah_lokasi_pasar'] : 'Belum ada', 'color' => 'warning', 'icon' => 'fe fe-32 fe-shopping-cart'],
];
}

elseif (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'admindinas' && Auth::guard('admin')->user()->dinas === 'kerja') {
$cards = [
['title' => 'Jumlah Info Pekerjaan', 'value' => $stats['jumlah_info_kerja'] > 0 ? $stats['jumlah_info_kerja'] : 'Belum ada', 'color' => 'warning', 'icon' => 'fe fe-32 fe-shopping-cart'],
];
}

elseif (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'admindinas' && Auth::guard('admin')->user()->dinas === 'pariwisata') {
$cards = [
['title' => 'Jumlah Info Plesir', 'value' => $stats['jumlah_info_plesir'] > 0 ? $stats['jumlah_info_plesir'] : 'Belum ada', 'color' => 'warning', 'icon' => 'fe fe-32 fe-shopping-cart'],
['title' => 'Jumlah Lokasi Plesir', 'value' => $stats['jumlah_lokasi_plesir'] > 0 ? $stats['jumlah_lokasi_plesir'] : 'Belum ada', 'color' => 'info', 'icon' => 'fe fe-32 fe-map-pin'],
];
}

elseif (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'admindinas' && Auth::guard('admin')->user()->dinas === 'keagamaan') {
$cards = [
['title' => 'Jumlah Info Keagamaan', 'value' => $stats['jumlah_info_keagamaan'] > 0 ? $stats['jumlah_info_keagamaan'] : 'Belum ada', 'color' => 'warning', 'icon' => 'fe fe-32 fe-shopping-cart'],
['title' => 'Jumlah tempat Ibadah', 'value' => $stats['jumlah_lokasi_ibadah'] > 0 ? $stats['jumlah_lokasi_ibadah'] : 'Belum ada', 'color' => 'info', 'icon' => 'fe fe-32 fe-map-pin'],
];
}

elseif (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'admindinas' && Auth::guard('admin')->user()->dinas === 'kependudukan') {
$cards = [
['title' => 'Jumlah Info Kependudukan', 'value' => $stats['jumlah_info_kependudukan'] > 0 ? $stats['jumlah_info_kependudukan'] : 'Belum ada', 'color' => 'warning', 'icon' => 'fe fe-32 fe-shopping-cart'],
];
}

elseif (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'admindinas' && Auth::guard('admin')->user()->dinas === 'pembangunan') {
$cards = [
['title' => 'Jumlah Info Pembangunan', 'value' => $stats['jumlah_info_pembangunan'] > 0 ? $stats['jumlah_info_pembangunan'] : 'Belum ada', 'color' => 'warning', 'icon' => 'fe fe-32 fe-shopping-cart'],
];
}

elseif (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'admindinas' && Auth::guard('admin')->user()->dinas === 'perizinan') {
$cards = [
['title' => 'Jumlah Info Perizinan', 'value' => $stats['jumlah_info_perizinan'] > 0 ? $stats['jumlah_info_perizinan'] : 'Belum ada', 'color' => 'warning', 'icon' => 'fe fe-32 fe-shopping-cart'],
];
}
@endphp

<div class="container-fluid">

    <div class="row">
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow bg-primary text-white border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-3 text-center">
                            <span class="circle circle-sm bg-primary-light">
                                <i class="fe fe-16 fe-file text-white mb-0"></i>
                            </span>
                        </div>
                        <div class="col pr-0">
                            <p class="small text-muted mb-0">Jumlah Pengaduan</p>
                            <span class="h3 mb-0 text-white">{{ $stats['jumlah_dumas'] }}</span>
                            <span class="small text-muted"> aduan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Jumlah Puskesmas -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-3 text-center">
                            <span class="circle circle-sm bg-warning">
                                <i class="fe fe-16 fe-home text-white mb-0"></i>
                            </span>
                        </div>
                        <div class="col pr-0">
                            <p class="small text-muted mb-0">Jumlah Puskesmas</p>
                            <span class="h3 mb-0 text-black">{{ $stats['jumlah_puskesmas'] }}</span>
                            <span class="small text-muted"> puskesmas</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jumlah Rumah Sakit -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-3 text-center">
                            <span class="circle circle-sm bg-primary">
                                <i class="fe fe-16 fe-plus-square text-white mb-0"></i>
                            </span>
                        </div>
                        <div class="col">
                            <p class="small text-muted mb-0">Jumlah Rumah Sakit</p>
                            <span class="h3 mb-0 text-black">{{ $stats['jumlah_sehat'] }}</span>
                            <span class="small text-muted"> rumah sakit</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jumlah Dokter -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-3 text-center">
                            <span class="circle circle-sm bg-success">
                                <i class="fe fe-16 fe-user text-white mb-0"></i>
                            </span>
                        </div>
                        <div class="col">
                            <p class="small text-muted mb-0">Jumlah Dokter</p>
                            <span class="h3 mb-0 text-black">{{ $stats['jumlah_dokter'] }}</span>
                            <span class="small text-muted"> dokter</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <hr>

    <!-- =========================================================================================================================== -->


    <div class="row my-4">
        <!-- Jumlah Wifi -->
        @if (Auth::guard('admin')->user()->role === 'superadmin')
        <div class="col-md-4">
            <div class="card shadow mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <small class="text-muted mb-1">Jumlah Wifi</small>
                            <h3 class="card-title mb-0">15</h3>
                        </div>
                        <div class="col-4 text-right">
                            <span class="sparkline fe fe-32 fe-wifi"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Jumlah Tempat Ibadah -->
        @if (Auth::guard('admin')->user()->role === 'superadmin')
        <div class="col-md-4">
            <div class="card shadow mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <p class="small text-muted mb-0">Jumlah Tempat Ibadah</p>
                            <span class="h3 mb-0 text-black">{{ $stats['jumlah_lokasi_ibadah'] }}</span>
                            <span class="small text-muted">tempat ibadah</span>
                        </div>
                        <div class="col-4 text-right">
                            <span class="sparkline fe fe-32 fe-crosshair"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Jumlah Pasar -->
        @if (Auth::guard('admin')->user()->role === 'superadmin')
        <div class="col-md-4">
            <div class="card shadow mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <p class="small text-muted mb-0">Jumlah Pasar</p>
                            <span class="h3 mb-0 text-black">{{ $stats['jumlah_lokasi_pasar'] }}</span>
                            <span class="small text-muted">pasar</span>
                        </div>
                        <div class="col-4 text-right">
                            <span class="sparkline fe fe-32 fe-shopping-bag"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Jumlah Sekolah -->
        @if (Auth::guard('admin')->user()->role === 'superadmin')
        <div class="col-md-4">
            <div class="card shadow mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <p class="small text-muted mb-0">Jumlah Sekolah</p>
                            <span class="h3 mb-0 text-black">{{ $stats['jumlah_sekolah'] }}</span>
                            <span class="small text-muted">sekolah</span>
                        </div>
                        <div class="col-4 text-right">
                            <span class="sparkline fe fe-32 fe-book"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Jumlah Wisata -->
        @if (Auth::guard('admin')->user()->role === 'superadmin')
        <div class="col-md-4">
            <div class="card shadow mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <p class="small text-muted mb-0">Jumlah Wisata</p>
                            <span class="h3 mb-0 text-black">{{ $stats['jumlah_lokasi_plesir'] }}</span>
                            <span class="small text-muted">wisata</span>
                        </div>
                        <div class="col-4 text-right">
                            <span class="sparkline fe fe-32 fe-map"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if (Auth::guard('admin')->user()->role === 'superadmin')
        <div class="col-md-4">
            <div class="card shadow mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <p class="small text-muted mb-0">Jumlah Info Pekerjaan</p>
                            <span class="h3 mb-0 text-black">{{ $stats['jumlah_info_kerja'] }}</span>
                            <span class="small text-muted">info</span>
                        </div>
                        <div class="col-4 text-right">
                            <span class="sparkline fe fe-32 fe-briefcase"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>



    <!-- <div class="row my-4">
        @foreach ($cards as $val)
        <div class="col-md-3">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <small class="text-muted mb-1">{{ $val['title'] }}</small>
                            <h3 class="card-title mb-0">{{ $val['value'] }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <span class="sparkline {{ $val['icon'] }}"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endforeach
    </div> -->




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
                    @if(Auth::guard('admin')->user()->role === 'superadmin')
                    <a href="{{ route('admin.fitur.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    @endif
                </div>
                <div class="card-body d-flex flex-column justify-content-center">
                    <div class="row g-3">

                        @php
                        use Illuminate\Support\Facades\Auth;
                        $user = Auth::guard('admin')->user();
                        @endphp

                        @if($user->role === 'superadmin')
                        @php
                        $moduls = [
                        ['route' => 'admin.ibadah.info.index', 'icon' => 'fas fa-mosque', 'label' => 'Ibadah-Yu'],
                        ['route' => 'admin.sehat.info.index', 'icon' => 'bi bi-heart-pulse', 'label' => 'Sehat-Yu'],
                        ['route' => 'admin.pasar.tempat.index', 'icon' => 'bi bi-cart', 'label' => 'Pasar-Yu'],
                        ['route' => 'admin.adminduk.info.index', 'icon' => 'bi bi-card-list', 'label' => 'Adminduk-Yu'],
                        ['route' => 'admin.plesir.info.index', 'icon' => 'bi bi-geo-alt-fill', 'label' => 'Plesir-Yu'],
                        ['route' => 'admin.dumas.aduan.index', 'icon' => 'bi bi-exclamation-circle', 'label' => 'Dumas-Yu'],
                        ];
                        @endphp

                        @elseif($user->role === 'admindinas')
                        @php
                        $moduls = [];

                        switch ($user->id_instansi) {
                        case 2: // 🏥 Kesehatan
                        $moduls = [
                        ['route' => 'admin.sehat.tempat.index', 'icon' => 'bi bi-heart-pulse', 'label' => 'Lokasi Kesehatan'],
                        ['route' => 'admin.sehat.info.index', 'icon' => 'bi bi-info-circle', 'label' => 'Info Kesehatan'],
                        ['route' => 'admin.sehat.olahraga.index', 'icon' => 'bi bi-bicycle', 'label' => 'Lokasi Olahraga'],
                        ['route' => 'admin.dumas.aduan.index', 'icon' => 'bi bi-chat-text', 'label' => 'Aduan Masyarakat'],
                        ];
                        break;

                        case 3: // 🎓 Pendidikan
                        $moduls = [
                        ['route' => 'admin.sekolah.tempat.index', 'icon' => 'bi bi-mortarboard', 'label' => 'Lokasi Sekolah'],
                        ['route' => 'admin.sekolah.info.index', 'icon' => 'bi bi-journal-text', 'label' => 'Berita Sekolah'],
                        ];
                        break;

                        case 4: // 💰 Perpajakan
                        $moduls = [
                        ['route' => 'admin.pajak.info.index', 'icon' => 'bi bi-receipt', 'label' => 'Info Pajak'],
                        ];
                        break;

                        case 1: // 🛒 Perdagangan
                        $moduls = [
                        ['route' => 'admin.pasar.tempat.index', 'icon' => 'bi bi-cart', 'label' => 'Lokasi Pasar'],
                        ];
                        break;

                        case 7: // 👷 Tenaga Kerja
                        $moduls = [
                        ['route' => 'admin.kerja.info.index', 'icon' => 'bi bi-person-badge', 'label' => 'Info Kerja'],
                        ];
                        break;

                        case 4: // 🏖️ Pariwisata
                        $moduls = [
                        ['route' => 'admin.plesir.tempat.index', 'icon' => 'bi bi-geo-alt', 'label' => 'Lokasi Pariwisata'],
                        ['route' => 'admin.plesir.info.index', 'icon' => 'bi bi-newspaper', 'label' => 'Info Pariwisata'],
                        ];
                        break;

                        case 5: // 🕌 Keagamaan
                        $moduls = [
                        ['route' => 'admin.ibadah.tempat.index', 'icon' => 'fas fa-mosque', 'label' => 'Lokasi Tempat Ibadah'],
                        ['route' => 'admin.ibadah.info.index', 'icon' => 'bi bi-book', 'label' => 'Info Keagamaan'],
                        ];
                        break;

                        case 8: // 🧍 Kependudukan
                        $moduls = [
                        ['route' => 'admin.adminduk.info.index', 'icon' => 'bi bi-card-list', 'label' => 'Info Kependudukan'],
                        ];
                        break;

                        case 9: // 🏗️ Pembangunan
                        $moduls = [
                        ['route' => 'admin.renbang.info.index', 'icon' => 'bi bi-building', 'label' => 'Info Pembangunan'],
                        ];
                        break;

                        case 10: // 📜 Perizinan
                        $moduls = [
                        ['route' => 'admin.izin.info.index', 'icon' => 'bi bi-file-earmark-text', 'label' => 'Info Perizinan'],
                        ];
                        break;

                        default:
                        $moduls = [];
                        break;
                        }
                        @endphp
                        @else
                        @php $moduls = []; @endphp
                        @endif

                        {{-- Render modul --}}
                        <div class="row">
                            @foreach($moduls as $mod)
                            <div class="col-6">
                                <a href="{{ route($mod['route']) }}" class="text-decoration-none">
                                    <div class="p-3 border rounded text-center hover-shadow d-flex flex-column align-items-center justify-content-center" style="height: 120px;">
                                        <i class="{{ $mod['icon'] }} fs-3 text-primary"></i>
                                        <p class="mb-0 mt-2 fw-semibold text-primary">{{ $mod['label'] }}</p>
                                    </div>
                                </a>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    @endsection