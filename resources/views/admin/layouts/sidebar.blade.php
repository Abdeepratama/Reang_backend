<div class="sidebar d-flex flex-column flex-shrink-0 p-3 text-white bg-dark min-vh-100" style="width: 280px;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <span class="fs-4">Wong Reang Admin</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link text-white {{ request()->is('admin/dashboard') ? 'active bg-primary' : '' }}">
                Dashboard
            </a>
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
                            <i class="bi bi-list me-2"></i> Daftar Tempat
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- Info-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/info*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#ibadahSubmenu" role="button" aria-expanded="{{ request()->is('admin/ibadah*') ? 'true' : 'false' }}">
                <span><i class="fas fa-mosque me-2"></i> Info-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
        </li>

        {{-- Dumas-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/dumes*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#dumesSubmenu" role="button" aria-expanded="{{ request()->is('admin/dumes*') ? 'true' : 'false' }}">
                <span><i class="fas fa-comment-dots me-2"></i> Dumas-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ request()->is('admin/dumes*') ? 'show' : '' }}" id="dumesSubmenu">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ms-3">
                    <li>
                        <a href="{{ route('admin.pengaduan.index') }}" class="nav-link text-white {{ request()->is('admin/dumes') ? 'active' : '' }}">
                            <i class="bi bi-inbox me-2"></i> Daftar Pengaduan
                        </a>
                    </li>
                </ul>
            </div>
        </li>


        {{-- Sekolah-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/sekolah*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#ibadahSubmenu" role="button" aria-expanded="{{ request()->is('admin/ibadah*') ? 'true' : 'false' }}">
                <span><i class="fas fa-mosque me-2"></i> Sekolah-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
        </li>


        {{-- Sehat-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/sehat*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#sehatSubmenu" role="button" aria-expanded="{{ request()->is('admin/sehat*') ? 'true' : 'false' }}">
                <span><i class="fas fa-mosque me-2"></i> Sehat-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ request()->is('admin/sehat*') ? 'show' : '' }}" id="sehatSubmenu">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ms-3">
                    <li>
                        <a href="{{ route('admin.sehat.index') }}" class="nav-link text-white {{ request()->is('admin/sehat') ? 'active' : '' }}">
                            <i class="bi bi-list me-2"></i> Daftar Tempat
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- Pajak-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/pajak*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#ibadahSubmenu" role="button" aria-expanded="{{ request()->is('admin/ibadah*') ? 'true' : 'false' }}">
                <span><i class="fas fa-mosque me-2"></i> Pajak-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
        </li>

        {{-- Plesir-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/plesir*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#plesirSubmenu" role="button" aria-expanded="{{ request()->is('admin/plesir*') ? 'true' : 'false' }}">
                <span><i class="fas fa-map-marked-alt me-2"></i> Plesir-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ request()->is('admin/plesir*') ? 'show' : '' }}" id="plesirSubmenu">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ms-3">
                    <li>
                        <a href="{{ route('admin.plesir.index') }}" class="nav-link text-white {{ request()->is('admin/plesir') ? 'active' : '' }}">
                            <i class="bi bi-list me-2"></i> Daftar Tempat
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- Pasar-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/pasar*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#pasarSubmenu" role="button" aria-expanded="{{ request()->is('admin/pasar*') ? 'true' : 'false' }}">
                <span><i class="fas fa-store me-2"></i> Pasar-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ request()->is('admin/pasar*') ? 'show' : '' }}" id="pasarSubmenu">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ms-3">
                    <li>
                        <a href="{{ route('admin.pasar.index') }}" class="nav-link text-white {{ request()->is('admin/pasar') ? 'active' : '' }}">
                            <i class="bi bi-list me-2"></i> Daftar Tempat
                        </a>
                    </li>
                </ul>
            </div>
        </li>


        {{-- Adminduk-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/adminduk*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#ibadahSubmenu" role="button" aria-expanded="{{ request()->is('admin/ibadah*') ? 'true' : 'false' }}">
                <span><i class="fas fa-mosque me-2"></i>Adminduk-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
        </li>

        {{-- Kerja-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/kerja*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#ibadahSubmenu" role="button" aria-expanded="{{ request()->is('admin/ibadah*') ? 'true' : 'false' }}">
                <span><i class="fas fa-mosque me-2"></i>Kerja-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
        </li>

        {{-- Renbang-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/renbang*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#ibadahSubmenu" role="button" aria-expanded="{{ request()->is('admin/ibadah*') ? 'true' : 'false' }}">
                <span><i class="fas fa-mosque me-2"></i>Renbang-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
        </li>

        {{-- Izin-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/izin*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#ibadahSubmenu" role="button" aria-expanded="{{ request()->is('admin/ibadah*') ? 'true' : 'false' }}">
                <span><i class="fas fa-mosque me-2"></i> Izin-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
        </li>

        {{-- Wifi-Yu --}}
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/wifi*') ? 'bg-primary' : '' }}" data-bs-toggle="collapse" href="#ibadahSubmenu" role="button" aria-expanded="{{ request()->is('admin/ibadah*') ? 'true' : 'false' }}">
                <span><i class="fas fa-mosque me-2"></i> Wifi-Yu</span>
                <i class="fas fa-chevron-down"></i>
            </a>
        </li>
    </ul>

    <hr>
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