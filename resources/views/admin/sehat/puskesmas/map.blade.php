<!-- resources/views/admin/sehat/puskesmas/map.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Peta Puskesmas</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        html, body { margin: 0; padding: 0; height: 100%; }
        #mapContainer { display: flex; height: 100vh; width: 100%; }

        #sidebar {
            width: 350px;
            background: white;
            padding: 20px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.2);
            overflow-y: auto;
        }

        #searchInput {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            margin-bottom: 15px;
            border: 1px solid #bbb;
            border-radius: 6px;
        }

        .result-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
        }
        .result-item:hover { background: #f4f4f4; }

        #peta { flex-grow: 1; height: 100%; }
    </style>
</head>

<body>
    <div id="mapContainer">
        <div id="sidebar">
            <input type="text" id="searchInput" placeholder="Cari puskesmas...">
            <div id="resultList"></div>
        </div>
        <div id="peta"></div>
    </div>

    <script>
        function debounce(fn, delay) {
            let timer;
            return (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => fn(...args), delay);
            };
        }

        const map = L.map('peta').setView([-6.326511, 108.3202685], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        const dataPuskesmas = @json($lokasi);

        const iconPuskesmas = L.divIcon({
            html: `<div style="font-size:28px; line-height:1;">🏥</div>`,
            className: '',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        });

        const externalIcon = L.divIcon({
            html: `<div style="font-size:28px;">📍</div>`,
            className: '',
            iconSize: [30, 30],
            iconAnchor: [15, 30],
            popupAnchor: [0, -28]
        });

        const resultList = document.getElementById('resultList');
        const searchInput = document.getElementById('searchInput');
        let tempMarker = null;
        let allMarkers = [];

        async function cariEksternal(keyword) {
            if (!keyword || keyword.length < 3) return [];

            const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(keyword)}&limit=5&addressdetails=1`;

            try {
                const res = await fetch(url);
                const json = await res.json();

                return json.map(d => ({
                    name: d.display_name.split(',')[0],
                    alamat: d.display_name,
                    latitude: d.lat,
                    longitude: d.lon,
                    eksternal: true
                }));
            } catch {
                return [];
            }
        }

        function distanceMeters(lat1, lon1, lat2, lon2) {
            const R = 6371000;
            const toRad = x => x * Math.PI / 180;
            const dLat = toRad(lat2 - lat1);
            const dLon = toRad(lon2 - lon1);
            const a = Math.sin(dLat/2)**2 +
                Math.cos(toRad(lat1))*Math.cos(toRad(lat2))*
                Math.sin(dLon/2)**2;

            return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        }

        async function tampilkan(keyword) {
            resultList.innerHTML = '';

            const localData = dataPuskesmas.filter(p =>
                p.nama.toLowerCase().includes(keyword.toLowerCase()) ||
                p.alamat.toLowerCase().includes(keyword.toLowerCase())
            ).map(p => ({ ...p, eksternal: false }));

            const eksternal = await cariEksternal(keyword);

            const eksternalFilter = eksternal.filter(ex => {
                return !localData.some(loc => {
                    const dist = distanceMeters(parseFloat(loc.latitude), parseFloat(loc.longitude),
                        parseFloat(ex.latitude), parseFloat(ex.longitude));
                    return dist < 30;
                });
            });

            const merged = [...localData, ...eksternalFilter];

            allMarkers.forEach(m => map.removeLayer(m.marker));
            allMarkers = [];

            localData.forEach(p => {
                const marker = L.marker([p.latitude, p.longitude], { icon: iconPuskesmas }).addTo(map);
                marker.bindPopup(`
                    <strong>${p.nama}</strong><br>
                    ${p.alamat}<br>
                    <small>Jam: ${p.jam}</small>
                `);
                allMarkers.push({ marker, data: p });
            });

            eksternalFilter.forEach(p => {
                const marker = L.marker([p.latitude, p.longitude], { icon: externalIcon }).addTo(map);
                marker.bindPopup(`
                    <strong>${p.nama}</strong><br>
                    ${p.alamat}<br>
                    <small>(lokasi umum)</small>
                `);
                allMarkers.push({ marker, data: p });
            });

            merged.forEach(p => {
                const div = document.createElement('div');
                div.className = 'result-item';
                div.innerHTML = `
                    <strong>${p.nama}</strong><br>
                    <small>${p.alamat}</small>
                `;
                div.onclick = () => {
                    const lat = parseFloat(p.latitude);
                    const lon = parseFloat(p.longitude);

                    map.setView([lat, lon], 17);

                    if (tempMarker) map.removeLayer(tempMarker);

                    tempMarker = L.marker([lat, lon], {
                        icon: p.eksternal ? externalIcon : iconPuskesmas
                    }).addTo(map);

                    tempMarker.bindPopup(`
                        <strong>${p.nama}</strong><br>
                        ${p.alamat}<br>
                        ${p.jam ? `<small>Jam: ${p.jam}</small>` : ''}
                        ${p.eksternal ? `<br><em>(lokasi umum)</em>` : ''}
                    `).openPopup();

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

        tampilkan('');

        searchInput.addEventListener('input', debounce(() => {
            tampilkan(searchInput.value.trim());
        }, 300));
    </script>

</body>

</html>
