@extends('admin.partials.app')

@section('title', 'Tambah Data Tempat Olahraga')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">🏟️ Tambah Data Tempat Olahraga</h3>

    <div class="row">
        <!-- Form -->
        <div class="col-md-4">
            <form action="{{ route('admin.sehat.olahraga.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Tempat</label>
                    <input type="text" name="name" id="name" class="form-control"
                        value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="latitude" class="form-label">Latitude</label>
                    <input type="text" id="latitude" name="latitude" class="form-control"
                        value="{{ old('latitude', $latitude ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="longitude" class="form-label">Longitude</label>
                    <input type="text" id="longitude" name="longitude" class="form-control"
                        value="{{ old('longitude', $longitude ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <input type="text" id="address" name="address" class="form-control"
                        value="{{ old('address', $address ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="fotoInput" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn btn-success w-100">💾 Simpan Data</button>
            </form>
        </div>

        <!-- Map -->
        <div class="col-md-8">
            <label class="form-label">Klik pada Peta untuk memilih lokasi</label>
            <div id="peta" style="height: 300px; border-radius: 10px; border: 1px solid #ccc;"></div>
        </div>
    </div>
</div>

<script>
    const map = L.map('peta').setView([-6.326511, 108.3202685], 13);
    let clickMarker = null;

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    const locations = @json($lokasi);

    // icon olahraga (bola)
    const olahragaIcon = L.divIcon({
        html: `
        <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" fill="#2A9D8F" viewBox="0 0 24 24">
            <path d="M12 2C6.49 2 2 6.49 2 12c0 5.52 
                     4.49 10 10 10s10-4.48 10-10C22 6.49 
                     17.51 2 12 2zm0 2c4.42 0 8 3.58 
                     8 8s-3.58 8-8 8-8-3.58-8-8 
                     3.58-8 8-8z"/>
        </svg>`,
        className: '',
        iconSize: [42, 42],
        iconAnchor: [21, 42],
        popupAnchor: [0, -42]
    });

    // Event klik pada peta
    map.on('click', async function(e) {
        const lat = e.latlng.lat.toFixed(6);
        const lng = e.latlng.lng.toFixed(6);
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        let alamat = 'Alamat tidak ditemukan';
        let namaTempat = '';
        try {
            const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
            const data = await res.json();
            if (data.address) {
                namaTempat = data.address.stadium ||
                    data.address.sports_centre ||
                    data.address.building ||
                    data.address.amenity || '';
            }
            if (!namaTempat && data.display_name) {
                namaTempat = data.display_name.split(',')[0];
            }
            alamat = data.display_name || alamat;
        } catch (err) {
            console.error('Gagal ambil alamat:', err);
        }

        document.getElementById('address').value = alamat;

        if (clickMarker) map.removeLayer(clickMarker);

        clickMarker = L.marker([lat, lng], { icon: olahragaIcon }).addTo(map)
            .bindPopup(`<b>Alamat:</b><br>${alamat}<br><b>Lat:</b> ${lat}<br><b>Lng:</b> ${lng}`)
            .openPopup();
    });
</script>
@endsection
