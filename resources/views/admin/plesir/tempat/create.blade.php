@extends('admin.partials.app')

@section('title', 'Tambah Tempat Plesir')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Tambah Tempat Plesir</h3>

    <div class="row">
        <!-- Form -->
        <div class="col-md-4">
            <form action="{{ route('admin.plesir.tempat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Tempat</label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="latitude" class="form-label">Latitude</label>
                    <input type="text" id="latitude" name="latitude"
                        class="form-control @error('latitude') is-invalid @enderror"
                        value="{{ old('latitude', $latitude ?? '') }}" required>
                    @error('latitude')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="longitude" class="form-label">Longitude</label>
                    <input type="text" id="longitude" name="longitude"
                        class="form-control @error('longitude') is-invalid @enderror"
                        value="{{ old('longitude', $longitude ?? '') }}" required>
                    @error('longitude')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <input type="text" id="address" name="address"
                        class="form-control @error('address') is-invalid @enderror"
                        value="{{ old('address', $address ?? '') }}" required>
                    @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="fitur" class="form-label">Kategori</label>
                    <select name="fitur" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoriPlesir as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('fitur') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                        @endforeach
                    </select>
                    @error('fitur')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="fotoInput"
                        class="form-control @error('foto') is-invalid @enderror"
                        accept="image/*"> {{-- filter hanya foto --}}
                    @error('foto')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success w-100">💾 Simpan Data</button>
            </form>
        </div>

        <!-- Map -->
        <div class="col-md-8">
            <label class="form-label">Klik pada Peta atau isi manual Latitude & Longitude</label>
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

    const placeIcon = L.divIcon({
        html: `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="36" height="36" fill="#E76F51" stroke="white" stroke-width="2">
            <path d="M32 4C20 4 10 14 10 26c0 12 22 34 22 34s22-22 22-34C54 14 44 4 32 4z"/>
            <circle cx="32" cy="26" r="6" fill="white"/>
        </svg>`,
        className: '',
        iconSize: [36, 36],
        iconAnchor: [18, 36],
        popupAnchor: [0, -36]
    });

    // tampilkan marker dari database
    locations.forEach(loc => {
        const marker = L.marker([loc.latitude, loc.longitude], {
            icon: placeIcon
        }).addTo(map);
        marker.bindPopup(`
            <strong>${loc.name}</strong><br>
            <em>${loc.address}</em><br>
            ${loc.foto ? `<img src="${loc.foto}" width="100%" alt="${loc.name}" 
            onerror="this.onerror=null; this.src='/images/placeholder.png';">` : ''}
        `);
    });

    // === Klik peta untuk isi otomatis ===
    map.on('click', async function(e) {
        const lat = e.latlng.lat.toFixed(6);
        const lng = e.latlng.lng.toFixed(6);
        setLatLng(lat, lng, true);
    });

    // === Fungsi isi LatLng & marker ===
    async function setLatLng(lat, lng, fetchAddress = false) {
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        let alamat = document.getElementById('address').value;

        if (fetchAddress) {
            try {
                const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
                const data = await res.json();
                if (data.address) {
                    namaTempat = data.address.tourism ||
                        data.address.attraction ||
                        data.address.building ||
                        data.address.natural ||
                        data.address.amenity || '';
                }

                alamat = data.display_name || alamat;
            } catch (err) {
                console.error('Gagal ambil alamat:', err);
            }

            document.getElementById('address').value = alamat;
            if (!document.getElementById('name').value) {
                document.getElementById('name').value = namaTempat;
            }
        }

        if (clickMarker) map.removeLayer(clickMarker);

        clickMarker = L.marker([lat, lng], {
                icon: placeIcon
            }).addTo(map)
            .bindPopup(`<b>Alamat:</b><br>${alamat}<br><b>Lat:</b> ${lat}<br><b>Lng:</b> ${lng}`)
            .openPopup();

        map.setView([lat, lng], 15);
    }

    // === Update marker kalau lat/lng diisi manual ===
    document.getElementById('latitude').addEventListener('change', () => {
        const lat = parseFloat(document.getElementById('latitude').value);
        const lng = parseFloat(document.getElementById('longitude').value);
        if (!isNaN(lat) && !isNaN(lng)) setLatLng(lat, lng, true);
    });

    document.getElementById('longitude').addEventListener('change', () => {
        const lat = parseFloat(document.getElementById('latitude').value);
        const lng = parseFloat(document.getElementById('longitude').value);
        if (!isNaN(lat) && !isNaN(lng)) setLatLng(lat, lng, true);
    });

    // Preview Foto
    document.getElementById('fotoInput').addEventListener('change', function() {
        const [file] = this.files;
        if (file) {
            const preview = document.getElementById('preview');
            if (preview) {
                preview.src = URL.createObjectURL(file);
            }
        }
    });
</script>
@endsection