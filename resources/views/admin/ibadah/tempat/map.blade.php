@extends('admin.layouts.app')

@section('title', 'Peta Tempat Ibadah')

@section('content')
<div class="container">
    <h2 class="mb-4">Peta Lokasi Tempat Ibadah</h2>
    <div id="map" style="height: 600px; border-radius: 10px;"></div>
</div>

<!-- Leaflet CDN -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const map = L.map('map').setView([-7.5, 110.0], 10); // Pusat awal

    // Peta dasar dari OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Ambil data dari API Laravel
    fetch("{{ url('/api/tempat') }}")
        .then(response => response.json())
        .then(data => {
            data.forEach(tempat => {
                if (tempat.latitude && tempat.longitude) {
                    L.marker([tempat.latitude, tempat.longitude])
                        .addTo(map)
                        .bindPopup(`<strong>${tempat.nama}</strong><br>${tempat.deskripsi ?? ''}`);
                }
            });
        });
</script>
@endsection
