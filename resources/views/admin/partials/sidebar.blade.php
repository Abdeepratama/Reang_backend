<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
        <div class="w-100 mb-4 d-flex justify-content-center">
            <a href="{{ route('admin.dashboard') }}" class="logo d-flex align-items-center">
                <img src="{{ asset('landing/img/logo_wongreang_apps.png') }}" alt="Logo Reang Apps" style="height: 40px;">
            </a>
        </div>


        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">Dashboard</span>
                </a>
            </li>
        </ul>
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Informasi & Pelaporan Publik</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item dropdown 
    {{ request()->routeIs('admin.dumas.*') || request()->routeIs('admin.info.*') ? 'show' : '' }}">

                <a href="#aduan"
                    data-toggle="collapse"
                    aria-expanded="{{ request()->routeIs('admin.dumas.*') || request()->routeIs('admin.info.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle nav-link 
        {{ request()->routeIs('admin.dumas.*') || request()->routeIs('admin.info.*') ? '' : 'collapsed' }}">

                    <i class="fe fe-twitch fe-16"></i>
                    <span class="ml-3 item-text">Aduan &amp; Kedaruratan</span>
                </a>

                <ul class="collapse list-unstyled pl-4 w-100 
        {{ request()->routeIs('admin.dumas.*') || request()->routeIs('admin.info.*') ? 'show' : '' }}" id="aduan">

                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ request()->routeIs('admin.dumas.*') ? 'active bg-primary text-white' : '' }}"
                            href="{{ route('admin.dumas.aduan.index') }}">
                            <span class="ml-1 item-text">Dumas-Yu</span>
                        </a>
                    </li>

                    @if (
                    Auth::guard('admin')->check() &&
                    (
                    Auth::guard('admin')->user()->role === 'superadmin' ||
                    (Auth::guard('admin')->user()->role === 'admindinas' && Auth::guard('admin')->user()->dinas != 'kesehatan' && Auth::guard('admin')->user()->dinas != 'pendidikan' && Auth::guard('admin')->user()->dinas != 'perpajakan'
                    && Auth::guard('admin')->user()->dinas != 'perdagangan')))
                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ request()->routeIs('admin.info.*') ? 'active bg-primary text-white' : '' }}"
                            href="{{ route('admin.info.index') }}">
                            <span class="ml-1 item-text">Info-Yu</span>
                        </a>
                    </li>
                    @endif

                </ul>
            </li>


            @if (Auth::guard('admin')->check() &&
            (Auth::guard('admin')->user()->role === 'superadmin' ||
            (Auth::guard('admin')->user()->role === 'admindinas' && Auth::guard('admin')->user()->dinas != 'perpajakan' && Auth::guard('admin')->user()->dinas != 'perdagangan')))
            <li class="nav-item dropdown 
    {{ request()->routeIs('admin.sehat.*') || request()->routeIs('admin.sekolah.*') ? 'show' : '' }}">

                <a href="#kesehatan"
                    data-toggle="collapse"
                    aria-expanded="{{ request()->routeIs('admin.sehat.*') || request()->routeIs('admin.sekolah.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle nav-link 
        {{ request()->routeIs('admin.sehat.*') || request()->routeIs('admin.sekolah.*') ? '' : 'collapsed' }}">

                    <i class="fe fe-briefcase fe-16"></i>
                    <span class="ml-3 item-text">Kesehatan & Pendidikan</span>
                </a>

                <ul class="collapse list-unstyled pl-4 w-100 
        {{ request()->routeIs('admin.sehat.*') || request()->routeIs('admin.sekolah.*') ? 'show' : '' }}"
                    id="kesehatan">

                    {{-- Submenu Sehat-Yu --}}
                    @if (Auth::guard('admin')->check() &&
                    (Auth::guard('admin')->user()->role === 'superadmin' ||
                    (Auth::guard('admin')->user()->role === 'admindinas' && Auth::guard('admin')->user()->dinas != 'pendidikan' && Auth::guard('admin')->user()->dinas != 'perpajakan')))
                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ request()->routeIs('admin.sehat.*') ? 'active bg-light' : '' }}"
                            href="#submenu-sehat" data-toggle="collapse"
                            aria-expanded="{{ request()->routeIs('admin.sehat.*') ? 'true' : 'false' }}">
                            <span class="ml-1 item-text">Sehat-Yu</span>
                        </a>

                        <ul class="collapse list-unstyled pl-4 {{ request()->routeIs('admin.sehat.*') ? 'show' : '' }}" id="submenu-sehat">
                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ request()->routeIs('admin.sehat.tempat.index') ? 'active bg-primary text-white' : '' }}"
                                    href="{{ route('admin.sehat.tempat.index') }}">
                                    Lokasi Rumah Sakit
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ request()->routeIs('admin.sehat.info.index') ? 'active bg-primary text-white' : '' }}"
                                    href="{{ route('admin.sehat.info.index') }}">
                                    Info Sehat
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ request()->routeIs('admin.sehat.olahraga.index') ? 'active bg-primary text-white' : '' }}"
                                    href="{{ route('admin.sehat.olahraga.index') }}">
                                    Lokasi Olahraga
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif

                    {{-- Submenu Sekolah-Yu --}}
                    @if (Auth::guard('admin')->check() &&
                    (Auth::guard('admin')->user()->role === 'superadmin' ||
                    (Auth::guard('admin')->user()->role === 'admindinas' && Auth::guard('admin')->user()->dinas != 'kesehatan' && Auth::guard('admin')->user()->dinas != 'perpajakan')))
                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ request()->routeIs('admin.sekolah.*') ? 'active bg-light' : '' }}"
                            href="#submenu-sekolah" data-toggle="collapse"
                            aria-expanded="{{ request()->routeIs('admin.sekolah.*') ? 'true' : 'false' }}">
                            <span class="ml-1 item-text">Sekolah-Yu</span>
                        </a>

                        <ul class="collapse list-unstyled pl-4 {{ request()->routeIs('admin.sekolah.*') ? 'show' : '' }}" id="submenu-sekolah">
                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ request()->routeIs('admin.sekolah.tempat.index') ? 'active bg-primary text-white' : '' }}"
                                    href="{{ route('admin.sekolah.tempat.index') }}">
                                    Lokasi Sekolah
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ request()->routeIs('admin.sekolah.info.index') ? 'active bg-primary text-white' : '' }}"
                                    href="{{ route('admin.sekolah.info.index') }}">
                                    Berita Pendidikan
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </li>

        </ul>
        @endif

        @if (Auth::guard('admin')->check() &&
        (Auth::guard('admin')->user()->role === 'superadmin' ||
        (Auth::guard('admin')->user()->role === 'admindinas' && Auth::guard('admin')->user()->dinas != 'kesehatan' && Auth::guard('admin')->user()->dinas != 'pendidikan')))
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Layanan Publik & Ekonomi</span>
        </p>

        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item dropdown {{ request()->routeIs('admin.pajak.*') || request()->routeIs('admin.pasar.*') || request()->routeIs('admin.kerja.*') ? 'show' : '' }}">

                <a href="#ekonomi"
                    data-toggle="collapse"
                    aria-expanded="{{ request()->routeIs('admin.pajak.*') || request()->routeIs('admin.pasar.*') || request()->routeIs('admin.kerja.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle nav-link {{ request()->routeIs('admin.pajak.*') || request()->routeIs('admin.pasar.*') || request()->routeIs('admin.kerja.*') ? '' : 'collapsed' }}">

                    <i class="fe fe-dollar-sign fe-16"></i>
                    <span class="ml-3 item-text">Sosial & Ekonomi</span>
                </a>

                <ul class="collapse list-unstyled pl-4 w-100  {{ request()->routeIs('admin.pajak.*') || request()->routeIs('admin.pasar.*') || request()->routeIs('admin.kerja.*') ? 'show' : '' }}"
                    id="ekonomi">

                    {{-- Pajak-Yu --}}
                    @if (Auth::guard('admin')->check() &&
                    (Auth::guard('admin')->user()->role === 'superadmin' ||
                    (Auth::guard('admin')->user()->role === 'admindinas' && Auth::guard('admin')->user()->dinas != 'perdagangan' )))
                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ request()->routeIs('admin.pajak.*') ? 'active bg-light' : '' }}"
                            href="#submenu-pajak" data-toggle="collapse"
                            aria-expanded="{{ request()->routeIs('admin.pajak.*') ? 'true' : 'false' }}">
                            <span class="ml-1 item-text">Pajak-Yu</span>
                        </a>

                        <ul class="collapse list-unstyled pl-4 {{ request()->routeIs('admin.pajak.*') ? 'show' : '' }}" id="submenu-pajak">
                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ request()->routeIs('admin.pajak.info.index') ? 'active bg-primary text-white' : '' }}"
                                    href="{{ route('admin.pajak.info.index') }}">
                                    Info Perpajakan
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif

                    {{-- Pasar-Yu --}}
                    @if (Auth::guard('admin')->check() &&
                    (Auth::guard('admin')->user()->role === 'superadmin' ||
                    (Auth::guard('admin')->user()->role === 'admindinas' && Auth::guard('admin')->user()->dinas != 'perpajakan' )))
                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ request()->routeIs('admin.pasar.*') ? 'active bg-light' : '' }}"
                            href="#submenu-pasar" data-toggle="collapse"
                            aria-expanded="{{ request()->routeIs('admin.pasar.*') ? 'true' : 'false' }}">
                            <span class="ml-1 item-text">Pasar-Yu</span>
                        </a>

                        <ul class="collapse list-unstyled pl-4 {{ request()->routeIs('admin.pasar.*') ? 'show' : '' }}" id="submenu-pasar">
                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ request()->routeIs('admin.pasar.tempat.index') ? 'active bg-primary text-white' : '' }}"
                                    href="{{ route('admin.pasar.tempat.index') }}">
                                    Lokasi Pasar
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif

                    {{-- Kerja-Yu --}}
                    @if (Auth::guard('admin')->check() &&
                    (Auth::guard('admin')->user()->role === 'superadmin' ||
                    (Auth::guard('admin')->user()->role === 'admindinas' && Auth::guard('admin')->user()->dinas != 'perpajakan' && Auth::guard('admin')->user()->dinas != 'perdagangan' )))
                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ request()->routeIs('admin.kerja.*') ? 'active bg-light' : '' }}"
                            href="#submenu-kerja" data-toggle="collapse"
                            aria-expanded="{{ request()->routeIs('admin.kerja.*') ? 'true' : 'false' }}">
                            <span class="ml-1 item-text">Kerja-Yu</span>
                        </a>

                        <ul class="collapse list-unstyled pl-4 {{ request()->routeIs('admin.kerja.*') ? 'show' : '' }}" id="submenu-kerja">
                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ request()->routeIs('admin.kerja.info.index') ? 'active bg-primary text-white' : '' }}"
                                    href="{{ route('admin.kerja.info.index') }}">
                                    Info Pekerjaan
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </li>

            @if (Auth::guard('admin')->check() &&
            (Auth::guard('admin')->user()->role === 'superadmin' ||
            (Auth::guard('admin')->user()->role === 'admindinas' && Auth::guard('admin')->user()->dinas != 'perpajakan' && Auth::guard('admin')->user()->dinas != 'perdagangan' )))
            <li class="nav-item dropdown {{ request()->routeIs('admin.plesir.*') || request()->routeIs('admin.ibadah.*') ? 'show' : '' }}">

                <a href="#pariwisata"
                    data-toggle="collapse"
                    aria-expanded="{{ request()->routeIs('admin.plesir.*') || request()->routeIs('admin.ibadah.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle nav-link {{ request()->routeIs('admin.plesir.*') || request()->routeIs('admin.ibadah.*') ? '' : 'collapsed' }}">
                    <i class="fe fe-layout fe-16"></i>
                    <span class="ml-3 item-text">Pariwisata & Keagamaan</span>
                </a>

                <ul class="collapse list-unstyled pl-4 w-100 {{ request()->routeIs('admin.plesir.*') || request()->routeIs('admin.ibadah.*') ? 'show' : '' }}" id="pariwisata">

                    {{-- Plesir-Yu --}}
                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ request()->routeIs('admin.plesir.*') ? 'active bg-light' : '' }}"
                            href="#submenu-plesir" data-toggle="collapse"
                            aria-expanded="{{ request()->routeIs('admin.plesir.*') ? 'true' : 'false' }}">
                            <span class="ml-1 item-text">Plesir-Yu</span>
                        </a>

                        <ul class="collapse list-unstyled pl-4 {{ request()->routeIs('admin.plesir.*') ? 'show' : '' }}" id="submenu-plesir">
                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ request()->routeIs('admin.plesir.tempat.index') ? 'active bg-primary text-white' : '' }}"
                                    href="{{ route('admin.plesir.tempat.index') }}">
                                    Lokasi Plesir
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ request()->routeIs('admin.plesir.info.index') ? 'active bg-primary text-white' : '' }}"
                                    href="{{ route('admin.plesir.info.index') }}">
                                    Info Plesir
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- Ibadah-Yu --}}
                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ request()->routeIs('admin.ibadah.*') ? 'active bg-light' : '' }}"
                            href="#submenu-ibadah" data-toggle="collapse"
                            aria-expanded="{{ request()->routeIs('admin.ibadah.*') ? 'true' : 'false' }}">
                            <span class="ml-1 item-text">Ibadah-Yu</span>
                        </a>

                        <ul class="collapse list-unstyled pl-4 {{ request()->routeIs('admin.ibadah.*') ? 'show' : '' }}" id="submenu-ibadah">
                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ request()->routeIs('admin.ibadah.tempat.index') ? 'active bg-primary text-white' : '' }}"
                                    href="{{ route('admin.ibadah.tempat.index') }}">
                                    Lokasi Tempat Ibadah
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ request()->routeIs('admin.ibadah.info.index') ? 'active bg-primary text-white' : '' }}"
                                    href="{{ route('admin.ibadah.info.index') }}">
                                    Info Keagamaan
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </li>
            @endif

            @if (Auth::guard('admin')->check() &&
            (Auth::guard('admin')->user()->role === 'superadmin' ||
            (Auth::guard('admin')->user()->role === 'admindinas' && Auth::guard('admin')->user()->dinas != 'perpajakan' && Auth::guard('admin')->user()->dinas != 'perdagangan')))
            <li class="nav-item dropdown {{ request()->routeIs('admin.adminduk.*') || request()->routeIs('admin.renbang.*') || request()->routeIs('admin.izin.*') || request()->routeIs('admin.wifi.*') ? 'show' : '' }}">
                <a href="#lainnya"
                    data-toggle="collapse"
                    aria-expanded="{{ request()->routeIs('admin.adminduk.*') || request()->routeIs('admin.renbang.*') || request()->routeIs('admin.izin.*') || request()->routeIs('admin.wifi.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle nav-link {{ request()->routeIs('admin.adminduk.*') || request()->routeIs('admin.renbang.*') || request()->routeIs('admin.izin.*') || request()->routeIs('admin.wifi.*') ? '' : 'collapsed' }}">
                    <i class="fe fe-layers fe-16"></i>
                    <span class="ml-3 item-text">Layanan Publik Lainnya</span>
                </a>

                <ul class="collapse list-unstyled pl-4 w-100 {{ request()->routeIs('admin.adminduk.*') || request()->routeIs('admin.renbang.*') || request()->routeIs('admin.izin.*') || request()->routeIs('admin.wifi.*') ? 'show' : '' }}" id="lainnya">

                    {{-- Adminduk-Yu --}}
                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ request()->routeIs('admin.adminduk.*') ? 'active bg-light' : '' }}"
                            href="#submenu-adminduk" data-toggle="collapse"
                            aria-expanded="{{ request()->routeIs('admin.adminduk.*') ? 'true' : 'false' }}">
                            <span class="ml-1 item-text">Adminduk-Yu</span>
                        </a>

                        <ul class="collapse list-unstyled pl-4 {{ request()->routeIs('admin.adminduk.*') ? 'show' : '' }}" id="submenu-adminduk">
                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ request()->routeIs('admin.adminduk.info.index') ? 'active bg-primary text-white' : '' }}"
                                    href="{{ route('admin.adminduk.info.index') }}">
                                    Info Adminduk
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- Renbang-Yu --}}
                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ request()->routeIs('admin.renbang.*') ? 'active bg-light' : '' }}"
                            href="#submenu-renbang" data-toggle="collapse"
                            aria-expanded="{{ request()->routeIs('admin.renbang.*') ? 'true' : 'false' }}">
                            <span class="ml-1 item-text">Renbang-Yu</span>
                        </a>

                        <ul class="collapse list-unstyled pl-4 {{ request()->routeIs('admin.renbang.*') ? 'show' : '' }}" id="submenu-renbang">
                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ request()->routeIs('admin.renbang.deskripsi.index') ? 'active bg-primary text-white' : '' }}"
                                    href="{{ route('admin.renbang.deskripsi.index') }}">
                                    Info Renbang
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- Izin-Yu --}}
                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ request()->routeIs('admin.izin.*') ? 'active bg-light' : '' }}"
                            href="#submenu-izin" data-toggle="collapse"
                            aria-expanded="{{ request()->routeIs('admin.izin.*') ? 'true' : 'false' }}">
                            <span class="ml-1 item-text">Izin-Yu</span>
                        </a>

                        <ul class="collapse list-unstyled pl-4 {{ request()->routeIs('admin.izin.*') ? 'show' : '' }}" id="submenu-izin">
                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ request()->routeIs('admin.izin.info.index') ? 'active bg-primary text-white' : '' }}"
                                    href="{{ route('admin.izin.info.index') }}">
                                    Info Perizinan
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- Wifi-Yu (langsung link) --}}
                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ request()->routeIs('admin.wifi.*') ? 'active bg-primary text-white' : '' }}"
                            href="{{ route('admin.wifi.index') }}">
                            <span class="ml-1 item-text">Wifi-Yu</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
        </ul>
        @endif
    </nav>
</aside>