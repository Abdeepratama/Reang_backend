<!-- resources/views/admin/sehat/tempat-map.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Peta Fasilitas Kesehatan</title>

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        html, body { margin: 0; padding: 0; height: 100%; }
        #mapContainer { display: flex; height: 100vh; width: 100%; }
        #overlay { width: 400px; background: white; padding: 20px; box-shadow: 2px 0 10px rgba(0,0,0,0.2); overflow-y: auto; }
        #overlay input[type="text"] { width: 100%; padding: 10px; font-size: 16px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; }
        .result-item { padding: 10px; margin-bottom: 8px; border-bottom: 1px solid #eee; cursor: pointer; }
        .result-item:hover { background: #f2f2f2; }
        #peta { flex-grow: 1; height: 100%; }
    </style>
</head>
<body>
<div id="mapContainer">
    <div id="overlay">
        <input type="text" id="searchInput" placeholder="Cari fasilitas kesehatan...">
        <div id="resultList"></div>
    </div>
    <div id="peta"></div>
</div>

<script>
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

  const resultList = document.getElementById('resultList');
  const searchInput = document.getElementById('searchInput');

  const iconMap = {
    sehat: L.divIcon({
      html: `<div style="font-size:28px; line-height:1;">🏥</div>`,
      className: '',
      iconSize: [32, 32],
      iconAnchor: [16, 32],
      popupAnchor: [0, -32]
    }),
    default: L.divIcon({
      html: `<div style="font-size:28px;">📍</div>`,
      className: '',
      iconSize: [32, 32],
      iconAnchor: [16, 32],
      popupAnchor: [0, -32]
    })
  };

  function getIconByFitur(fitur) {
    if (!fitur) return iconMap.default;
    const key = fitur.toString().toLowerCase();
    if (key.includes('rumah sakit') || key.includes('puskesmas') || key.includes('klinik') || key.includes('apotek')) {
      return iconMap.sehat;
    }
    return iconMap.default;
  }

  const externalIcon = L.divIcon({
    html: `<div style="font-size:24px; line-height:1;">📍</div>`,
    className: '',
    iconSize: [32, 32],
    iconAnchor: [16, 32],
    popupAnchor: [0, -32]
  });

  let allMarkers = [];
  let tempMarker = null;

  async function cariEksternal(keyword) {
    if (!keyword || keyword.trim().length < 3) return [];
    const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(keyword)}&limit=8&addressdetails=1`;
    try {
      const res = await fetch(url, { headers: { 'Accept-Language': 'id' } });
      if (!res.ok) return [];
      const data = await res.json();
      return data.map(d => {
        const name = d.display_name.split(',')[0];
        return {
          name,
          address: d.display_name,
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

    const dbFiltered = lokasi.filter(loc =>
      loc.name.toLowerCase().includes(keyword.toLowerCase()) ||
      (loc.address && loc.address.toLowerCase().includes(keyword.toLowerCase()))
    ).map(loc => ({ ...loc, eksternal: false }));

    const eksternalRaw = await cariEksternal(keyword);

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

    const merged = [...dbFiltered, ...eksternal];

    allMarkers.forEach(obj => map.removeLayer(obj.marker));
    allMarkers = [];

    dbFiltered.forEach(loc => {
      const icon = getIconByFitur(loc.fitur);
      const marker = L.marker([loc.latitude, loc.longitude], { icon }).addTo(map);
      marker.bindPopup(`
        <strong>${loc.name}</strong><br>
        ${loc.address ? `<em>${loc.address}</em><br>` : ''}
        ${loc.foto ? `
    <div style="text-align:center">
        <img src="${loc.foto}" width="50%" 
             onerror="this.onerror=null; this.src='/images/placeholder.png';">
    </div>
` : ''}
      `);
      allMarkers.push({ marker, data: loc });
    });

    eksternal.forEach(loc => {
      const marker = L.marker([loc.latitude, loc.longitude], { icon: externalIcon }).addTo(map);
      marker.bindPopup(`
        <strong>${loc.name}</strong><br>
        ${loc.address ? `<em>${loc.address}</em><br>` : ''}
        <small>(hasil pencarian umum)</small>
      `);
      allMarkers.push({ marker, data: loc });
    });

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

  tampilkanHasil('');

  searchInput.addEventListener('input', debounce(() => {
    tampilkanHasil(searchInput.value.trim());
  }, 300));
</script>

</body>
</html>
