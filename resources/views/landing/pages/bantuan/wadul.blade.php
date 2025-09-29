@extends('landing.partials.app')

@section('content')
<section id="wadul" class="faq-section">
  <div class="container">
    <h2 class="faq-title">Butuh Bantuan?</h2>

    <div class="search-bar">
      <input type="text" id="searchInput" placeholder="Cari kata kunci (contoh: cara membuat laporan)">
      <button type="button" onclick="searchFAQ()">Cari</button>
    </div>

    <div class="faq-box">
      <h3>Pertanyaan yang Sering Diajukan</h3>
      <ul class="faq-list" id="faqList">
        <li class="faq-item">
          <a href="javascript:void(0);" class="faq-question">Apa itu Reang? <span>&gt;</span></a>
          <div class="faq-answer" style="display: none;">
            Reang adalah platform layanan publik digital yang dikembangkan untuk memudahkan masyarakat dalam mengakses informasi, membuat laporan, serta berinteraksi langsung dengan instansi terkait secara cepat dan transparan.
          </div>
        </li>
        <li class="faq-item">
          <a href="javascript:void(0);" class="faq-question">Bagaimana cara membuat pengaduan? <span>&gt;</span></a>
          <div class="faq-answer" style="display: none;">
            Untuk membuat laporan, buka aplikasi Reang, pilih menu “Pengaduan”, lengkapi formulir dengan informasi yang diminta (jenis pengaduan, deskripsi, lokasi, dan bukti), lalu klik “Kirim”. Laporan Anda akan segera diproses oleh pihak yang berwenang.
          </div>
        </li>
        <li class="faq-item">
          <a href="javascript:void(0);" class="faq-question">Bagaimana cara memantau progres pengaduan? <span>&gt;</span></a>
          <div class="faq-answer" style="display: none;">
            Setelah laporan dikirim, Anda dapat memantau statusnya melalui menu “Riwayat Pengaduan”. Di sana akan ditampilkan status pengaduan: sedang diproses, ditindaklanjuti, selesai, atau ditolak, lengkap dengan catatan dari petugas.
          </div>
        </li>
        <li class="faq-item">
          <a href="javascript:void(0);" class="faq-question">Apakah identitas saya sebagai pelapor aman? <span>&gt;</span></a>
          <div class="faq-answer" style="display: none;">
            Ya. Identitas pelapor akan dirahasiakan dan hanya digunakan untuk keperluan verifikasi internal. Kami berkomitmen menjaga privasi pengguna sesuai kebijakan perlindungan data.
          </div>
        </li>
        <li class="faq-item">
          <a href="javascript:void(0);" class="faq-question">Mengapa laporan saya ditolak? <span>&gt;</span></a>
          <div class="faq-answer" style="display: none;">
            Laporan dapat ditolak jika tidak memenuhi kriteria seperti: informasi tidak lengkap, bukti tidak valid, bukan wewenang instansi terkait, atau tidak sesuai dengan ketentuan layanan. Anda dapat melihat alasan penolakan secara detail di riwayat laporan.
          </div>
        </li>
      </ul>
    </div>

  </div>
</section>
@endsection