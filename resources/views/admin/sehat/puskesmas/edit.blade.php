@extends('admin.partials.app')

@section('title', 'Edit Puskesmas')

@section('content')
<div class="container-fluid px-4">
    <h4 class="mt-4 mb-4">✏️ Edit Puskesmas</h4>

    <form action="{{ route('admin.sehat.puskesmas.update', $puskesmas->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- FORM -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Puskesmas</label>
                    <input type="text" name="nama" id="nama" class="form-control"
                        value="{{ old('nama', $puskesmas->nama) }}" required>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea id="alamat" name="alamat" class="form-control" required>{{ old('alamat', $puskesmas->alamat) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="latitude" class="form-label">Latitude</label>
                    <input type="text" name="latitude" id="latitude" class="form-control"
                        value="{{ old('latitude', $puskesmas->latitude) }}" required>
                </div>

                <div class="mb-3">
                    <label for="longitude" class="form-label">Longitude</label>
                    <input type="text" name="longitude" id="longitude" class="form-control"
                        value="{{ old('longitude', $puskesmas->longitude) }}" required>
                </div>

                <div class="mb-3">
                    <label for="jam" class="form-label">Jam Operasional</label>
                    <input type="text" name="jam" id="jam" class="form-control"
                        value="{{ old('jam', $puskesmas->jam) }}" placeholder="08:00 - 16:00" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">💾 Update Puskesmas</button>
            </div>

            <!-- PETA -->
            <div class="col-md-6">
                <label for="peta" class="form-label">Klik Peta untuk memilih lokasi</label>
                <div id="peta" style="height: 450px; width: 100%; border:1px solid #ccc; border-radius:10px;"></div>
            </div>
        </div>
    </form>
</div>

<script>
    const map = L.map('peta').setView([-6.326511, 108.3202685], 13);
    let clickMarker = null;

    // Tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    // Marker dari database
    const currentLat = parseFloat(`{{ $puskesmas->latitude }}`);
    const currentLng = parseFloat(`{{ $puskesmas->longitude }}`);
    const currentName = `{{ $puskesmas->nama }}` || 'Lokasi Saat Ini';

    if (!isNaN(currentLat) && !isNaN(currentLng)) {
        clickMarker = L.marker([currentLat, currentLng]).addTo(map)
            .bindPopup(`<b>${currentName}</b><br>Latitude: ${currentLat}<br>Longitude: ${currentLng}`)
            .openPopup();
        map.setView([currentLat, currentLng], 16);
    }

    // Klik untuk ubah lokasi
    map.on('click', async function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;

        if (clickMarker) {
            map.removeLayer(clickMarker);
        }

        clickMarker = L.marker([lat, lng]).addTo(map);
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        try {
            const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
            const data = await response.json();
            const address = data.display_name || 'Alamat tidak ditemukan';
            document.getElementById('alamat').value = address;
            clickMarker.bindPopup(address).openPopup();
        } catch (err) {
            console.error('Gagal mengambil alamat:', err);
        }
    });
</script>
@endsection