<header class="bg-light border-bottom">
    <div class="container-fluid d-flex justify-content-between py-3">
        <div class="border-bottom py-3 px-4 bg-light">
            <button class="btn btn-outline-secondary me-3 d-lg-none" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <h5 class="mb-0">@yield('title')</h5>
        </div>

        <ul class="navbar-nav flex-row align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link position-relative text-dark" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell fs-4"></i>
                    @if($jumlahNotifikasi > 0)
                        <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger">
                            {{ $jumlahNotifikasi }}
                            <span class="visually-hidden">unread notifications</span>
                        </span>
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li><h6 class="dropdown-header">Notifikasi</h6></li>
                    @forelse($notifikasiAktivitas as $notif)
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.notifikasi.baca.satu', $notif->id) }}">
                                {{ $notif->keterangan }}<br>
                                <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                            </a>
                        </li>
                    @empty
                        <li><span class="dropdown-item text-muted">Tidak ada notifikasi</span></li>
                    @endforelse
                </ul>
            </li>
        </ul>
    </div>
</header>
