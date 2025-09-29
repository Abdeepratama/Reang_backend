</div>
<footer id="footer" class="footer dark-background">

  <div class="container footer-top">
    <div class="row gy-4">
      <div class="col-lg-9 col-md-6 footer-about">
        <a href="index.html" class="logo d-flex align-items-center">
          <span class="sitename">Selesaikan urusanmu di Indramayu dengan Wong Reang Apps</span>
        </a>
        <div class="footer-contact pt-3">
          <p><strong>Ayo download Wong Reang Apps</strong></p>
          <p><strong>Email:</strong> <span>diskominfo@indramayukab.go.id</span></p>
        </div>
      </div>

      <div class="col-lg-3 col-md-3 footer-links">
        <h4>Link Terkait</h4>
        <ul>
          <li><a href="https://diskominfo.indramayukab.go.id">Diskominfo Kab. Indramayu</a></li>
          <li><a href="https://indramayukab.go.id">Website Indramayu</a></li>
          <li><a href="{{ route('admin.login') }}">Login</a></li>
        </ul>
      </div>



</footer>

<div class="accessibility-trigger" style="margin-left:10px;">
  <button id="open-a11y" class="a11y-toggle">♿</button>
</div>

<div id="a11y-panel" class="a11y-panel">
  <!-- Header -->
  <div class="a11y-header">
    <strong>Sarana</strong>
    <button id="close-a11y" class="a11y-close">✕</button>
  </div>

  <!-- Bahasa -->
  <div class="lang-switch">
    <button class="lang-btn active" data-lang="id">Indonesia</button>
    <button class="lang-btn" data-lang="en">Inggris</button>
  </div>

  <!-- Google Translate -->
  <div id="google_translate_element" style="display:none"></div>

  <!-- Menu -->
  <ul class="a11y-menu">
    <li><button class="btn" data-key="Moda Suara">🗣️ Moda Suara</button></li>
    <li><button class="btn" data-key="Perbesar Teks" data-action="increase-text">🔍 Perbesar Teks</button></li>
    <li><button class="btn" data-key="Perkecil Teks" data-action="decrease-text">🔎 Perkecil Teks</button></li>
    <li><button class="btn" data-key="Skala Abu - Abu" data-toggle="grayscale">📊 Skala Abu - Abu</button></li>
    <li><button class="btn" data-key="Kontras Tinggi" data-toggle="high-contrast">👁️ Kontras Tinggi</button></li>
    <li><button class="btn" data-key="Latar Gelap" data-toggle="dark-mode">🌙 Latar Gelap</button></li>
    <li><button class="btn" data-key="Latar Terang" data-toggle="light-mode">☀️ Latar Terang</button></li>
    <li><button class="btn" data-key="Tulisan Dapat Dibaca" data-toggle="readable-font">📖 Tulisan Dapat Dibaca</button></li>
    <li><button class="btn" data-key="Garis Bawah Tautan" data-toggle="underline-links">🔗 Garis Bawah Tautan</button></li>
    <li><button class="btn" data-key="Rata Tulisan" data-toggle="spacing-wide">📑 Rata Tulisan</button></li>
  </ul>

  <!-- Footer -->
  <div class="a11y-footer mt-4">
    <button class="btn reset-btn" data-key="Atur Ulang" id="resetBtn">Atur Ulang</button>
  </div>
</div>

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
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>


<!-- Main JS File -->
<script src="{{ asset('landing/js/main.js')}} "></script>

<!-- <div style="margin-top:6px; display:flex; align-items:center; gap:6px;">
  <input type="checkbox" id="autoSpeakSelection" />
  <label for="autoSpeakSelection" style="font-size:12px;">Baca saat blok</label>
</div> -->

<script>
  const openBtn = document.getElementById("open-a11y");
  const closeBtn = document.getElementById("close-a11y");
  const panel = document.getElementById("a11y-panel");

  // Klik tombol toggle
  openBtn.addEventListener("click", () => {
    panel.classList.toggle("active");
    openBtn.classList.toggle("active");
  });

  // Klik tombol close (X)
  closeBtn.addEventListener("click", () => {
    panel.classList.remove("active");
    openBtn.classList.remove("active");
  });

  // Klik bebas di luar panel
  document.addEventListener("click", (e) => {
    if (
      !panel.contains(e.target) &&
      !openBtn.contains(e.target)
    ) {
      panel.classList.remove("active");
      openBtn.classList.remove("active");
    }
  });

  // ================== STATE ==================
  const synth = window.speechSynthesis;
  let utterance = null;
  let isPaused = false;
  let isSpeaking = false;
  let hoverReadingEnabled = false;
  let lastFocused = null;
  let lastWordSpoken = null;
  let currentLang = localStorage.getItem("selectedLang") || "id";
  let stopAllReading = true; // hentikan semua mode suara
  let throttleTimeout = null;

  // ================== ELEMENTS ==================
  const panelTitle = document.getElementById('panel-title');
  const voiceLabel = document.getElementById('voice-label');
  const rateInput = document.getElementById('voice-rate');
  const rateVal = document.getElementById('rateVal');
  const startBtn = document.getElementById('startVoice');
  const pauseBtn = document.getElementById('pauseVoice');
  const stopBtn = document.getElementById('stopVoice');
  const resetBtn = document.getElementById('resetBtn');
  const autoSpeakCheckbox = document.getElementById('autoSpeakSelection');
  const voiceBtnMain = document.querySelector('[data-key="Moda Suara"]');

  // ================== VOICE LIST ==================
  let voices = [];

  function loadVoices() {
    voices = synth.getVoices();
  }
  synth.onvoiceschanged = loadVoices;
  loadVoices();

  function getPreferredVoice() {
    if (currentLang === 'en') return voices.find(v => /en[-_]?/i.test(v.lang)) || null;
    return voices.find(v => /id[-_]?/i.test(v.lang)) || null;
  }

  // ================== TRANSLATION ==================
  function t(key) {
    const dict = {
      id: {
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
        'Sarana': 'Sarana',
        'Baca': 'Baca',
        'Jeda': 'Jeda',
        'Hentikan': 'Hentikan'
      },
      en: {
        'Moda Suara': 'Voice Mode',
        'Perbesar Teks': 'Increase Text',
        'Perkecil Teks': 'Decrease Text',
        'Skala Abu - Abu': 'Grayscale',
        'Kontras Tinggi': 'High Contrast',
        'Latar Gelap': 'Dark Mode',
        'Latar Terang': 'Light Mode',
        'Tulisan Dapat Dibaca': 'Readable Font',
        'Garis Bawah Tautan': 'Underline Links',
        'Rata Tulisan': 'Text Spacing',
        'Atur Ulang': 'Reset',
        'Sarana': 'Accessibility',
        'Baca': 'Read',
        'Jeda': 'Pause',
        'Hentikan': 'Stop'
      }
    };
    return dict[currentLang]?.[key] || key;
  }

  // ================== UPDATE LABELS ==================
  function updateLabels() {
    if (panelTitle) panelTitle.textContent = t('Sarana');
    if (voiceLabel) voiceLabel.textContent = t('Moda Suara');
    if (startBtn) startBtn.textContent = '▶️ ' + t('Baca');
    if (pauseBtn) pauseBtn.textContent = '⏸️ ' + t('Jeda');
    if (stopBtn) stopBtn.textContent = '⏹️ ' + t('Hentikan');
    if (resetBtn) resetBtn.textContent = t('Atur Ulang');
    document.querySelectorAll("[data-key]").forEach(el => {
      const key = el.getAttribute("data-key");
      const emoji = (el.textContent.match(/^[^ ]+ /) || "")[0];
      el.textContent = emoji + t(key);
    });
    localStorage.setItem("selectedLang", currentLang);
  }

  // ================== TEXT SCALING ==================
  let textScale = 1;
  const incText = document.querySelector('[data-action="increase-text"]');
  const decText = document.querySelector('[data-action="decrease-text"]');
  if (incText) incText.addEventListener('click', () => {
    textScale = Math.min(2, textScale + 0.1);
    document.documentElement.style.setProperty('--text-scale', textScale);
  });
  if (decText) decText.addEventListener('click', () => {
    textScale = Math.max(0.5, textScale - 0.1);
    document.documentElement.style.setProperty('--text-scale', textScale);
  });

  // ================== TOGGLES ==================
  document.querySelectorAll('[data-toggle]').forEach(btn => {
    btn.addEventListener('click', () => {
      const toggle = btn.getAttribute('data-toggle');
      switch (toggle) {
        case 'grayscale':
          document.body.classList.toggle('grayscale');
          break;
        case 'high-contrast':
          if (document.body.getAttribute('data-contrast') === 'high') document.body.removeAttribute('data-contrast');
          else document.body.setAttribute('data-contrast', 'high');
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

  // ================== RESET ==================
  if (resetBtn) {
    resetBtn.addEventListener('click', () => {
      textScale = 1;
      document.body.style.fontSize = '';
      document.body.classList.remove('grayscale', 'readable-font', 'underline-links', 'spacing-wide');
      document.body.removeAttribute('data-theme');
      document.body.removeAttribute('data-contrast');
    });
  }

  // ================== GET TEXT ==================
  function getTextForReading() {
    const main = document.querySelector('main');
    return main ? main.innerText : document.body.innerText;
  }

  // ================== SPEAK TEXT ==================
  function speakText(text) {
    if (!synth || !text || !text.trim() || stopAllReading) return;
    synth.cancel();
    utterance = new SpeechSynthesisUtterance(text.trim());
    utterance.rate = rateInput ? parseFloat(rateInput.value) : 1;
    utterance.lang = currentLang === 'en' ? 'en-US' : 'id-ID';
    const preferred = getPreferredVoice();
    if (preferred) utterance.voice = preferred;
    utterance.onend = () => {
      isSpeaking = false;
      hoverReadingEnabled = true;
      lastWordSpoken = null;
      stopAllReading = false;
      if (voiceBtnMain) voiceBtnMain.textContent = '🗣️ ' + t('Baca');
    };
    synth.speak(utterance);
    isSpeaking = true;
  }

  // ================== BUTTONS CONTROL ==================
  if (startBtn) startBtn.addEventListener('click', () => {
    hoverReadingEnabled = true;
    stopAllReading = false;
    speakText(getTextForReading());
  });

  if (pauseBtn) pauseBtn.addEventListener('click', () => {
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

  if (stopBtn) stopBtn.addEventListener('click', () => {
    if (!synth) return;
    stopAllReading = true;
    synth.cancel();
    isPaused = false;
    isSpeaking = false;
    hoverReadingEnabled = false;
    lastWordSpoken = null;
    if (voiceBtnMain) voiceBtnMain.textContent = '🗣️ ' + t('Baca');
  });

  // ================== AUTO SPEAK SELECTION ==================
  document.addEventListener('mouseup', () => {
    if (stopAllReading) return;
    const sel = window.getSelection().toString().trim();
    if (sel && autoSpeakCheckbox && autoSpeakCheckbox.checked) {
      synth.cancel();
      hoverReadingEnabled = false;
      lastWordSpoken = null;
      speakText(sel);
    } else {
      hoverReadingEnabled = true;
    }
  });

  // ================== MODA SUARA TOGGLE ==================
  if (voiceBtnMain) {
    voiceBtnMain.addEventListener('click', () => {
      if (isSpeaking) {
        stopAllReading = true;
        synth.cancel();
        isSpeaking = false;
        hoverReadingEnabled = false;
        lastWordSpoken = null;
        voiceBtnMain.textContent = '🗣️ ' + t('Baca');
      } else {
        hoverReadingEnabled = true;
        stopAllReading = false;
        speakText(getTextForReading());
        voiceBtnMain.textContent = '⏹️ ' + t('Hentikan');
      }
    });
  }

  // ================== HOVER KATA DI BAWAH KURSOR ==================
  document.addEventListener('mousemove', (e) => {
    if (!hoverReadingEnabled || stopAllReading) return;
    if (throttleTimeout) return;
    throttleTimeout = setTimeout(() => {
      throttleTimeout = null;
      const selection = window.getSelection().toString().trim();
      if (selection) return;
      const word = getWordUnderCursor(e);
      if (word && word !== lastWordSpoken) {
        lastWordSpoken = word;
        speakText(word);
      }
    }, 300);
  });

  function getWordUnderCursor(e) {
    let range;
    if (document.caretRangeFromPoint) range = document.caretRangeFromPoint(e.clientX, e.clientY);
    else if (document.caretPositionFromPoint) range = document.caretPositionFromPoint(e.clientX, e.clientY).offsetNode;
    else return null;
    if (!range) return null;
    const node = range.startContainer || range.offsetNode;
    if (!node || node.nodeType !== 3) return null;
    const text = node.textContent;
    const offset = range.startOffset || range.offset;
    if (!text) return null;
    const left = text.slice(0, offset).search(/\S+$/);
    const rightMatch = text.slice(offset).match(/^\S+/);
    const right = rightMatch ? rightMatch[0].length : 0;
    return text.slice(left, offset + right);
  }

  // ================== PANEL CONTROL ==================
  function focusableIn(el) {
    return el ? Array.from(el.querySelectorAll('button,[href],input,[tabindex]:not([tabindex="-1"])')).filter(e => !e.disabled) : [];
  }

  function trapFocus(e) {
    if (e.key !== 'Tab' || !panel) return;
    const f = focusableIn(panel);
    if (!f.length) return;
    const first = f[0],
      last = f[f.length - 1];
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
  if (openBtn) openBtn.addEventListener('click', () => {
    panel.getAttribute('aria-hidden') === 'false' ? closePanel() : openPanel();
  });
  if (closeBtn) closeBtn.addEventListener('click', closePanel);
  document.addEventListener('click', (e) => {
    if (panel && !panel.contains(e.target) && openBtn && !openBtn.contains(e.target)) closePanel();
  });
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
  function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'id',
        includedLanguages: 'en,id',
        autoDisplay: false
      },
      'google_translate_element'
    );
  }

  document.addEventListener("DOMContentLoaded", () => {
    const body = document.body;
    let textScale = 1;

    // === BAHASA ===
    const buttons = document.querySelectorAll(".lang-btn");
    buttons.forEach(btn => {
      btn.addEventListener("click", () => {
        // ubah status tombol
        buttons.forEach(b => b.classList.remove("active"));
        btn.classList.add("active");

        // ambil bahasa
        const lang = btn.getAttribute("data-lang");
        const select = document.querySelector(".goog-te-combo");
        if (select) {
          select.value = lang;
          select.dispatchEvent(new Event("change"));
        }

        // simpan ke localStorage biar konsisten
        localStorage.setItem("selectedLang", lang);
      });
    });
  });

  // Paksa hilangin banner setiap kali Google translate refresh
  function hideGoogleTranslateElements() {
    const frame = document.querySelector(".goog-te-banner-frame");
    if (frame) frame.style.display = "none";
    document.body.style.top = "0px";
  }

  document.addEventListener("DOMNodeInserted", function(event) {
    if (event.target.className === "goog-te-banner-frame skiptranslate") {
      hideGoogleTranslateElements();
    }
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