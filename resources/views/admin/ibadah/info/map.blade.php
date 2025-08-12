<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Peta Info Keagamaan</title>

  <!-- Leaflet CSS & JS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
    }
    #mapContainer {
      display: flex;
      height: 100vh;
      width: 100%;
    }
    #overlay {
      width: 400px;
      background: white;
      padding: 20px;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
      overflow-y: auto;
    }
    #overlay input[type="text"] {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .result-item {
      padding: 10px;
      margin-bottom: 8px;
      border-bottom: 1px solid #eee;
      cursor: pointer;
    }
    .result-item:hover {
      background: #f2f2f2;
    }
    #peta {
      flex-grow: 1;
      height: 100%;
    }
    img.foto-keagamaan {
      width: 100%;
      max-height: 150px;
      object-fit: cover;
      margin-top: 5px;
      border-radius: 6px;
    }
  </style>
</head>

<body>
  <div id="mapContainer">
    <div id="overlay">
      <h3>🕌 Cari Info Keagamaan</h3>
      <input type="text" id="searchInput" placeholder="Cari judul atau alamat..." />
      <div id="resultList"></div>
    </div>

    <div id="peta"></div>
  </div>

  <script>
    // Data lokasi dari Laravel (dari controller)
    const lokasi = @json($lokasi);

    // Inisialisasi peta
    const map = L.map('peta').setView([-6.3265, 108.3202], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    const resultList = document.getElementById('resultList');
    const searchInput = document.getElementById('searchInput');

    // Ikon sesuai jenis kegiatan keagamaan
    const fiturIcons = {
      masjid: '🕌',
      gereja: '⛪',
      pura: '🏯',
      vihara: '🛕',
      perayaan: '🎉',
      default: '📍'
    };

    function getIcon(fitur) {
      if (!fitur) return defaultIcon;
      const key = fitur.toLowerCase();
      for (const k in fiturIcons) {
        if (key.includes(k)) {
          return L.divIcon({
            html: `<div style="font-size:28px;">${fiturIcons[k]}</div>`,
            className: '',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
          });
        }
      }
      return defaultIcon;
    }

    const defaultIcon = L.divIcon({
      html: `<div style="font-size:28px;">📍</div>`,
      className: '',
      iconSize: [32, 32],
      iconAnchor: [16, 32],
      popupAnchor: [0, -32]
    });

    let allMarkers = [];
    let tempMarker = null;

    function clearMarkers() {
      allMarkers.forEach(obj => map.removeLayer(obj.marker));
      allMarkers = [];
    }

    function renderMarkers(data) {
      clearMarkers();
      data.forEach(loc => {
        if (!loc.latitude || !loc.longitude) return;

        const lat = parseFloat(loc.latitude);
        const lng = parseFloat(loc.longitude);
        if (isNaN(lat) || isNaN(lng)) return;

        const icon = getIcon(loc.fitur);
        const marker = L.marker([lat, lng], { icon }).addTo(map);

        let popupContent = `<strong>${loc.judul}</strong><br/>`;
        popupContent += loc.alamat ? `<em>${loc.alamat}</em><br/>` : '';
        popupContent += loc.tanggal ? `📅 ${loc.tanggal} ${loc.waktu ? `⏰ ${loc.waktu}` : ''}<br/>` : '';
        popupContent += loc.deskripsi ? `<p>${loc.deskripsi}</p>` : '';
        popupContent += loc.foto ? `<img src="${loc.foto}" alt="Foto kegiatan" class="foto-keagamaan" onerror="this.src='/images/placeholder.png'">` : '';

        marker.bindPopup(popupContent);

        allMarkers.push({ marker, data: loc });
      });
    }

    function debounce(fn, delay) {
      let timer;
      return function (...args) {
        clearTimeout(timer);
        timer = setTimeout(() => fn(...args), delay);
      };
    }

    function filterLokasi(keyword) {
      if (!keyword) return lokasi;

      const lower = keyword.toLowerCase();
      return lokasi.filter(loc => {
        return (
          (loc.judul && loc.judul.toLowerCase().includes(lower)) ||
          (loc.alamat && loc.alamat.toLowerCase().includes(lower)) ||
          (loc.fitur && loc.fitur.toLowerCase().includes(lower))
        );
      });
    }

    function renderResultList(data) {
      resultList.innerHTML = '';
      data.forEach(loc => {
        const div = document.createElement('div');
        div.className = 'result-item';
        div.innerHTML = `<strong>${loc.judul}</strong><br/><small>${loc.alamat || ''}</small>`;
        div.onclick = () => {
          const lat = parseFloat(loc.latitude);
          const lng = parseFloat(loc.longitude);
          if (isNaN(lat) || isNaN(lng)) return;

          map.setView([lat, lng], 16);
          if (tempMarker) map.removeLayer(tempMarker);
          tempMarker = L.marker([lat, lng], { icon: getIcon(loc.fitur) }).addTo(map);
          tempMarker.bindPopup(`<b>${loc.judul}</b><br/>${loc.alamat || ''}`).openPopup();

          setTimeout(() => {
            if (tempMarker) {
              map.removeLayer(tempMarker);
              tempMarker = null;
            }
          }, 5000);
        };
        resultList.appendChild(div);
      });
    }

    // Event handler input pencarian
    searchInput.addEventListener(
      'input',
      debounce(() => {
        const keyword = searchInput.value.trim();
        const filtered = filterLokasi(keyword);
        renderMarkers(filtered);
        renderResultList(filtered);
      }, 300)
    );

    // Render awal
    renderMarkers(lokasi);
    renderResultList(lokasi);
  </script>
</body>
</html>
