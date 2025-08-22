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
            <li class="nav-item dropdown {{ request()->is('admin/dumas*') || request()->is('admin/info*') ? 'show' : '' }}">
                <a href="#aduan"
                    data-toggle="collapse"
                    aria-expanded="{{ request()->is('admin/dumas*') || request()->is('admin/info*') ? 'true' : 'false' }}"
                    class="dropdown-toggle nav-link {{ request()->is('admin/dumas*') || request()->is('admin/info*') ? '' : 'collapsed' }}">
                    <i class="fe fe-twitch fe-16"></i>
                    <span class="ml-3 item-text">Aduan &amp; Kedaruratan</span>
                </a>

                <ul class="collapse list-unstyled pl-4 w-100 {{ request()->is('admin/dumas*') || request()->is('admin/info*') ? 'show' : '' }}" id="aduan">
                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ request()->routeIs('admin.dumas.aduan.index') ? 'active bg-primary text-white' : '' }}"
                            href="{{ route('admin.dumas.aduan.index') }}">
                            <span class="ml-1 item-text">Dumas-Yu</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ request()->routeIs('admin.info.index') ? 'active bg-primary text-white' : '' }}"
                            href="{{ route('admin.info.index') }}">
                            <span class="ml-1 item-text">Info-Yu</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ request()->is('admin/sehat*') || request()->is('admin/sekolah*') ? 'show' : '' }}">
                <a href="#kesehatan"
                    data-toggle="collapse"
                    aria-expanded="{{ request()->is('admin/sehat*') || request()->is('admin/sekolah*') ? 'true' : 'false' }}"
                    class="dropdown-toggle nav-link {{ request()->is('admin/sehat*') || request()->is('admin/sekolah*') ? '' : 'collapsed' }}">
                    <i class="fe fe-briefcase fe-16"></i>
                    <span class="ml-3 item-text">Kesehatan & Pendidikan</span><span class="sr-only">(current)</span>
                </a>

                <ul class="collapse list-unstyled pl-4 w-100 {{ request()->is('admin/sehat*') || request()->is('admin/sekolah*') ? 'show' : '' }}" id="kesehatan">
                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ request()->is('admin/sehat*') ? 'active bg-light' : '' }}"
                            href="#submenu-sehat" data-toggle="collapse"
                            aria-expanded="{{ request()->is('admin/sehat*') ? 'true' : 'false' }}">
                            <span class="ml-1 item-text">Sehat-Yu</span>
                        </a>

                        <ul class="collapse list-unstyled pl-4 {{ request()->is('admin/sehat*') ? 'show' : '' }}" id="submenu-sehat">
                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ request()->routeIs('admin.sehat.tempat.index') ? 'active bg-primary text-white' : '' }}"
                                    href="{{ route('admin.sehat.tempat.index') }}">
                                    Lokasi Tempat
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ request()->routeIs('admin.sehat.info.index') ? 'active bg-primary text-white' : '' }}"
                                    href="{{ route('admin.sehat.info.index') }}">
                                    Info Pasar
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ request()->is('admin/sekolah*') ? 'active bg-light' : '' }}"
                            href="#submenu-sekolah" data-toggle="collapse"
                            aria-expanded="{{ request()->is('admin/sekolah*') ? 'true' : 'false' }}">
                            <span class="ml-1 item-text">Sekolah-Yu</span>
                        </a>

                        <ul class="collapse list-unstyled pl-4 {{ request()->is('admin/sekolah*') ? 'show' : '' }}" id="submenu-sekolah">
                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ request()->routeIs('admin.sekolah.tempat.index') ? 'active bg-primary text-white' : '' }}"
                                    href="{{ route('admin.sekolah.tempat.index') }}">
                                    Lokasi Tempat
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ request()->routeIs('admin.sekolah.aduan.index') ? 'active bg-primary text-white' : '' }}"
                                    href="{{ route('admin.sekolah.aduan.index') }}">
                                    Aduan sekolah
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

        </ul>

        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Layanan Publik & Ekonomi</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item dropdown {{ request()->is('admin/pajak*') || request()->is('admin/pasar*') || request()->is('admin/kerja*') ? 'show' : '' }}">
                <a href="#ekonomi"
                    data-toggle="collapse"
                    aria-expanded="{{ request()->is('admin/pajak*') || request()->is('admin/pasar*') || request()->is('admin/kerja*') ? 'true' : 'false' }}"
                    class="dropdown-toggle nav-link {{ request()->is('admin/pajak*') || request()->is('admin/pasar*') || request()->is('admin/kerja*') ? '' : 'collapsed' }}">
                    <i class="fe fe-dollar-sign fe-16"></i>
                    <span class="ml-3 item-text">Sosial & Ekonomi</span>
                </a>

                <ul class="collapse list-unstyled pl-4 w-100 {{ request()->is('admin/pajak*') || request()->is('admin/pasar*') || request()->is('admin/kerja*') ? 'show' : '' }}" id="ekonomi">
                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ request()->is('admin/pasar*') ? 'active bg-light' : '' }}"
                            href="#submenu-pasar" data-toggle="collapse"
                            aria-expanded="{{ request()->is('admin/pasar*') ? 'true' : 'false' }}">
                            <span class="ml-1 item-text">Pasar-Yu</span>
                        </a>

                        <ul class="collapse list-unstyled pl-4 {{ request()->is('admin/pasar*') ? 'show' : '' }}" id="submenu-pasar">
                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ request()->routeIs('admin.pasar.tempat.index') ? 'active bg-primary text-white' : '' }}"
                                    href="{{ route('admin.pasar.tempat.index') }}">
                                    Lokasi Tempat
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ request()->routeIs('admin.pasar.info.index') ? 'active bg-primary text-white' : '' }}"
                                    href="{{ route('admin.pasar.info.index') }}">
                                    Info Pasar
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ request()->routeIs('admin.pajak.index') ? 'active bg-primary text-white' : '' }}"
                            href="{{ route('admin.pajak.index') }}">
                            <span class="ml-1 item-text">Pajak-Yu</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ request()->routeIs('admin.kerja.index') ? 'active bg-primary text-white' : '' }}"
                            href="{{ route('admin.kerja.index') }}">
                            <span class="ml-1 item-text">Kerja-Yu</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ request()->is('admin/ibadah*') || request()->is('admin/plesir*') ? 'show' : '' }}">
                <a href="#pariwisata"
                    data-toggle="collapse"
                    aria-expanded="{{ request()->is('admin/ibadah*') || request()->is('admin/plesir*') ? 'true' : 'false' }}"
                    class="dropdown-toggle nav-link {{ request()->is('admin/ibadah*') || request()->is('admin/plesir*') ? '' : 'collapsed' }}">
                    <i class="fe fe-layout fe-16"></i>
                    <span class="ml-3 item-text">Pariwisata & Keagamaan</span>
                </a>

                <ul class="collapse list-unstyled pl-4 w-100 {{ request()->is('admin/ibadah*') || request()->is('admin/plesir*') ? 'show' : '' }}" id="pariwisata">
                    <!-- Menu Plesir-Yu -->
                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ request()->is('admin/plesir*') ? 'active bg-light' : '' }}"
                            href="#submenu-plesir" data-toggle="collapse"
                            aria-expanded="{{ request()->is('admin/plesir*') ? 'true' : 'false' }}">
                            <span class="ml-1 item-text">Plesir-Yu</span>
                        </a>

                        <ul class="collapse list-unstyled pl-4 {{ request()->is('admin/plesir*') ? 'show' : '' }}" id="submenu-plesir">
                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ request()->routeIs('admin.plesir.tempat.index') ? 'active bg-primary text-white' : '' }}"
                                    href="{{ route('admin.plesir.tempat.index') }}">
                                    Lokasi Tempat
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

                    <!-- Menu Ibadah-Yu (Submenu sebagai list biasa) -->
                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ request()->is('admin/ibadah*') ? 'active bg-light' : '' }}"
                            href="#submenu-ibadah" data-toggle="collapse"
                            aria-expanded="{{ request()->is('admin/ibadah*') ? 'true' : 'false' }}">
                            <span class="ml-1 item-text">Ibadah-Yu</span>
                        </a>

                        <ul class="collapse list-unstyled pl-4 {{ request()->is('admin/ibadah*') ? 'show' : '' }}" id="submenu-ibadah">
                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ request()->routeIs('admin.ibadah.tempat.index') ? 'active bg-primary text-white' : '' }}"
                                    href="{{ route('admin.ibadah.tempat.index') }}">
                                    Lokasi Tempat
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

        </ul>
        </li>
        <li class="nav-item dropdown {{ request()->routeIs('admin.adminduk.*') || request()->routeIs('admin.renbang.*') || request()->routeIs('admin.izin.*') || request()->routeIs('admin.wifi.*') || request()->routeIs('admin.pajak.*') || request()->routeIs('admin.pasar.*') || request()->routeIs('admin.kerja.*') ? 'active' : '' }}">
            <a href="#lainnya" data-toggle="collapse" aria-expanded="{{ request()->routeIs('admin.adminduk.*') || request()->routeIs('admin.renbang.*') || request()->routeIs('admin.izin.*') || request()->routeIs('admin.wifi.*') || request()->routeIs('admin.pajak.*') || request()->routeIs('admin.pasar.*') || request()->routeIs('admin.kerja.*') ? 'true' : 'false' }}" class="dropdown-toggle nav-link">
                <i class="fe fe-layers fe-16"></i>
                <span class="ml-3 item-text">Layanan Publik Lainnya</span><span class="sr-only">(current)</span>
            </a>
            <ul class="collapse list-unstyled pl-4 w-100 {{ request()->routeIs('admin.adminduk.*') || request()->routeIs('admin.renbang.*') || request()->routeIs('admin.izin.*') || request()->routeIs('admin.wifi.*') || request()->routeIs('admin.pajak.*') || request()->routeIs('admin.pasar.*') || request()->routeIs('admin.kerja.*') ? 'show' : '' }}" id="lainnya">
                <li class="nav-item">
                    <a class="nav-link pl-3 {{ request()->routeIs('admin.adminduk.*') ? 'active bg-primary text-white' : '' }}" href="{{ route('admin.adminduk.index') }}">
                        <span class="ml-1 item-text">Adminduk-Yu</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pl-3 {{ request()->routeIs('admin.renbang.*') ? 'active bg-primary text-white' : '' }}" href="{{ route('admin.renbang.index') }}">
                        <span class="ml-1 item-text">Renbang-Yu</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pl-3 {{ request()->routeIs('admin.izin.*') ? 'active bg-primary text-white' : '' }}" href="{{ route('admin.izin.index') }}">
                        <span class="ml-1 item-text">Izin-Yu</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pl-3 {{ request()->routeIs('admin.wifi.*') ? 'active bg-primary text-white' : '' }}" href="{{ route('admin.wifi.index') }}">
                        <span class="ml-1 item-text">Wifi-Yu</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pl-3 {{ request()->routeIs('admin.pajak.*') ? 'active bg-primary text-white' : '' }}" href="{{ route('admin.pajak.index') }}">
                        <span class="ml-1 item-text">Pajak-Yu</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pl-3 {{ request()->routeIs('admin.pasar.*') ? 'active bg-primary text-white' : '' }}" href="{{ route('admin.pasar.index') }}">
                        <span class="ml-1 item-text">Pasar-Yu</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pl-3 {{ request()->routeIs('admin.kerja.*') ? 'active bg-primary text-white' : '' }}" href="{{ route('admin.kerja.index') }}">
                        <span class="ml-1 item-text">Kerja-Yu</span>
                    </a>
                </li>
            </ul>
        </li>
        </ul>

        <!-- <p class="text-muted nav-heading mt-4 mb-1">
            <span>Kesehatan & Pendidikan</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fe fe-briefcase fe-16"></i>
                    <span class="ml-3 item-text">Sehat-Yu</span>
                </a>
            </li>
            <li class="nav-item w-100">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fe fe-book fe-16"></i>
                    <span class="ml-3 item-text">Sekolah-Yu</span>
                </a>
            </li>
        </ul>

        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Kesehatan & Pendidikan</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fe fe-briefcase fe-16"></i>
                    <span class="ml-3 item-text">Sehat-Yu</span>
                </a>
            </li>
            <li class="nav-item w-100">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fe fe-book fe-16"></i>
                    <span class="ml-3 item-text">Sekolah-Yu</span>
                </a>
            </li>
        </ul>
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Apps</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="calendar.html">
                    <i class="fe fe-calendar fe-16"></i>
                    <span class="ml-3 item-text">Calendar</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="#contact" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-book fe-16"></i>
                    <span class="ml-3 item-text">Contacts</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="contact">
                    <a class="nav-link pl-3" href="./contacts-list.html"><span class="ml-1">Contact List</span></a>
                    <a class="nav-link pl-3" href="./contacts-grid.html"><span class="ml-1">Contact Grid</span></a>
                    <a class="nav-link pl-3" href="./contacts-new.html"><span class="ml-1">New Contact</span></a>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a href="#profile" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-user fe-16"></i>
                    <span class="ml-3 item-text">Profile</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="profile">
                    <a class="nav-link pl-3" href="./profile.html"><span class="ml-1">Overview</span></a>
                    <a class="nav-link pl-3" href="./profile-settings.html"><span class="ml-1">Settings</span></a>
                    <a class="nav-link pl-3" href="./profile-security.html"><span class="ml-1">Security</span></a>
                    <a class="nav-link pl-3" href="./profile-notification.html"><span class="ml-1">Notifications</span></a>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a href="#fileman" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-folder fe-16"></i>
                    <span class="ml-3 item-text">File Manager</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="fileman">
                    <a class="nav-link pl-3" href="./files-list.html"><span class="ml-1">Files List</span></a>
                    <a class="nav-link pl-3" href="./files-grid.html"><span class="ml-1">Files Grid</span></a>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a href="#support" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-compass fe-16"></i>
                    <span class="ml-3 item-text">Help Desk</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="support">
                    <a class="nav-link pl-3" href="./support-center.html"><span class="ml-1">Home</span></a>
                    <a class="nav-link pl-3" href="./support-tickets.html"><span class="ml-1">Tickets</span></a>
                    <a class="nav-link pl-3" href="./support-ticket-detail.html"><span class="ml-1">Ticket Detail</span></a>
                    <a class="nav-link pl-3" href="./support-faqs.html"><span class="ml-1">FAQs</span></a>
                </ul>
            </li>
        </ul>
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Extra</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item dropdown">
                <a href="#pages" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-file fe-16"></i>
                    <span class="ml-3 item-text">Pages</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100 w-100" id="pages">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="./page-orders.html">
                            <span class="ml-1 item-text">Orders</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="./page-timeline.html">
                            <span class="ml-1 item-text">Timeline</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="./page-invoice.html">
                            <span class="ml-1 item-text">Invoice</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="./page-404.html">
                            <span class="ml-1 item-text">Page 404</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="./page-500.html">
                            <span class="ml-1 item-text">Page 500</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="./page-blank.html">
                            <span class="ml-1 item-text">Blank</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a href="#auth" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-shield fe-16"></i>
                    <span class="ml-3 item-text">Authentication</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="auth">
                    <a class="nav-link pl-3" href="./auth-login.html"><span class="ml-1">Login 1</span></a>
                    <a class="nav-link pl-3" href="./auth-login-half.html"><span class="ml-1">Login 2</span></a>
                    <a class="nav-link pl-3" href="./auth-register.html"><span class="ml-1">Register</span></a>
                    <a class="nav-link pl-3" href="./auth-resetpw.html"><span class="ml-1">Reset Password</span></a>
                    <a class="nav-link pl-3" href="./auth-confirm.html"><span class="ml-1">Confirm Password</span></a>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a href="#layouts" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-layout fe-16"></i>
                    <span class="ml-3 item-text">Layout</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="layouts">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="./index.html"><span class="ml-1 item-text">Default</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="./index-horizontal.html"><span class="ml-1 item-text">Top Navigation</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="./index-boxed.html"><span class="ml-1 item-text">Boxed</span></a>
                    </li>
                </ul>
            </li>
        </ul> -->

         
    </nav>
</aside>