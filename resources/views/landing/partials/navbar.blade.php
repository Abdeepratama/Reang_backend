<header id="header" class="header d-flex align-items-center fixed-top">
  <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

    <a href="{{ route('home') }}" class="logo d-flex align-items-center">
      <img src="landing/img/color_wongreang_apps.png" alt="Logo Reang Apps" style="height: 90px;">
    </a>


    <nav id="navmenu" class="navmenu" aria-label="Navigasi utama">
      <ul>
        <li><a href="{{ route('home') }}#fitur-section">Fitur</a></li>
        <li><a href="{{ route('home') }}#hero-section">Tentang</a></li>
        <li><a href="{{ route('bantuan.wadul') }}#wadul">Bantuan</a></li>

      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list" aria-label="Buka menu"></i>
    </nav>
  </div>
</header>