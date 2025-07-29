<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Peta Interaktif</title>

  <style>
    #peta {
      height: 600px;
      width: 100%;
      margin-top: 10px;
    }

    .leaflet-control-geosearch {
      z-index: 1000;
    }

    .search-controls {
      margin-bottom: 10px;
    }

    input[type="text"] {
      padding: 6px;
      margin-right: 5px;
    }

    button {
      padding: 6px 10px;
    }

    .form-simpan {
      margin-top: 10px;
    }
  </style>

  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body>

  <div class="container">
    <h3>Peta Interaktif</h3>
    <p>Klik peta untuk mengambil koordinat dan alamat</p>

    <!-- Input pencarian alamat -->
    <div class="search-controls">
      <input type="text" id="searchText" placeholder="Cari alamat atau nama tempat" style="width: 60%;">
      <button onclick="searchLocation()">Cari Lokasi</button>
    </div>

    <!-- Input manual koordinat -->
    <div class="search-controls">
      <input type="text" id="latitude" placeholder="Latitude">
      <input type="text" id="longitude" placeholder="Longitude">
      <button onclick="goToLatLng()">Cari Koordinat</button>
    </div>

    <!-- Alamat hasil klik -->
    <div class="search-controls">
      <input type="text" id="alamat" placeholder="Alamat hasil klik / pencarian" style="width: 60%;" readonly>
    </div>

    <div id="peta"></div>
  </div>

  <script>
    const map = L.map('peta').setView([-6.326511, 108.3202685], 13);
    let clickMarker = null;

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '© OpenStreetMap'
    }).addTo(map);

    const locations = [
      {
        nama: "Masjid Agung Indramayu",
        alamat: "Jl. Mayor Jendera Sutoyo, Indramayu",
        foto: "https://upload.wikimedia.org/wikipedia/commons/thumb/7/7c/Masjid_Agung_Indramayu.jpg/320px-Masjid_Agung_Indramayu.jpg",
        latitude: -6.3271,
        longitude: 108.3287
      },
      {
        nama: "Masjid Al-Falah",
        alamat: "Jl. Veteran No. 10, Indramayu",
        foto: "https://via.placeholder.com/300x150.png?text=Masjid+Al-Falah",
        latitude: -6.3290,
        longitude: 108.3230
      },
      {
        nama: "Gereja Santa Maria",
        alamat: "Jl. Gereja No. 5, Indramayu",
        foto: "https://via.placeholder.com/300x150.png?text=Gereja+Santa+Maria",
        latitude: -6.3255,
        longitude: 108.3305
      },
      {
        nama: "Vihara Dharma",
        alamat: "Jl. Bhakti No. 1, Indramayu",
        foto: "https://via.placeholder.com/300x150.png?text=Vihara+Dharma",
        latitude: -6.3280,
        longitude: 108.3201
      }
    ];

    locations.forEach(loc => {
      const marker = L.marker([loc.latitude, loc.longitude]).addTo(map);
      marker.bindPopup(`
        <strong>${loc.nama}</strong><br>
        <em>${loc.alamat}</em><br>
        <img src="${loc.foto}" width="100%" alt="${loc.nama}">
      `);
    });

    map.on('click', async function (e) {
      const lat = e.latlng.lat.toFixed(6);
      const lng = e.latlng.lng.toFixed(6);
      document.getElementById('latitude').value = lat;
      document.getElementById('longitude').value = lng;

      let alamat = 'Alamat tidak ditemukan';
      try {
        const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
        const data = await res.json();
        alamat = data.display_name || alamat;
      } catch (err) {
        console.error('Gagal ambil alamat:', err);
      }

      document.getElementById('alamat').value = alamat;

      if (clickMarker) map.removeLayer(clickMarker);

      clickMarker = L.marker([lat, lng]).addTo(map)
        .bindPopup(`<b>Alamat:</b><br>${alamat}<br><b>Lat:</b> ${lat}<br><b>Lng:</b> ${lng}`)
        .openPopup();
    });

    function goToLatLng() {
      const lat = parseFloat(document.getElementById('latitude').value);
      const lng = parseFloat(document.getElementById('longitude').value);

      if (!isNaN(lat) && !isNaN(lng)) {
        map.setView([lat, lng], 16);

        if (clickMarker) map.removeLayer(clickMarker);

        clickMarker = L.marker([lat, lng]).addTo(map)
          .bindPopup(`Lokasi hasil pencarian:<br>Latitude: ${lat}<br>Longitude: ${lng}`)
          .openPopup();
      } else {
        alert('Masukkan koordinat Latitude dan Longitude yang valid!');
      }
    }

    async function searchLocation() {
      const query = document.getElementById('searchText').value.trim();

      if (!query) {
        alert('Masukkan nama tempat atau alamat terlebih dahulu!');
        return;
      }

      try {
        const res = await fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json&limit=1`);
        const results = await res.json();

        if (results.length === 0) {
          alert('Lokasi tidak ditemukan!');
          return;
        }

        const lokasi = results[0];
        const lat = parseFloat(lokasi.lat);
        const lon = parseFloat(lokasi.lon);

        document.getElementById('latitude').value = lat.toFixed(6);
        document.getElementById('longitude').value = lon.toFixed(6);
        document.getElementById('alamat').value = lokasi.display_name;

        map.setView([lat, lon], 16);

        if (clickMarker) map.removeLayer(clickMarker);

        clickMarker = L.marker([lat, lon]).addTo(map)
          .bindPopup(`<b>${lokasi.display_name}</b><br>Latitude: ${lat}<br>Longitude: ${lon}`)
          .openPopup();
      } catch (err) {
        console.error('Gagal mencari lokasi:', err);
        alert('Terjadi kesalahan saat mencari lokasi.');
      }
    }
  </script>

</body>

</html>
