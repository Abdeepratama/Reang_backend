<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Peta Interaktif</title>

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        html,
        body {
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
            /* Lebih besar dari sebelumnya */
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
    </style>
</head>

<body>
    <div id="mapContainer">
        <!-- Sidebar Pencarian -->
        <div id="overlay">
            <input type="text" id="searchInput" placeholder="Cari tempat...">
            <div id="resultList"></div>
        </div>

        <!-- Peta -->
        <div id="peta"></div>
    </div>

    <script>
  // debounce helper
  function debounce(fn, delay) {
    let t;
    return (...args) => {
      clearTimeout(t);
      t = setTimeout(() => fn(...args), delay);
    };
  }

  const map = L.map('peta').setView([-6.326511, 108.3202685], 14);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  const lokasi = @json($lokasi);
  console.log('lokasi (database):', lokasi);

  const resultList = document.getElementById('resultList');
  const searchInput = document.getElementById('searchInput');

  // ikon berdasarkan fitur / agama
  const iconMap = {
    islam: L.divIcon({
      html: `<div style="font-size:28px; line-height:1;">🕌</div>`,
      className: '',
      iconSize: [32, 32],
      iconAnchor: [16, 32],
      popupAnchor: [0, -32]
    }),
    kristen: L.divIcon({
      html: `<div style="font-size:28px; line-height:1;">⛪</div>`,
      className: '',
      iconSize: [32, 32],
      iconAnchor: [16, 32],
      popupAnchor: [0, -32]
    }),
    hindu: L.divIcon({
      html: `<div style="font-size:28px; line-height:1;">🛕</div>`,
      className: '',
      iconSize: [32, 32],
      iconAnchor: [16, 32],
      popupAnchor: [0, -32]
    }),
    buddhis: L.divIcon({
      html: `<div style="font-size:28px; line-height:1;">🕍</div>`,
      className: '',
      iconSize: [32, 32],
      iconAnchor: [16, 32],
      popupAnchor: [0, -32]
    }),
    defaultHouse: L.divIcon({
      html: `
        <div style="transform: scale(1.5); transform-origin: center;">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="32" height="32" fill="#2A9D8F" stroke="white" stroke-width="2">
            <path d="M32 12 L12 32 H20 V52 H44 V32 H52 Z"/>
            <circle cx="32" cy="40" r="4" fill="white"/>
          </svg>
        </div>`,
      className: '',
      iconSize: [48, 48],
      iconAnchor: [24, 48],
      popupAnchor: [0, -48]
    })
  };

  function getIconByFitur(fitur) {
    if (!fitur) return iconMap.defaultHouse;
    const key = fitur.toString().toLowerCase();
    if (key.includes('islam') || key.includes('masjid') || key.includes('muslim')) return iconMap.islam;
    if (key.includes('kristen') || key.includes('gereja') || key.includes('katolik')) return iconMap.kristen;
    if (key.includes('hindu') || key.includes('pura')) return iconMap.hindu;
    if (key.includes('buddh') || key.includes('vihara')) return iconMap.buddhis;
    return iconMap.defaultHouse;
  }

  // ikon untuk hasil eksternal
  const externalIcon = L.divIcon({
    html: `<div style="font-size:24px; line-height:1;">📍</div>`,
    className: '',
    iconSize: [32, 32],
    iconAnchor: [16, 32],
    popupAnchor: [0, -32]
  });

  let allMarkers = [];
  let tempMarker = null;

  // pencarian eksternal via Nominatim
  async function cariEksternal(keyword) {
    if (!keyword || keyword.trim().length < 3) return [];
    const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(keyword)}&limit=8&addressdetails=1`;
    try {
      const res = await fetch(url, {
        headers: { 'Accept-Language': 'id' }
      });
      if (!res.ok) return [];
      const data = await res.json();
      return data.map(d => {
        const name = d.display_name.split(',')[0];
        const address = d.display_name;
        return {
          name,
          address,
          latitude: d.lat,
          longitude: d.lon,
          eksternal: true
        };
      });
    } catch (e) {
      console.warn('gagal cari eksternal', e);
      return [];
    }
  }

  // jarak haversine sederhana (meter)
  function distanceMeters(lat1, lon1, lat2, lon2) {
    const toRad = x => x * Math.PI / 180;
    const R = 6371000;
    const dLat = toRad(lat2 - lat1);
    const dLon = toRad(lon2 - lon1);
    const a = Math.sin(dLat / 2) ** 2 +
              Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
              Math.sin(dLon / 2) ** 2;
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c;
  }

  async function tampilkanHasil(keyword) {
    resultList.innerHTML = '';

    // 1. filter dari database
    const dbFiltered = lokasi.filter(loc =>
      loc.name.toLowerCase().includes(keyword.toLowerCase()) ||
      (loc.address && loc.address.toLowerCase().includes(keyword.toLowerCase()))
    ).map(loc => ({ ...loc, eksternal: false }));

    // 2. cari eksternal
    const eksternalRaw = await cariEksternal(keyword);

    // 3. deduplikasi
    const eksternal = eksternalRaw.filter(ext => {
      return !dbFiltered.some(db => {
        if (db.name.toLowerCase() === ext.name.toLowerCase()) return true;
        const dist = distanceMeters(
          parseFloat(db.latitude),
          parseFloat(db.longitude),
          parseFloat(ext.latitude),
          parseFloat(ext.longitude)
        );
        return dist < 30;
      });
    });

    // gabung (database dulu)
    const merged = [...dbFiltered, ...eksternal];

    // bersihkan marker lama
    allMarkers.forEach(obj => map.removeLayer(obj.marker));
    allMarkers = [];

    // tambah marker dari database (dengan ikon berdasarkan fitur)
    dbFiltered.forEach(loc => {
      const icon = getIconByFitur(loc.fitur);
      const marker = L.marker([loc.latitude, loc.longitude], { icon }).addTo(map);
      marker.bindPopup(`
        <strong>${loc.name}</strong><br>
        ${loc.address ? `<em>${loc.address}</em><br>` : ''}
        ${loc.foto ? `<img src="${loc.foto}" width="100%" onerror="this.onerror=null; this.src='/images/placeholder.png';" alt="gambar tidak tersedia">` : ''}
      `);
      allMarkers.push({ marker, data: loc });
    });

    // tambah marker eksternal
    eksternal.forEach(loc => {
      const marker = L.marker([loc.latitude, loc.longitude], { icon: externalIcon }).addTo(map);
      marker.bindPopup(`
        <strong>${loc.name}</strong><br>
        ${loc.address ? `<em>${loc.address}</em><br>` : ''}
        <small>(hasil pencarian umum)</small>
      `);
      allMarkers.push({ marker, data: loc });
    });

    // bangun daftar hasil (db dulu)
    merged.forEach(loc => {
      const item = document.createElement('div');
      item.className = 'result-item';
      item.innerHTML = `<strong>${loc.name}</strong><br><small>${loc.address || ''}</small>` + (loc.eksternal ? ' <em>(lainnya)</em>' : '');
      item.onclick = () => {
        const lat = parseFloat(loc.latitude);
        const lng = parseFloat(loc.longitude);
        map.setView([lat, lng], 17);

        if (tempMarker) map.removeLayer(tempMarker);
        const icon = loc.eksternal ? externalIcon : getIconByFitur(loc.fitur);
        tempMarker = L.marker([lat, lng], { icon }).addTo(map);
        tempMarker.bindPopup(`<b>${loc.name}</b><br>${loc.address || ''}` + (loc.eksternal ? ' <em>(lainnya)</em>' : '')).openPopup();

        setTimeout(() => {
          if (tempMarker) {
            map.removeLayer(tempMarker);
            tempMarker = null;
          }
        }, 5000);
      };
      resultList.appendChild(item);
    });
  }

  // inisialisasi awal
  tampilkanHasil('');

  // input dengan debounce
  searchInput.addEventListener('input', debounce(() => {
    tampilkanHasil(searchInput.value.trim());
  }, 300));
</script>

</body>

</html>