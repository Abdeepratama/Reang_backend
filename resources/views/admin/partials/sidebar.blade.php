<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
        <div class="w-100 mb-4 mt-4 d-flex justify-content-center">
            <a href="{{ route('home') }}" class="logo d-flex align-items-center">
                <img src="{{ asset('landing/img/logo_wongreang_apps.png') }}" alt="Logo Reang Apps" class="logo-full" style="height:30px;">
                <img src="{{ asset('landing/img/logo reang.png') }}" alt="Logo Icon" class="logo-mini" style="height:20px;">
            </a>

        </div>


        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'text-primary bg-light' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-2 item-text">Dashboard</span>
                </a>
            </li>
        </ul>
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Informasi & Pelaporan Publik</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            @php
            $user = Auth::guard('admin')->user();
            $allowedDinas = [
            'kesehatan','pendidikan','perpajakan','perdagangan',
            'kerja','pariwisata','keagamaan','kependudukan',
            'pembangunan','perizinan'
            ];
            @endphp

            {{-- Menu Aduan & Kedaruratan --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dumas.*') ? 'text-primary bg-light' : '' }}"
                    href="{{ route('admin.dumas.aduan.index') }}">
                    <i class="fe fe-twitch fe-16"></i>
                    <span class="ml-2 item-text">Dumas-Yu</span>
                </a>
            </li>

            {{-- Menu Info-Yu --}}
            @if ($user && $user->role === 'superadmin')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.info.*') ? 'text-primary bg-light' : '' }}"
                    href="{{ route('admin.info.index') }}">
                    <i class="fe fe-info fe-16"></i>
                    <span class="ml-2 item-text">Info-Yu</span>
                </a>
            </li>
            @endif


            @php
            use Illuminate\Support\Facades\Auth;

            $user = Auth::guard('admin')->user();
            @endphp

            {{-- Sehat-Yu --}}
            @if (
            $user &&
            (
            $user->role === 'superadmin' ||
            $user->role === 'puskesmas' ||
            ($user->userData && $user->userData->instansi && $user->userData->instansi->nama === 'kesehatan')
            )
            )
            <li class="nav-item dropdown">
                <a class="dropdown-toggle nav-link {{ request()->routeIs('admin.sehat.*') ? 'active bg-light' : '' }}"
                    href="#submenu-sehat"
                    data-toggle="collapse"
                    aria-expanded="{{ request()->routeIs('admin.sehat.*') ? 'true' : 'false' }}">
                    <i class="fe fe-activity fe-16"></i>
                    <span class="ml-2 item-text">Sehat-Yu</span>
                </a>

                <ul class="collapse list-unstyled pl-4 {{ request()->routeIs('admin.sehat.*') ? 'show' : '' }}" id="submenu-sehat">
                    {{-- Jika bukan puskesmas, tampilkan semua menu utama --}}
                    @if ($user->role !== 'puskesmas')
                    <li>
                        <a class="nav-link pl-3 {{ request()->routeIs('admin.sehat.tempat.index') ? 'text-primary bg-light' : '' }}"
                            href="{{ route('admin.sehat.tempat.index') }}">
                            Lokasi Rumah Sakit
                        </a>
                    </li>

                    <li>
                        <a class="nav-link pl-3 {{ request()->routeIs('admin.sehat.info.index') ? 'text-primary bg-light' : '' }}"
                            href="{{ route('admin.sehat.info.index') }}">
                            Info Sehat
                        </a>
                    </li>

                    <li>
                        <a class="nav-link pl-3 {{ request()->routeIs('admin.sehat.olahraga.index') ? 'text-primary bg-light' : '' }}"
                            href="{{ route('admin.sehat.olahraga.index') }}">
                            Lokasi Olahraga
                        </a>
                    </li>
                    @endif

                    {{-- Menu khusus untuk superadmin & puskesmas --}}
                    @if ($user->role === 'superadmin' || $user->role === 'puskesmas')
                    <li>
                        <a class="nav-link pl-3 {{ request()->routeIs('admin.sehat.puskesmas.index') ? 'text-primary bg-light' : '' }}"
                            href="{{ route('admin.sehat.puskesmas.index') }}">
                            Puskesmas
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            {{-- Sekolah-Yu --}}
            @if ($user && ($user->role === 'superadmin' || ($user->userData && $user->userData->instansi && $user->userData->instansi->nama === 'pendidikan')))
            <li class="nav-item dropdown">
                <a class="dropdown-toggle nav-link {{ request()->routeIs('admin.sekolah.*') ? 'active bg-light' : '' }}"
                    href="#submenu-sekolah"
                    data-toggle="collapse"
                    aria-expanded="{{ request()->routeIs('admin.sekolah.*') ? 'true' : 'false' }}">
                    <i class="fe fe-book fe-16"></i>
                    <span class="ml-2 item-text">Sekolah-Yu</span>
                </a>
                <ul class="collapse list-unstyled pl-4 {{ request()->routeIs('admin.sekolah.*') ? 'show' : '' }}" id="submenu-sekolah">
                    <li><a class="nav-link pl-3 {{ request()->routeIs('admin.sekolah.tempat.index') ? 'text-primary bg-light' : '' }}" href="{{ route('admin.sekolah.tempat.index') }}">Lokasi Sekolah</a></li>
                    <li><a class="nav-link pl-3 {{ request()->routeIs('admin.sekolah.info.index') ? 'text-primary bg-light' : '' }}" href="{{ route('admin.sekolah.info.index') }}">Berita Pendidikan</a></li>
                </ul>
            </li>
            @endif


            <!-- =========================================================================================================================================== -->

            @if ($user->role === 'superadmin')
            <p class="text-muted nav-heading mt-4 mb-1">
                <span>Layanan Publik & Ekonomi</span>
            </p>
            @endif

            <ul class="navbar-nav flex-fill w-100 mb-2">
                {{-- Pajak-Yu --}}
                @if ($user && ($user->role === 'superadmin' || ($user->userData && $user->userData->instansi && strtolower($user->userData->instansi->nama) === 'pajak')))
                <ul class="navbar-nav flex-fill w-100 mb-2">
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle nav-link {{ request()->routeIs('admin.pajak.*') ? 'active bg-light' : '' }}"
                            href="#submenu-pajak"
                            data-toggle="collapse"
                            aria-expanded="{{ request()->routeIs('admin.pajak.*') ? 'true' : 'false' }}">
                            <i class="fe fe-dollar-sign fe-16"></i>
                            <span class="ml-2 item-text">Pajak-Yu</span>
                        </a>
                        <ul class="collapse list-unstyled pl-4 {{ request()->routeIs('admin.pajak.*') ? 'show' : '' }}" id="submenu-pajak">
                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ request()->routeIs('admin.pajak.info.index') ? 'text-primary bg-light' : '' }}"
                                    href="{{ route('admin.pajak.info.index') }}">
                                    Info Perpajakan
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                @endif

                {{-- Pasar-Yu --}}
                @if ($user && ($user->role === 'superadmin' || ($user->userData && $user->userData->instansi && strtolower($user->userData->instansi->nama) === 'perdagangan')))
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle nav-link {{ request()->routeIs('admin.pasar.*') ? 'active bg-light' : '' }}"
                        href="#submenu-pasar"
                        data-toggle="collapse"
                        aria-expanded="{{ request()->routeIs('admin.pasar.*') ? 'true' : 'false' }}">
                        <i class="fe fe-shopping-cart fe-16"></i>
                        <span class="ml-2 item-text">Pasar-Yu</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 {{ request()->routeIs('admin.pasar.*') ? 'show' : '' }}" id="submenu-pasar">
                        <li class="nav-item">
                            <a class="nav-link pl-3 {{ request()->routeIs('admin.pasar.tempat.index') ? 'text-primary bg-light' : '' }}"
                                href="{{ route('admin.pasar.tempat.index') }}">
                                Lokasi Pasar
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                {{-- Kerja-Yu --}}
                @if ($user && ($user->role === 'superadmin' || ($user->userData && $user->userData->instansi && strtolower($user->userData->instansi->nama) === 'kerja')))
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle nav-link {{ request()->routeIs('admin.kerja.*') ? 'active' : '' }}"
                        href="#submenu-kerja"
                        data-toggle="collapse"
                        aria-expanded="{{ request()->routeIs('admin.kerja.*') ? 'true' : 'false' }}">
                        <i class="fe fe-briefcase fe-16"></i>
                        <span class="ml-2 item-text">Kerja-Yu</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 {{ request()->routeIs('admin.kerja.*') ? 'show' : '' }}" id="submenu-kerja">
                        <li class="nav-item">
                            <a class="nav-link pl-3 {{ request()->routeIs('admin.kerja.info.index') ? 'text-primary bg-light' : '' }}"
                                href="{{ route('admin.kerja.info.index') }}">
                                Info Pekerjaan
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

            </ul>

            <!-- =========================================================================================================================================== -->

            @if ($user && $user->role === 'superadmin'|| ($user->userData && $user->userData->instansi && strtolower($user->userData->instansi->nama) === 'pariwisata'))
            <p class="text-muted nav-heading mt-4 mb-1">
                <span>Pariwisata & Keagamaan</span>
            </p>
            <ul class="navbar-nav flex-fill w-100 mb-2">
                @endif


                {{-- Plesir-Yu --}}
                @if ($user && ($user->role === 'superadmin' || ($user->userData && $user->userData->instansi && strtolower($user->userData->instansi->nama) === 'pariwisata')))
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle nav-link {{ request()->routeIs('admin.plesir.*') ? 'active bg-light' : '' }}"
                        href="#submenu-plesir" data-toggle="collapse"
                        aria-expanded="{{ request()->routeIs('admin.plesir.*') ? 'true' : 'false' }}">
                        <i class="fe fe-map fe-16"></i>
                        <span class="ml-2 item-text">Plesir-Yu</span>
                    </a>

                    <ul class="collapse list-unstyled pl-4 {{ request()->routeIs('admin.plesir.*') ? 'show' : '' }}" id="submenu-plesir">
                        <li class="nav-item">
                            <a class="nav-link pl-3 {{ request()->routeIs('admin.plesir.tempat.index') ? 'text-primary bg-light' : '' }}"
                                href="{{ route('admin.plesir.tempat.index') }}">
                                Lokasi Plesir
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-3 {{ request()->routeIs('admin.plesir.info.index') ? 'text-primary bg-light' : '' }}"
                                href="{{ route('admin.plesir.info.index') }}">
                                Info Plesir
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                {{-- Ibadah-Yu --}}
                @if ($user && ($user->role === 'superadmin' || ($user->userData && $user->userData->instansi && strtolower($user->userData->instansi->nama) === 'keagamaan')))
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle nav-link {{ request()->routeIs('admin.ibadah.*') ? 'active bg-light' : '' }}"
                        href="#submenu-ibadah" data-toggle="collapse"
                        aria-expanded="{{ request()->routeIs('admin.ibadah.*') ? 'true' : 'false' }}">
                        <i class="fe fe-home fe-16"></i>
                        <span class="ml-2 item-text">Ibadah-Yu</span>
                    </a>

                    <ul class="collapse list-unstyled pl-4 {{ request()->routeIs('admin.ibadah.*') ? 'show' : '' }}" id="submenu-ibadah">
                        <li class="nav-item">
                            <a class="nav-link pl-3 {{ request()->routeIs('admin.ibadah.tempat.index') ? 'text-primary bg-light' : '' }}"
                                href="{{ route('admin.ibadah.tempat.index') }}">
                                Lokasi Tempat Ibadah
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-3 {{ request()->routeIs('admin.ibadah.info.index') ? 'text-primary bg-light' : '' }}"
                                href="{{ route('admin.ibadah.info.index') }}">
                                Info Keagamaan
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>

            <!-- =========================================================================================================================================== -->

            @if ($user && $user->role === 'superadmin')
            <p class="text-muted nav-heading mt-4 mb-1">
                <span>Layanan Publik Lainnya</span>
            </p>
            @endif
            <ul class="navbar-nav flex-fill w-100 mb-2">
                {{-- Adminduk-Yu --}}
                @if ($user && ($user->role === 'superadmin' || ($user->userData && $user->userData->instansi && strtolower($user->userData->instansi->nama) === 'adminduk')))
                <li class="nav-item dropdown {{ request()->routeIs('admin.adminduk.*') ? 'show' : '' }}">
                    <a href="#submenu-adminduk" data-toggle="collapse"
                        aria-expanded="{{ request()->routeIs('admin.adminduk.*') ? 'true' : 'false' }}"
                        class="dropdown-toggle nav-link {{ request()->routeIs('admin.adminduk.*') ? '' : 'collapsed' }}">
                        <i class="fe fe-users fe-16"></i>
                        <span class="ml-2 item-text">Adminduk-Yu</span>
                    </a>

                    <ul class="collapse list-unstyled pl-4 {{ request()->routeIs('admin.adminduk.*') ? 'show' : '' }}" id="submenu-adminduk">
                        <li class="nav-item">
                            <a class="nav-link pl-3 {{ request()->routeIs('admin.adminduk.info.index') ? 'text-primary bg-light' : '' }}"
                                href="{{ route('admin.adminduk.info.index') }}">
                                Info Adminduk
                            </a>
                        </li>
                    </ul>
                </li>
                @endif


                {{-- Renbang-Yu --}}
                @if ($user && ($user->role === 'superadmin' || ($user->userData && $user->userData->instansi && strtolower($user->userData->instansi->nama) === 'renbang')))
                <li class="nav-item dropdown {{ request()->routeIs('admin.renbang.*') ? 'show' : '' }}">
                    <a href="#submenu-renbang" data-toggle="collapse"
                        aria-expanded="{{ request()->routeIs('admin.renbang.*') ? 'true' : 'false' }}"
                        class="dropdown-toggle nav-link {{ request()->routeIs('admin.renbang.*') ? '' : 'collapsed' }}">
                        <i class="fe fe-trending-up fe-16"></i>
                        <span class="ml-2 item-text">Renbang-Yu</span>
                    </a>

                    <ul class="collapse list-unstyled pl-4 {{ request()->routeIs('admin.renbang.*') ? 'show' : '' }}" id="submenu-renbang">
                        <li class="nav-item">
                            <a class="nav-link pl-3 {{ request()->routeIs('admin.renbang.info.index') ? 'text-primary bg-light' : '' }}"
                                href="{{ route('admin.renbang.info.index') }}">
                                Info Renbang
                            </a>
                        </li>
                    </ul>

                    <ul class="collapse list-unstyled pl-4 {{ request()->routeIs('admin.renbang.*') ? 'show' : '' }}" id="submenu-renbang">
                        <li class="nav-item">
                            <a class="nav-link pl-3 {{ request()->routeIs('admin.renbang.ajuan.index') ? 'text-primary bg-light' : '' }}"
                                href="{{ route('admin.renbang.ajuan.index') }}">
                                Ajuan Renbang
                            </a>
                        </li>
                    </ul>
                </li>
                @endif


                {{-- Izin-Yu --}}
                @if ($user && ($user->role === 'superadmin' || ($user->userData && $user->userData->instansi && strtolower($user->userData->instansi->nama) === 'perizinan')))
                <li class="nav-item dropdown {{ request()->routeIs('admin.izin.*') ? 'show' : '' }}">
                    <a href="#submenu-izin" data-toggle="collapse"
                        aria-expanded="{{ request()->routeIs('admin.izin.*') ? 'true' : 'false' }}"
                        class="dropdown-toggle nav-link {{ request()->routeIs('admin.izin.*') ? '' : 'collapsed' }}">
                        <i class="fe fe-file-text fe-16"></i>
                        <span class="ml-2 item-text">Izin-Yu</span>
                    </a>

                    <ul class="collapse list-unstyled pl-4 {{ request()->routeIs('admin.izin.*') ? 'show' : '' }}" id="submenu-izin">
                        <li class="nav-item">
                            <a class="nav-link pl-3 {{ request()->routeIs('admin.izin.info.index') ? 'text-primary bg-light' : '' }}"
                                href="{{ route('admin.izin.info.index') }}">
                                Info Perizinan
                            </a>
                        </li>
                    </ul>
                </li>
                @endif


                {{-- Wifi-Yu (langsung link, tidak punya submenu) --}}
                @if ($user && $user->role === 'superadmin')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.wifi.index') ? 'text-primary bg-light' : '' }}"
                        href="{{ route('admin.wifi.index') }}">
                        <i class="fe fe-wifi fe-16"></i>
                        <span class="ml-2 item-text">Wifi-Yu</span>
                    </a>
                </li>
                @endif


            </ul>
    </nav>
</aside>