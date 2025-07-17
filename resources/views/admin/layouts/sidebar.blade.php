<div class="sidebar d-flex flex-column flex-shrink-0 p-3 text-white bg-dark min-vh-100" style="width: 280px;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <span class="fs-3">Wong Reang Admin</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">

        {{-- Dashboard --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/dashboard') || request()->is('admin/slider*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#dashboardSubmenu" role="button" aria-expanded="{{ request()->is('admin/slider*') ? 'true' : 'false' }}">
                <span><i class="bi bi-speedometer2 me-2"></i> Dashboard</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ request()->is('admin/slider*') ? 'show' : '' }}" id="dashboardSubmenu">
                <ul class="list-unstyled ms-3">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="nav-link text-white {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                            <i class="bi bi-house me-2"></i> Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.slider.index') }}" class="nav-link text-white {{ request()->is('admin/slider*') ? 'active' : '' }}">
                            <i class="bi bi-images me-2"></i> Slider
                        </a>
                    </li>
                </ul>
            </div>
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
                <span><i class="bi bi-info-circle me-2"></i> Info-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ request()->is('admin/info*') ? 'show' : '' }}" id="infoSubmenu">
                <ul class="list-unstyled ms-3">
                    <li><a href="{{ route('admin.info.index') }}" class="nav-link text-white {{ request()->is('admin/info') ? 'active' : '' }}"><i class="bi bi-list me-2"></i> Dashboard info</a></li>
                </ul>
            </div>
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
                    <li><a href="{{ route('admin.sehat.index') }}" class="nav-link text-white {{ request()->is('admin/sehat') ? 'active' : '' }}"><i class="bi bi-list me-2"></i> Dashboard Kesehatan</a></li>
                </ul>
            </div>
        </li>

        {{-- Sekolah-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/sekolah*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#sekolahSubmenu" role="button" aria-expanded="{{ request()->is('admin/sekolah*') ? 'true' : 'false' }}">
                <span><i class="bi bi-book me-2"></i> Sekolah-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ request()->is('admin/sekolah*') ? 'show' : '' }}" id="sekolahSubmenu">
                <ul class="list-unstyled ms-3">
                    <li><a href="{{ route('admin.sekolah.index') }}" class="nav-link text-white {{ request()->is('admin/sekolah') ? 'active' : '' }}"><i class="bi bi-list me-2"></i>Dashboard Pengaduan</a></li>
                </ul>
            </div>
        </li>

        {{-- === KATEGORI: Sosial dan Ekonomi === --}}
        <li class="nav-item mt-3 mb-1">
            <h6 class="text-uppercase text-white ps-2">Sosial dan Ekonomi</h6>
        </li>

        {{-- Pajak-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/pajak*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#pajakSubmenu" role="button" aria-expanded="{{ request()->is('admin/pajak*') ? 'true' : 'false' }}">
                <span><i class="bi bi-receipt me-2"></i> Pajak-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ request()->is('admin/pajak*') ? 'show' : '' }}" id="pajakSubmenu">
                <ul class="list-unstyled ms-3">
                    <li><a href="{{ route('admin.pajak.index') }}" class="nav-link text-white {{ request()->is('admin/pajak') ? 'active' : '' }}"><i class="bi bi-list me-2"></i>Dashboard Pajak</a></li>
                </ul>
            </div>
        </li>

        {{-- Pasar-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/pasar*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#pasarSubmenu" role="button" aria-expanded="{{ request()->is('admin/pasar*') ? 'true' : 'false' }}">
                <span><i class="bi bi-shop me-2"></i> Pasar-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ request()->is('admin/pasar*') ? 'show' : '' }}" id="pasarSubmenu">
                <ul class="list-unstyled ms-3">
                    <li><a href="{{ route('admin.pasar.index') }}" class="nav-link text-white {{ request()->is('admin/pasar') ? 'active' : '' }}"><i class="bi bi-list me-2"></i> Dashboard Pasar</a></li>
                </ul>
            </div>
        </li>

        {{-- Kerja-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/kerja*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#kerjaSubmenu" role="button" aria-expanded="{{ request()->is('admin/kerja*') ? 'true' : 'false' }}">
                <span><i class="bi bi-briefcase me-2"></i> Kerja-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ request()->is('admin/kerja*') ? 'show' : '' }}" id="kerjaSubmenu">
                <ul class="list-unstyled ms-3">
                    <li><a href="{{ route('admin.kerja.index') }}" class="nav-link text-white {{ request()->is('admin/kerja') ? 'active' : '' }}"><i class="bi bi-list me-2"></i> Dashboard Kerja</a></li>
                </ul>
            </div>
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
                    <li><a href="{{ route('admin.plesir.index') }}" class="nav-link text-white {{ request()->is('admin/plesir') ? 'active' : '' }}"><i class="bi bi-list me-2"></i> Dashboard Plesir</a></li>
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
                <ul class="list-unstyled ms-3">
                    <li><a href="{{ route('admin.ibadah.index') }}" class="nav-link text-white {{ request()->is('admin/ibadah') ? 'active' : '' }}"><i class="bi bi-list me-2"></i> Dashboard Ibadah</a></li>
                </ul>
            </div>
        </li>

        {{-- === KATEGORI: Layanan Publik Lainnya === --}}
        <li class="nav-item mt-3 mb-1">
            <h6 class="text-uppercase text-white ps-2">Layanan Publik Lainnya</h6>
        </li>

        {{-- Adminduk-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/adminduk*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#admindukSubmenu" role="button" aria-expanded="{{ request()->is('admin/adminduk*') ? 'true' : 'false' }}">
                <span><i class="bi bi-card-list me-2"></i> Adminduk-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ request()->is('admin/adminduk*') ? 'show' : '' }}" id="admindukSubmenu">
                <ul class="list-unstyled ms-3">
                    <li><a href="{{ route('admin.adminduk.index') }}" class="nav-link text-white {{ request()->is('admin/adminduk') ? 'active' : '' }}"><i class="bi bi-list me-2"></i> Dashboard adminduk</a></li>
                </ul>
            </div>
        </li>

        {{-- Renbang-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/renbang*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#renbangSubmenu" role="button" aria-expanded="{{ request()->is('admin/renbang*') ? 'true' : 'false' }}">
                <span><i class="bi bi-building me-2"></i> Renbang-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ request()->is('admin/renbang*') ? 'show' : '' }}" id="renbangSubmenu">
                <ul class="list-unstyled ms-3">
                    <li><a href="{{ route('admin.renbang.index') }}" class="nav-link text-white {{ request()->is('admin/renbang') ? 'active' : '' }}"><i class="bi bi-list me-2"></i> Dashboard Renbang</a></li>
                </ul>
            </div>
        </li>

        {{-- Izin-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/izin*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#izinSubmenu" role="button" aria-expanded="{{ request()->is('admin/izin*') ? 'true' : 'false' }}">
                <span><i class="bi bi-shield-check me-2"></i> Izin-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ request()->is('admin/izin*') ? 'show' : '' }}" id="izinSubmenu">
                <ul class="list-unstyled ms-3">
                    <li><a href="{{ route('admin.izin.index') }}" class="nav-link text-white {{ request()->is('admin/izin') ? 'active' : '' }}"><i class="bi bi-list me-2"></i> Dashboard Izin</a></li>
                </ul>
            </div>
        </li>

        {{-- Wifi-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/wifi*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#wifiSubmenu" role="button" aria-expanded="{{ request()->is('admin/wifi*') ? 'true' : 'false' }}">
                <span><i class="bi bi-wifi me-2"></i> Wifi-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ request()->is('admin/wifi*') ? 'show' : '' }}" id="wifiSubmenu">
                <ul class="list-unstyled ms-3">
                    <li><a href="{{ route('admin.wifi.index') }}" class="nav-link text-white {{ request()->is('admin/wifi') ? 'active' : '' }}"><i class="bi bi-list me-2"></i> Dashboard Wifi</a></li>
                </ul>
            </div>
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