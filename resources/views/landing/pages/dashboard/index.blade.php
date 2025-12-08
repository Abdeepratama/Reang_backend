@extends('landing.partials.app')

@section('content')
<section id="hero" class="hero section dark-background">
  <!-- <img src="assets/img/hero-bg-2.jpg" alt="" class="hero-bg"> -->
  <video autoplay muted loop playsinline class="hero-bg">
  <!--  <source src="https://jaki.jakarta.go.id/static/jaki-video-a857b6f40ae2aab3d9bd1a2b531e016b.mp4" type="video/mp4"> -->
  <source src="https://wongreang.indramayukab.go.id/landing/alun-alun.mp4" type="video/mp4">
  </video>
  <!-- <div class="hero-bg youtube-bg">
        <iframe
          src="https://www.youtube.com/embed/1YkkDHue270?autoplay=1&mute=1&loop=1&playlist=1YkkDHue270&controls=0&showinfo=0&modestbranding=1&rel=0&playsinline=1"
          frameborder="0"
          allow="autoplay; encrypted-media"
          allowfullscreen
        ></iframe>
      </div> -->


  <div class="container mt-5">
    <div class="row gy-5 justify-content-between">
      <div class="col-lg-8 d-flex flex-column justify-content-center" data-aos="fade-in">
        <h1>Semua Tentang</h1>
        <h1>Indramayu</h1>
        <h1><span>Ada di Saku Anda</span></h1>
        <p>Jelajahi Indramayu dalam satu aplikasi pintar.</p>
        <!-- <div class="d-flex">
              <a href="#about" class="btn-get-started">Get Started</a>
              <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Watch Video</span></a>
            </div> -->
      </div>
      <div class="col-lg-4 order-lg-last">
        <!-- <img src="assets/img/hero-img.png" class="img-fluid animated" alt=""> -->
        <div class="d-flex img-fluid animated">  <!-- animated untuk gerak gerak,kalo mau di diamkan hapus saja -->
          <!-- <a href="#about" class="btn-get-started me-3 d-inline-flex align-items-center gap-2">
            <i class="bi bi-question-circle"></i>
            <span>Wadul Reang</span>
          </a> -->
          <a href="#app"
            class="glightbox btn-get-started d-flex align-items-center">
            <img src="landing/img/playstore.png" alt="Play Store" class="playstore-icon">
            <span>Unduh Reang Apps</span>
          </a>
        </div>
      </div>

    </div>
  </div>

  <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28 " preserveAspectRatio="none">
    <defs>
      <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
    </defs>
    <g class="wave1">
      <use xlink:href="#wave-path" x="50" y="3"></use>
    </g>
    <g class="wave2">
      <use xlink:href="#wave-path" x="50" y="0"></use>
    </g>
    <g class="wave3">
      <use xlink:href="#wave-path" x="50" y="9"></use>
    </g>
  </svg>

</section><!-- /Hero Section -->

<!-- About Section -->
<section id="fitur-section" class="hero-roles-wrapper">
  <div class="container">
    <div class="title-group">
      <h1>Cari fitur yang paling pas buat kamu</h1>
      <p>Tentukan sendiri sesuai kebutuhanmu</p>
    </div>

    <div class="role-tabs" role="tablist" aria-label="Pilih kategori">
      <button class="tab active" data-role="publik" role="tab" aria-selected="true">Publik</button>
      <button class="tab" data-role="pelayanan" role="tab" aria-selected="false">Pelayanan</button>
      <button class="tab" data-role="sosial" role="tab" aria-selected="false">Sosial</button>
      <button class="tab" data-role="pariwisata" role="tab" aria-selected="false">Pariwisata</button>
      <button class="tab" data-role="lainnya" role="tab" aria-selected="false">Lainnya</button>
    </div>

    <div class="hero-card-custom" aria-labelledby="hero-title" aria-describedby="hero-desc">
      <div class="decor" aria-hidden="true"></div>
      <div class="hero-right">
        <div>
          <h2 id="hero-title">Informasi & Pelaporan Publik</h2>
          <p id="hero-desc">Akses berita terbaru, informasi penting daerah, dan laporkan masalah publik secara cepat.</p>
        </div>
        <div class="feature-list-custom" aria-label="Daftar fitur">
          <!-- items diinject lewat JS -->
        </div>
        <div class="d-flex align-items-center gap-3" style="margin-top:8px;">
          <a href="#app" class="btn-hero-cta">Selengkapnya</a>
          <div class="small-desc">dan banyak fitur bermanfaat lainnya..</div>
        </div>
      </div>
    </div>
</section>

<!-- Features Section -->
<section id="hero-section" class="hero-section d-flex align-items-center justify-content-center text-center"
  style="background-image: url('landing/img/background2.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 100vh; padding: 100px 0;">

  <div class="container position-relative">

    <h6 class="text-uppercase text-primary mb-3">WONG REANG CITIZEN ACCOUNT</h6>
    <h2 class="fw-bold mb-5 text-white">Special Service With Personalized Information</h2>

    <!-- Card Ikon -->
    <div class="feature-card d-flex flex-wrap justify-content-center gap-3 shadow-lg px-4 py-3 rounded-4 bg-white bg-opacity-75">

      <div class="text-center mx-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Melaporkan masalah, kejadian darurat, atau aduan masyarakat">
        <i class="bi bi-exclamation-circle fs-4 text-primary"></i>
        <div class="small mt-1">Aduan & Kedaruratan</div>
      </div>

      <div class="text-center mx-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Akses info/layanan terkait fasilitas dan program kesehatan">
        <i class="bi bi-heart-pulse fs-4 text-danger"></i>
        <div class="small mt-1">Kesehatan</div>
      </div>

      <div class="text-center mx-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Layanan seputar sekolah, siswa, dan dukungan pendidikan">
        <i class="bi bi-people fs-4 text-success"></i>
        <div class="small mt-1">Pendidikan</div>
      </div>

      <div class="text-center mx-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Bantuan sosial, pemberdayaan ekonomi, dan kesejahteraan">
        <i class="bi bi-check-circle fs-4 text-warning"></i>
        <div class="small mt-1">Sosial & Ekonomi</div>
      </div>

      <div class="text-center mx-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Informasi tempat wisata dan kegiatan plesir">
        <i class="bi bi-globe2 fs-4 text-info"></i>
        <div class="small mt-1">Pariwisata</div>
      </div>

      <div class="text-center mx-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Layanan dan informasi kegiatan ibadah serta sarana keagamaan">
        <i class="bi bi-moon-stars fs-4 text-secondary"></i>
        <div class="small mt-1">Keagamaan</div>
      </div>

    </div>
  </div>
</section>

<!-- Welcome Section -->
<section id="app" class="welcome-section d-flex align-items-center">

  <div class="container">
    <div class="row align-items-center justify-content-between">

      <!-- Left Content -->
      <div class="col-lg-6 text-white" data-aos="fade-right">
        <h2 class="fw-bold mb-3">
          Mau Lebih Mudah <span class="text-info">di Indramayu?</span>
        </h2>
        <p class="fs-5 mb-4">
          Selesaikan berbagai urusan Anda dengan <strong>Wong Reang Apps</strong><br>
          <span class="text-info">#makesiteasy</span>
        </p>
        <p class="fw-semibold mb-4">
          Siap digunakan! Unduh Reang sekarang juga.
        </p>

        <!-- Download Buttons -->
        <div class="d-flex gap-3">
          <a href="#" class="btn btn-light d-flex align-items-center px-3 py-2 rounded-3 shadow-sm">
            <i class="bi bi-google-play fs-5 me-2"></i> Play Store
          </a>
          <a href="#" class="btn btn-light d-flex align-items-center px-3 py-2 rounded-3 shadow-sm">
            <i class="bi bi-apple fs-5 me-2"></i> App Store
          </a>
        </div>
      </div>

      <!-- Right Content (Mockup) -->
      <div class="col-lg-5 mt-5 mt-lg-0 text-center" data-aos="fade-left">
        <img src="{{ asset('landing/img/color_wongreang_apps.png') }}" alt="Reang App" class="img-fluid mockup-img">
      </div>
    </div>
  </div>

</section>

@endsection