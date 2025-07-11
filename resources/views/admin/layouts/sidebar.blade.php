<div class="sidebar d-flex flex-column flex-shrink-0 p-3 text-white bg-dark min-vh-100" style="width: 280px;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <span class="fs-3">Wong Reang Admin</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">

        {{-- Dashboard --}}
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link text-white {{ request()->is('admin/dashboard') ? 'active bg-primary' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>

        {{-- === Laporan dan Kedaruratan === --}}
        <li class="nav-item mt-3 mb-1">
            <h6 class="text-uppercase text-white ps-2">Laporan dan Kedaruratan</h6>
        </li>

        {{-- Dumas-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/dumas*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#dumasSubmenu" role="button" aria-expanded="{{ request()->is('admin/dumas*') ? 'true' : 'false' }}">
                <span><i class="bi bi-exclamation-circle me-2"></i></i> Dumas-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ request()->is('admin/dumas*') ? 'show' : '' }}" id="dumasSubmenu">
                <ul class="list-unstyled ms-3">
                    <li><a href="{{ route('admin.dumas.index') }}" class="nav-link text-white {{ request()->is('admin/dumas') ? 'active' : '' }}"><i class="bi bi-list me-2"></i> Daftar Pengaduan</a></li>
                </ul>
            </div>
        </li>

        {{-- Info-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/info*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#infoSubmenu" role="button" aria-expanded="{{ request()->is('admin/info*') ? 'true' : 'false' }}">
                <span><i class="bi bi-info-circle"></i> Info-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
        </li>

        {{-- === KATEGORI: Kesehatan dan Pendidikan === --}}
        <li class="nav-item mt-3 mb-1">
            <h6 class="text-uppercase text-white ps-2">Kesehatan dan Pendidikan</h6>
        </li>

        {{-- Sehat-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/sehat*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#sehatSubmenu" role="button" aria-expanded="{{ request()->is('admin/sehat*') ? 'true' : 'false' }}">
                <span><i class="bi bi-heart-pulse me-2"></i> Sehat-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ request()->is('admin/sehat*') ? 'show' : '' }}" id="sehatSubmenu">
                <ul class="list-unstyled ms-3">
                    <li><a href="{{ route('admin.sehat.index') }}" class="nav-link text-white {{ request()->is('admin/sehat') ? 'active' : '' }}"><i class="bi bi-list me-2"></i> Daftar Tempat</a></li>
                </ul>
            </div>
        </li>

        {{-- Sekolah-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/sekolah*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#sekolahSubmenu" role="button" aria-expanded="{{ request()->is('admin/sekolah*') ? 'true' : 'false' }}">
                <span><i class="bi bi-heart-pulse me-2"></i> Sekolah-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ request()->is('admin/sekolah*') ? 'show' : '' }}" id="sekolahSubmenu">
                <ul class="list-unstyled ms-3">
                    <li><a href="{{ route('admin.sekolah.index') }}" class="nav-link text-white {{ request()->is('admin/sekolah') ? 'active' : '' }}"><i class="bi bi-list me-2"></i> Aduan Sekolah</a></li>
                </ul>
            </div>
        </li>

        {{-- === KATEGORI: Sosial dan Ekonomi === --}}
        <li class="nav-item mt-3 mb-1">
            <h6 class="text-uppercase text-white ps-2">Sosial dan Ekonomi</h6>
        </li>

        {{-- Pajak-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white" href="#"><i class="bi bi-receipt me-2"></i> Pajak-Yu</a>
        </li>

        {{-- Pasar-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/pasar*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#pasarSubmenu" role="button" aria-expanded="{{ request()->is('admin/pasar*') ? 'true' : 'false' }}">
                <span><i class="bi bi-shop me-2"></i> Pasar-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ request()->is('admin/pasar*') ? 'show' : '' }}" id="pasarSubmenu">
                <ul class="list-unstyled ms-3">
                    <li><a href="{{ route('admin.pasar.index') }}" class="nav-link text-white {{ request()->is('admin/pasar') ? 'active' : '' }}"><i class="bi bi-list me-2"></i> Daftar Pasar</a></li>
                </ul>
            </div>
        </li>

        {{-- Kerja-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white" href="#"><i class="bi bi-briefcase me-2"></i> Kerja-Yu</a>
        </li>

        {{-- === KATEGORI: Pariwisata dan Keagamaan === --}}
        <li class="nav-item mt-3 mb-1">
            <h6 class="text-uppercase text-white ps-2">Pariwisata dan Keagamaan</h6>
        </li>

        {{-- Plesir-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/plesir*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#plesirSubmenu" role="button" aria-expanded="{{ request()->is('admin/plesir*') ? 'true' : 'false' }}">
                <span><i class="bi bi-geo-alt-fill me-2"></i> Plesir-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ request()->is('admin/plesir*') ? 'show' : '' }}" id="plesirSubmenu">
                <ul class="list-unstyled ms-3">
                    <li><a href="{{ route('admin.plesir.index') }}" class="nav-link text-white {{ request()->is('admin/plesir') ? 'active' : '' }}"><i class="bi bi-list me-2"></i> Daftar Tempat</a></li>
                </ul>
            </div>
        </li>

        {{-- Ibadah-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/ibadah*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#ibadahSubmenu" role="button" aria-expanded="{{ request()->is('admin/ibadah*') ? 'true' : 'false' }}">
                <span><i class="fas fa-mosque me-2"></i> Ibadah-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ request()->is('admin/ibadah*') ? 'show' : '' }}" id="ibadahSubmenu">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ms-3">
                    <li>
                        <a href="{{ route('admin.ibadah.index') }}" class="nav-link text-white {{ request()->is('admin/ibadah') ? 'active' : '' }}">
                            <i class="bi bi-list me-2"></i> Dashboard
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- === KATEGORI: Layanan Publik Lainnya === --}}
        <li class="nav-item mt-3 mb-1">
            <h6 class="text-uppercase text-white-50 ps-2">Layanan Publik Lainnya</h6>
        </li>

        {{-- Adminduk-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white" href="#"><i class="bi bi-card-list me-2"></i> Adminduk-Yu</a>
        </li>

        {{-- Renbang-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white" href="#"><i class="bi bi-diagram-3 me-2"></i> Renbang-Yu</a>
        </li>

        {{-- Izin-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white" href="#"><i class="bi bi-shield-check me-2"></i> Izin-Yu</a>
        </li>

        {{-- Wifi-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white" href="#"><i class="bi bi-wifi me-2"></i> Wifi-Yu</a>
        </li>
    </ul>

    {{-- Dropdown Profil --}}
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
            <strong>Admin</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
            <li>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item ms-3">Logout</button>
                </form>
            </li>
        </ul>
    </div>
</div>