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
    </style>

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body>

    <div class="container">
        <h3>Peta Interaktif</h3>
        <p>Cari lokasi berdasarkan alamat atau klik langsung di peta.</p>

        <!-- Pencarian alamat -->
        <div class="search-controls">
            <input type="text" id="cariAlamat" placeholder="Masukkan alamat">
            <button onclick="cariAlamat()">Cari Lokasi</button>
        </div>

        <!-- Input hasil koordinat dan alamat -->
        <div class="search-controls">
            <input type="text" id="latitude" placeholder="Latitude" readonly>
            <input type="text" id="longitude" placeholder="Longitude" readonly>
            <input type="text" id="alamat" placeholder="Alamat Lengkap" style="width: 50%;" readonly>
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

        const locations = @json($lokasi);

    locations.forEach(loc => {
        const marker = L.marker([loc.latitude, loc.longitude]).addTo(map);
        marker.bindPopup(`
            <strong>${loc.name}</strong><br>
            <em>${loc.address}</em><br>
            ${loc.foto ? `<img src="${loc.foto}" width="100%" alt="${loc.name}">` : ''}
        `);
    });

        // Event klik peta
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


    async function cariAlamat() {
        const inputAlamat = document.getElementById('cariAlamat').value.trim();
        if (!inputAlamat) {
            alert("Masukkan alamat terlebih dahulu.");
            return;
        }

        // 1. Coba cari dari data database terlebih dahulu
        const found = locations.find(loc =>
            loc.name.toLowerCase().includes(inputAlamat.toLowerCase()) ||
            loc.address.toLowerCase().includes(inputAlamat.toLowerCase())
        );

        if (found) {
            const lat = parseFloat(found.latitude).toFixed(6);
            const lon = parseFloat(found.longitude).toFixed(6);

            map.setView([lat, lon], 16);

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lon;
            document.getElementById('alamat').value = found.address;

            if (clickMarker) map.removeLayer(clickMarker);
            clickMarker = L.marker([lat, lon]).addTo(map)
                .bindPopup(`<b>${found.name}</b><br>${found.address}<br>Lat: ${lat}, Lng: ${lon}`)
                .openPopup();

            return;
        }

        // 2. Jika tidak ketemu, pakai pencarian dari API OpenStreetMap
        try {
            const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(inputAlamat)}`);
            const data = await res.json();

            if (data.length === 0) {
                alert("Alamat tidak ditemukan.");
                return;
            }

            const hasil = data[0];
            const lat = parseFloat(hasil.lat).toFixed(6);
            const lon = parseFloat(hasil.lon).toFixed(6);
            const displayName = hasil.display_name;

            map.setView([lat, lon], 16);

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lon;
            document.getElementById('alamat').value = displayName;

            if (clickMarker) map.removeLayer(clickMarker);
            clickMarker = L.marker([lat, lon]).addTo(map)
                .bindPopup(`<b>${displayName}</b><br>Lat: ${lat}<br>Lng: ${lon}`)
                .openPopup();
        } catch (err) {
            alert("Gagal mencari alamat.");
            console.error(err);
        }
    }

        // Fungsi pencarian berdasarkan alamat
        // async function cariAlamat() {
        //     const inputAlamat = document.getElementById('cariAlamat').value;
        //     if (!inputAlamat) {
        //         alert("Masukkan alamat terlebih dahulu.");
        //         return;
        //     }

        //     try {
        //         const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(inputAlamat)}`);
        //         const data = await res.json();

        //         if (data.length === 0) {
        //             alert("Alamat tidak ditemukan.");
        //             return;
        //         }

        //         const hasil = data[0];
        //         const lat = parseFloat(hasil.lat).toFixed(6);
        //         const lon = parseFloat(hasil.lon).toFixed(6);
        //         const displayName = hasil.display_name;

        //         map.setView([lat, lon], 16);

        //         document.getElementById('latitude').value = lat;
        //         document.getElementById('longitude').value = lon;
        //         document.getElementById('alamat').value = displayName;

        //         if (clickMarker) map.removeLayer(clickMarker);
        //         clickMarker = L.marker([lat, lon]).addTo(map)
        //             .bindPopup(`<b>${displayName}</b><br>Lat: ${lat}<br>Lng: ${lon}`)
        //             .openPopup();
        //     } catch (err) {
        //         alert("Gagal mencari alamat.");
        //         console.error(err);
        //     }
        // }
    </script>

</body>

</html>
