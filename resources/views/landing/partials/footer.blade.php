<footer id="footer" class="footer dark-background">

  <div class="container footer-top">
    <div class="row gy-4">
      <div class="col-lg-4 col-md-6 footer-about">
        <a href="index.html" class="logo d-flex align-items-center">
          <span class="sitename">Selesaikan urusanmu di Indramayu dengan Wong Reang Apps</span>
        </a>
        <div class="footer-contact pt-3">
          <p><strong>Ayo download Wong Reang Apps</strong></p>
          <p><strong>Email:</strong> <span>raulharahap776@gmail.com</span></p>
        </div>
        <div class="social-links d-flex mt-4">
          <a href=""><i class="bi bi-twitter-x"></i></a>
          <a href=""><i class="bi bi-facebook"></i></a>
          <a href=""><i class="bi bi-instagram"></i></a>
          <a href=""><i class="bi bi-linkedin"></i></a>
        </div>
      </div>

      <div class="col-lg-2 col-md-3 footer-links">
        <ul>
          <div class="role-tabs" role="tablist" aria-label="Pilih kategori"></div>
          <li><a href="#fitur-section">Fitur</a></li>
          <li><a href="#">Tentang</a></li>
          <li><a href="#">Wadul Reang</a></li>
          <li><a href="{{ route('admin.login') }}">Login</a></li>
        </ul>
      </div>


      <div class="col-lg-2 col-md-3 footer-links">
        <h4>Our Services</h4>
        <ul>
          <li><a href="#">Web Design</a></li>
          <li><a href="#">Web Development</a></li>
          <li><a href="#">Product Management</a></li>
          <li><a href="#">Marketing</a></li>
          <li><a href="#">Graphic Design</a></li>
        </ul>
      </div>

      <div class="col-lg-4 col-md-12 footer-newsletter">
        <h4>Our Newsletter</h4>
        <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
        <form action="forms/newsletter.php" method="post" class="php-email-form">
          <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Subscribe"></div>
          <div class="loading">Loading</div>
          <div class="error-message"></div>
          <div class="sent-message">Your subscription request has been sent. Thank you!</div>
        </form>
      </div>

      <div class="a11y-panel" role="dialog" aria-label="Panel Aksesibilitas" aria-modal="true" id="a11yPanel">
        <div class="a11y-header">
          <div>
            <strong id="panel-title">Sarana</strong>
          </div>
          <button class="a11y-close" aria-label="Tutup panel" id="closeBtn">&times;</button>
        </div>

        <!-- 🔽 Pindahkan contenttoolbar_disabilitas ke sini -->
        <div class="contenttoolbar_disabilitas" id="groupcekmenu">
          <div class="titletools" id="taccessbility">Sarana</div>

          <div class="btn-container">
            <div class="mycheckbox switch btn-color-mode-switch" id="tmulticheckboxlang">
              <input type="checkbox" id="checklang" value="1">
              <label id="tmycheckbox" for="checklang" data-on="Inggris" data-off="Indonesia" class="btn-color-mode-switch-inner"></label>
            </div>
          </div>

          <div class="bodytools">
            <!-- Semua subtitletools dari kode kamu -->
            <div class="subtitletools" id="webspeach">
              <div class="flexrowdata">
                <span class="disabilitas-icon"> ... ikon SVG ... </span>
                &nbsp;&nbsp;<div id="twebspeach" class="aksestexttools">Moda Suara</div>
              </div>
            </div>
            <div class="voice-controls">
              <button class="btn" id="startVoice" aria-label="Mulai membaca">▶️ Baca</button>
              <button class="btn" id="pauseVoice" aria-label="Jeda" disabled>⏸️ Jeda</button>
              <button class="btn" id="stopVoice" aria-label="Hentikan" disabled>⏹️ Hentikan</button>
            </div>

            <div class="separator"></div>

            <!-- Teks & Tema -->
            <div class="section">
              <div style="display:flex; align-items:center; gap:6px;">
                <span class="icon" aria-hidden="true">🔍</span>
                <strong class="small">Teks & Tema</strong>
              </div>

              <div class="control-row">
                <div style="display:flex; gap:6px;">
                  <button class="btn" data-action="increase-text">Perbesar Teks</button>
                  <button class="btn" data-action="decrease-text">Perkecil Teks</button>
                </div>
                <div style="display:flex; gap:6px;">
                  <button class="btn" data-toggle="grayscale">Skala Abu - Abu</button>
                  <button class="btn" data-toggle="high-contrast">Kontras Tinggi</button>
                </div>
                <div style="display:flex; gap:6px;">
                  <button class="btn" data-toggle="dark-mode">Latar Gelap</button>
                  <button class="btn" data-toggle="light-mode">Latar Terang</button>
                </div>
                <div style="display:flex; gap:6px;">
                  <button class="btn" data-toggle="spacing-wide">Rata Tulisan</button>
                </div>
              </div>
            </div>

            <div class="separator"></div>

            <!-- Reset -->
            <div class="section">
              <button class="btn full" id="resetBtn">Atur Ulang</button>
            </div>
          </div>

        </div>
      </div>

      <div class="container copyright text-center mt-4">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">Bootslander</strong> <span>All Rights Reserved</span></p>
        <div class="credits">
          <!-- All the links in the footer should remain intact. -->
          <!-- You can delete the links only if you've purchased the pro version. -->
          <!-- Licensing information: https://bootstrapmade.com/license/ -->
          <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
          Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> Distributed By <a href="https://themewagon.com">ThemeWagon</a>
        </div>
      </div>

</footer>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src="{{ asset('landing/vendor/bootstrap/js/bootstrap.bundle.min.js')}} "></script>
<script src="{{ asset('landing/vendor/php-email-form/validate.js')}} "></script>
<script src="{{ asset('landing/vendor/aos/aos.js')}} "></script>
<script src="{{ asset('landing/vendor/glightbox/js/glightbox.min.js')}} "></script>
<script src="{{ asset('landing/vendor/purecounter/purecounter_vanilla.js')}} "></script>
<script src="{{ asset('landing/vendor/swiper/swiper-bundle.min.js')}} "></script>

<!-- Main JS File -->
<script src="{{ asset('landing/js/main.js')}} "></script>

<!-- <div style="margin-top:6px; display:flex; align-items:center; gap:6px;">
  <input type="checkbox" id="autoSpeakSelection" />
  <label for="autoSpeakSelection" style="font-size:12px;">Baca saat blok</label>
</div> -->

<script>
  // STATE
  let currentLang = 'id';
  const synth = window.speechSynthesis;
  let utterance = null;
  let isPaused = false;
  let lastFocused = null;

  // ELEMENTS
  const langButtons = document.querySelectorAll('[data-lang]');
  const panelTitle = document.getElementById('panel-title');
  const voiceLabel = document.getElementById('voice-label');
  const rateInput = document.getElementById('voice-rate');
  const rateVal = document.getElementById('rateVal');
  const openBtn = document.getElementById('open-a11y');
  const panel = document.getElementById('a11yPanel');
  const closeBtn = document.getElementById('closeBtn');
  const startBtn = document.getElementById('startVoice');
  const pauseBtn = document.getElementById('pauseVoice');
  const stopBtn = document.getElementById('stopVoice');
  const resetBtn = document.getElementById('resetBtn');
  const autoSpeakCheckbox = document.getElementById('autoSpeakSelection');

  // voice list & loader
  let voices = [];

  function loadVoices() {
    voices = synth.getVoices();
  }
  synth.onvoiceschanged = loadVoices;
  loadVoices();

  function getPreferredVoice() {
    if (currentLang === 'en') {
      return voices.find(v => /en[-_]?/i.test(v.lang)) || null;
    } else {
      return voices.find(v => /id[-_]?/i.test(v.lang)) || null;
    }
  }

  // translation dictionary
  function t(key) {
    const dict = {
      id: {
        'Sarana': 'Sarana',
        'Moda Suara': 'Moda Suara',
        'Perbesar Teks': 'Perbesar Teks',
        'Perkecil Teks': 'Perkecil Teks',
        'Skala Abu - Abu': 'Skala Abu - Abu',
        'Kontras Tinggi': 'Kontras Tinggi',
        'Latar Gelap': 'Latar Gelap',
        'Latar Terang': 'Latar Terang',
        'Tulisan Dapat Dibaca': 'Tulisan Dapat Dibaca',
        'Garis Bawah Tautan': 'Garis Bawah Tautan',
        'Rata Tulisan': 'Rata Tulisan',
        'Atur Ulang': 'Atur Ulang',
        'Baca': 'Baca',
        'Jeda': 'Jeda',
        'Hentikan': 'Hentikan',
      },
      en: {
        'Sarana': 'Tools',
        'Moda Suara': 'Voice Mode',
        'Perbesar Teks': 'Increase Text',
        'Perkecil Teks': 'Decrease Text',
        'Skala Abu - Abu': 'Grayscale',
        'Kontras Tinggi': 'High Contrast',
        'Latar Gelap': 'Dark Background',
        'Latar Terang': 'Light Background',
        'Tulisan Dapat Dibaca': 'Readable Font',
        'Garis Bawah Tautan': 'Underline Links',
        'Rata Tulisan': 'Text Spacing',
        'Atur Ulang': 'Reset',
        'Baca': 'Read',
        'Jeda': 'Pause',
        'Hentikan': 'Stop',
      }
    };
    return dict[currentLang]?.[key] || key;
  }

  function updateLabels() {
    if (panelTitle) panelTitle.textContent = t('Sarana');
    if (voiceLabel) voiceLabel.textContent = t('Moda Suara');
    if (startBtn) startBtn.textContent = '▶️ ' + t('Baca');
    if (pauseBtn) pauseBtn.textContent = '⏸️ ' + t('Jeda');
    if (stopBtn) stopBtn.textContent = '⏹️ ' + t('Hentikan');
    document.querySelectorAll('[data-action="increase-text"]').forEach(b => b.textContent = t('Perbesar Teks'));
    document.querySelectorAll('[data-action="decrease-text"]').forEach(b => b.textContent = t('Perkecil Teks'));
    document.querySelectorAll('[data-toggle]').forEach(b => {
      const key = b.getAttribute('data-toggle');
      let label = '';
      switch (key) {
        case 'grayscale':
          label = t('Skala Abu - Abu');
          break;
        case 'high-contrast':
          label = t('Kontras Tinggi');
          break;
        case 'dark-mode':
          label = t('Latar Gelap');
          break;
        case 'light-mode':
          label = t('Latar Terang');
          break;
        case 'readable-font':
          label = t('Tulisan Dapat Dibaca');
          break;
        case 'underline-links':
          label = t('Garis Bawah Tautan');
          break;
        case 'spacing-wide':
          label = t('Rata Tulisan');
          break;
        default:
          label = key;
      }
      b.textContent = label;
    });
    if (resetBtn) resetBtn.textContent = t('Atur Ulang');
  }

  // language toggle
  langButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      langButtons.forEach(b => {
        b.classList.remove('active');
        b.setAttribute('aria-pressed', 'false');
      });
      btn.classList.add('active');
      btn.setAttribute('aria-pressed', 'true');
      currentLang = btn.getAttribute('data-lang') || 'id';
      updateLabels();
    });
  });

  // text scaling
  let textScale = 1;
  const incText = document.querySelector('[data-action="increase-text"]');
  const decText = document.querySelector('[data-action="decrease-text"]');
  if (incText) incText.addEventListener('click', () => {
    textScale = Math.min(2, textScale + 0.1);
    document.body.style.fontSize = textScale + 'em';
  });
  if (decText) decText.addEventListener('click', () => {
    textScale = Math.max(0.5, textScale - 0.1);
    document.body.style.fontSize = textScale + 'em';
  });

  // toggles
  document.querySelectorAll('[data-toggle]').forEach(btn => {
    btn.addEventListener('click', () => {
      const toggle = btn.getAttribute('data-toggle');
      switch (toggle) {
        case 'grayscale':
          document.body.classList.toggle('grayscale');
          break;
        case 'high-contrast':
          if (document.body.getAttribute('data-contrast') === 'high') {
            document.body.removeAttribute('data-contrast');
          } else {
            document.body.setAttribute('data-contrast', 'high');
          }
          break;
        case 'dark-mode':
          document.body.setAttribute('data-theme', 'dark');
          break;
        case 'light-mode':
          document.body.removeAttribute('data-theme');
          document.body.removeAttribute('data-contrast');
          break;
        case 'readable-font':
          document.body.classList.toggle('readable-font');
          break;
        case 'underline-links':
          document.body.classList.toggle('underline-links');
          break;
        case 'spacing-wide':
          document.body.classList.toggle('spacing-wide');
          break;
      }
    });
  });

  // reset
  if (resetBtn) {
    resetBtn.addEventListener('click', () => {
      textScale = 1;
      document.body.style.fontSize = '';
      document.body.classList.remove('grayscale', 'readable-font', 'underline-links', 'spacing-wide');
      document.body.removeAttribute('data-theme');
      document.body.removeAttribute('data-contrast');
    });
  }

  // helper ambil teks utama
  function getTextForReading() {
    const main = document.querySelector('main');
    return main ? main.innerText : document.body.innerText;
  }

  // unified speak function
  function speakText(text) {
    if (!synth || !text || !text.trim()) return;
    synth.cancel();
    utterance = new SpeechSynthesisUtterance(text.trim());
    const rate = rateInput ? parseFloat(rateInput.value) : 1;
    utterance.rate = isNaN(rate) ? 1 : rate;
    utterance.lang = currentLang === 'en' ? 'en-US' : 'id-ID';
    const preferred = getPreferredVoice();
    if (preferred) utterance.voice = preferred;
    utterance.onend = () => {
      if (startBtn) startBtn.disabled = false;
      if (pauseBtn) pauseBtn.disabled = true;
      if (stopBtn) stopBtn.disabled = true;
      isPaused = false;
      if (pauseBtn) pauseBtn.textContent = '⏸️ ' + t('Jeda');
    };
    utterance.onerror = (e) => {
      console.error('Speech error', e);
    };
    synth.speak(utterance);
    if (startBtn) startBtn.disabled = true;
    if (pauseBtn) pauseBtn.disabled = false;
    if (stopBtn) stopBtn.disabled = false;
    isPaused = false;
  }

  function speak() {
    const sel = window.getSelection().toString().trim();
    if (sel) {
        speakText(sel);
    } else {
        speakText(getTextForReading());
    }
}

  // voice controls
  if (startBtn) {
    startBtn.addEventListener('click', speak);
  }
  if (pauseBtn) {
    pauseBtn.addEventListener('click', () => {
      if (!synth) return;
      if (isPaused) {
        synth.resume();
        isPaused = false;
        pauseBtn.textContent = '⏸️ ' + t('Jeda');
      } else {
        synth.pause();
        isPaused = true;
        pauseBtn.textContent = '▶️ ' + t('Baca');
      }
    });
  }
  if (stopBtn) {
    stopBtn.addEventListener('click', () => {
      if (!synth) return;
      synth.cancel();
      if (startBtn) startBtn.disabled = false;
      if (pauseBtn) pauseBtn.disabled = true;
      if (stopBtn) stopBtn.disabled = true;
      isPaused = false;
      if (pauseBtn) pauseBtn.textContent = '⏸️ ' + t('Jeda');
    });
  }
  if (rateInput) {
    rateInput.addEventListener('input', () => {
      if (rateVal) rateVal.textContent = parseFloat(rateInput.value).toFixed(1);
    });
  }

  // auto-speak selection
  let lastSelection = '';
  let selectionTimer = null;

  function handleSelectionChange() {
    if (!autoSpeakCheckbox || !autoSpeakCheckbox.checked) return;
    const sel = window.getSelection();
    if (!sel) return;
    const text = sel.toString().trim();
    if (!text) {
      lastSelection = '';
      return;
    }
    if (text === lastSelection) return;
    // ignore inside form fields
    const anchorNode = sel.anchorNode;
    if (anchorNode) {
      const parent = anchorNode.parentElement;
      if (parent && parent.closest('input, textarea')) return;
    }
    lastSelection = text;
    speakText(text);
  }

  document.addEventListener("mouseup", function() {
    const selectedText = window.getSelection().toString().trim();
    if (selectedText && autoSpeakCheckbox && autoSpeakCheckbox.checked) {
        speakText(selectedText); // pakai fungsi global
    }
});

  // panel open/close & focus trap
  function focusableIn(el) {
    return el ?
      Array.from(el.querySelectorAll('button, [href], input, [tabindex]:not([tabindex="-1"])'))
      .filter(e => !e.hasAttribute('disabled')) : [];
  }

  function trapFocus(e) {
    if (e.key !== 'Tab' || !panel) return;
    const focusables = focusableIn(panel);
    if (focusables.length === 0) return;
    const first = focusables[0];
    const last = focusables[focusables.length - 1];
    if (e.shiftKey) {
      if (document.activeElement === first) {
        e.preventDefault();
        last.focus();
      }
    } else {
      if (document.activeElement === last) {
        e.preventDefault();
        first.focus();
      }
    }
  }

  function handleKeydown(e) {
    if (e.key === 'Escape') closePanel();
  }

  function openPanel() {
    lastFocused = document.activeElement;
    if (!panel) return;
    panel.style.display = 'flex';
    panel.setAttribute('aria-hidden', 'false');
    if (openBtn) openBtn.setAttribute('aria-expanded', 'true');
    const firstFocusable = focusableIn(panel)[0];
    if (firstFocusable) firstFocusable.focus();
    document.addEventListener('keydown', handleKeydown);
    document.addEventListener('keydown', trapFocus);
  }

  function closePanel() {
    if (!panel) return;
    panel.style.display = 'none';
    panel.setAttribute('aria-hidden', 'true');
    if (openBtn) openBtn.setAttribute('aria-expanded', 'false');
    if (lastFocused) lastFocused.focus();
    document.removeEventListener('keydown', handleKeydown);
    document.removeEventListener('keydown', trapFocus);
  }

  if (openBtn) {
    openBtn.addEventListener('click', () => {
      const isOpen = panel?.getAttribute('aria-hidden') === 'false';
      if (isOpen) closePanel();
      else openPanel();
    });
  }
  if (closeBtn) closeBtn.addEventListener('click', closePanel);

  document.addEventListener('click', (e) => {
    if (panel && !panel.contains(e.target) && openBtn && !openBtn.contains(e.target)) {
      if (panel.getAttribute('aria-hidden') === 'false') closePanel();
    }
  });

  // init
  if (panel) {
    panel.style.display = 'none';
    panel.setAttribute('aria-hidden', 'true');
  }
  updateLabels();
</script>

<script>
  const roleConfig = {
    publik: {
      title: 'Informasi & Pelaporan Publik',
      desc: 'Akses berita terbaru, informasi penting daerah, dan laporkan masalah publik secara cepat.',
      features: [{
          iconClass: 'bi bi-exclamation-circle',
          name: 'Dumas-Yu',
          subtitle: 'Segala bentuk pengaduan dari masyarakat',
        },
        {
          iconClass: 'bi bi-info-circle',
          name: 'Info-Yu',
          subtitle: 'Baca berita dan informasi terupdate yang ada di indramayu',
        },
      ],
      ctaText: 'Selengkapnya',
      smallDesc: 'dan banyak fitur bermanfaat lainnya..',
    },
    pelayanan: {
      title: 'Kesehatan & Pendidikan',
      desc: 'Cari fasilitas kesehatan, layanan darurat, dan informasi sekolah atau pelatihan terdekat.',
      features: [{
          iconClass: 'bi bi-hospital',
          name: 'Sehat-Yu',
          subtitle: 'Cari layanan kesehatan di sekitar kamu',
        },
        {
          iconClass: 'bi bi-book',
          name: 'Sekolah-Yu',
          subtitle: 'Informasi terkait pendaftaran dan lokasi sekolah',
        },
      ],
      ctaText: 'Selengkapnya',
      smallDesc: 'untuk kesehatan dan pendidikan terbaik.',
    },
    sosial: {
      title: 'Sosial & Ekonomi',
      desc: 'Temukan lowongan kerja, buat CV online, dan ikuti pelatihan pengembangan diri.',
      features: [{
          iconClass: 'bi bi-journal-medical',
          name: 'Pajak-Yu',
          subtitle: 'Informasi pengecekan pajak dan pembayarannya',
        },
        {
          iconClass: 'bi bi-cart',
          name: 'Pasar-Yu',
          subtitle: 'Informasi harga serta titik lokasi pajak',
        },
        {
          iconClass: 'bi bi-receipt',
          name: 'Kerja-Yu',
          subtitle: 'Informasi terkait lowongan pekerjaan',
        },
      ],
      ctaText: 'Selengkapnya',
      smallDesc: 'tingkatkan kompetensimu.',
    },
    pariwisata: {
      title: 'Pariwisata & Keagamaan',
      desc: 'Jelajahi destinasi wisata, temukan agenda keagamaan, dan promosi usaha lokal.',
      features: [{
          iconClass: 'bi bi-geo-alt',
          name: 'Plesir-Yu',
          subtitle: 'Rekomendasi tempat wisata menarik',
        },
        {
          iconClass: 'bi bi-house',
          name: 'Ibadah-Yu',
          subtitle: 'Informasi kegiatan keagamaan terdekat',
        },
      ],
      ctaText: 'Selengkapnya',
      smallDesc: 'dan rencanakan kunjunganmu.',
    },
    lainnya: {
      title: 'Layanan Publik Lainnya',
      desc: 'Kelola keuangan, belanja kebutuhan harian, dan akses layanan umum lainnya.',
      features: [{
          iconClass: 'bi bi-card-list',
          name: 'Adminduk-Yu',
          subtitle: 'Informasi pembuatan KTP elektronik dan lainnya',
        },
        {
          iconClass: 'bi bi-building',
          name: 'Renbang-Yu',
          subtitle: 'informasi terkait rencana pembangunan',
        },
        {
          iconClass: 'bi bi-shield-check',
          name: 'Izin-Yu',
          subtitle: 'informasi terkait rencana pembangunan',
        },
        {
          iconClass: 'bi bi-wifi',
          name: 'Wifi-Yu',
          subtitle: 'informasi terkait rencana pembangunan',
        },
      ],
      ctaText: 'Selengkapnya',
      smallDesc: 'semua kebutuhanmu dalam satu tempat.',
    },
  };

  function renderHeroCard(role) {
    const config = roleConfig[role];
    if (!config) return;

    const titleEl = document.querySelector('.hero-card-custom h2');
    const descEl = document.querySelector('.hero-card-custom .hero-right p');
    const featureList = document.querySelector('.feature-list-custom');
    const cta = document.querySelector('.btn-hero-cta');
    const smallDesc = document.querySelector('.small-desc');

    // set title/desc
    if (titleEl) titleEl.textContent = config.title;
    if (descEl) descEl.textContent = config.desc;

    // clear & populate features
    if (featureList) {
      featureList.innerHTML = '';
      config.features.forEach(f => {
        const item = document.createElement('div');
        item.className = 'feature-item-custom';
        item.innerHTML = `
          <div class="icon-wrapper">
            <i class="${f.iconClass}" aria-hidden="true" style="font-size:1.2rem;"></i>
          </div>
          <div>
            <div style="font-weight:600;">${f.name}</div>
            <div style="font-size:.75rem; opacity:.9;">${f.subtitle}</div>
          </div>
        `;
        featureList.appendChild(item);
      });
    }

    if (cta) cta.textContent = config.ctaText;
    if (smallDesc) smallDesc.textContent = config.smallDesc;
  }

  // Inisialisasi awal (role default "publik")
  renderHeroCard('publik');

  // Event listener tab
  document.querySelectorAll('.role-tabs .tab').forEach(btn => {
    btn.addEventListener('click', () => {
      // visual active
      document.querySelectorAll('.role-tabs .tab').forEach(t => {
        t.classList.remove('active');
        t.setAttribute('aria-selected', 'false');
      });
      btn.classList.add('active');
      btn.setAttribute('aria-selected', 'true');

      const role = btn.dataset.role;
      renderHeroCard(role);
    });
  });
</script>

<script>
  document.querySelectorAll('.faq-question').forEach(function(question) {
    question.addEventListener('click', function() {
      const answer = this.nextElementSibling;

      // Toggle tampilan jawaban
      if (answer.style.display === 'none' || answer.style.display === '') {
        answer.style.display = 'block';
      } else {
        answer.style.display = 'none';
      }
    });
  });
</script>

<script>
  function searchFAQ() {
    const keyword = document.getElementById('searchInput').value.toLowerCase();
    const items = document.querySelectorAll('.faq-item');

    items.forEach(item => {
      const questionText = item.querySelector('.faq-question').textContent.toLowerCase();
      if (questionText.includes(keyword)) {
        item.style.display = 'block';
      } else {
        item.style.display = 'none';
      }
    });
  }
</script>

</body>

</html>