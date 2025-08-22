<header id="header" class="header d-flex align-items-center fixed-top">
  <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

    <a href="{{ route('home') }}" class="logo d-flex align-items-center">
      <img src="landing/img/color_wongreang_apps.png" alt="Logo Reang Apps" style="height: 90px;">
    </a>

    <nav id="navmenu" class="navmenu" aria-label="Navigasi utama">
      <ul>
        <li><a href="{{ route('home') }}#fitur-section">Fitur</a></li>
        <li><a href="{{ route('home') }}#hero-section">Tentang</a></li>
        <li><a href="{{ route('bantuan.wadul') }}#wadul">Wadul Reang</a></li>
        <li><div class="accessibility-trigger" style="margin-left:10px;">
      <button id="open-a11y"
        aria-label="Pengaturan aksesibilitas"
        aria-haspopup="dialog"
        aria-expanded="false"
        style="background:none;border:none;cursor:pointer;font-size:1.25rem;">
  <span role="img" aria-hidden="true">⚙️</span>
</button>
    </div></li>
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list" aria-label="Buka menu"></i>
    </nav>    
  </div>
</header>