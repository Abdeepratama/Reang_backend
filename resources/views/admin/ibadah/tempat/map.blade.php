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
            width: 400px; /* Lebih besar dari sebelumnya */
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
        const map = L.map('peta').setView([-6.326511, 108.3202685], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const lokasi = @json($lokasi); // ← Ini Laravel Blade
        const resultList = document.getElementById('resultList');
        const searchInput = document.getElementById('searchInput');

        let allMarkers = [];
        let tempMarker = null;

        lokasi.forEach(loc => {
            const marker = L.marker([loc.latitude, loc.longitude]).addTo(map);
            marker.bindPopup(`
                <strong>${loc.name}</strong><br>
                ${loc.address}<br>
                ${loc.foto ? `<img src="${loc.foto}" width="100%">` : ''}
            `);
            allMarkers.push({ marker, data: loc });
        });

        function tampilkanHasil(keyword) {
            resultList.innerHTML = '';

            const filtered = lokasi.filter(loc =>
                loc.name.toLowerCase().includes(keyword.toLowerCase()) ||
                loc.address.toLowerCase().includes(keyword.toLowerCase())
            );

            allMarkers.forEach(obj => map.removeLayer(obj.marker));

            filtered.forEach(loc => {
                const item = document.createElement('div');
                item.className = 'result-item';
                item.innerHTML = `<strong>${loc.name}</strong><br>${loc.address}`;
                item.onclick = () => {
                    const lat = parseFloat(loc.latitude);
                    const lng = parseFloat(loc.longitude);
                    map.setView([lat, lng], 17);

                    if (tempMarker) map.removeLayer(tempMarker);
                    tempMarker = L.marker([lat, lng]).addTo(map);
                    tempMarker.bindPopup(`<b>${loc.name}</b><br>${loc.address}`).openPopup();

                    setTimeout(() => {
                        if (tempMarker) {
                            map.removeLayer(tempMarker);
                            tempMarker = null;
                        }
                    }, 5000);
                };
                resultList.appendChild(item);
            });

            allMarkers.forEach(obj => {
                if (filtered.includes(obj.data)) {
                    obj.marker.addTo(map);
                }
            });
        }

        searchInput.addEventListener('input', () => {
            tampilkanHasil(searchInput.value.trim());
        });

        tampilkanHasil('');
    </script>
</body>

</html>
