@extends('admin.partials.app')

@section('title', 'Tambah Data Sehat')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">🏥 Tambah Lokasi Kesehatan</h3>

    {{-- Flash message --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <!-- Form -->
        <div class="col-md-4">
            <form action="{{ route('admin.sehat.tempat.store') }}" method="POST" enctype="multipart/form-data">
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
                    <select name="fitur" id="fitur"
                        class="form-control @error('fitur') is-invalid @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoriSehat as $kategori)
                        <option value="{{ $kategori->nama }}" {{ old('fitur') == $kategori->nama ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                        @endforeach
                    </select>
                    @error('fitur')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
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

    // custom icon
    const sehatIcon = L.divIcon({
        html: `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="48" height="48" fill="#E76F51" stroke="white" stroke-width="2">
            <rect x="14" y="20" width="36" height="28" rx="4" ry="4"/>
            <path d="M32 16 v12 M26 22 h12" stroke="white" stroke-width="4" stroke-linecap="round"/>
        </svg>`,
        className: '',
        iconSize: [48, 48],
        iconAnchor: [24, 48],
        popupAnchor: [0, -48]
    });

    locations.forEach(loc => {
        const marker = L.marker([loc.latitude, loc.longitude], {
            icon: sehatIcon
        }).addTo(map);
        marker.bindPopup(`
            <strong>${loc.name}</strong><br>
            <em>${loc.address}</em><br>
            ${loc.foto ? `<img src="${loc.foto}" width="100%" alt="${loc.name}" onerror="this.onerror=null; this.src='/images/placeholder.png';">` : ''}
        `);
    });

    // Event klik peta
    map.on('click', async function(e) {
        const lat = e.latlng.lat.toFixed(6);
        const lng = e.latlng.lng.toFixed(6);
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        let alamat = 'Alamat tidak ditemukan';
        try {
            const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
            const data = await res.json();
            if (data.display_name) {
                alamat = data.display_name;
            }
        } catch (err) {
            console.error('Gagal ambil alamat:', err);
        }

        document.getElementById('address').value = alamat;

        if (clickMarker) map.removeLayer(clickMarker);

        clickMarker = L.marker([lat, lng], {
                icon: sehatIcon
            }).addTo(map)
            .bindPopup(`<b>Alamat:</b><br>${alamat}<br><b>Lat:</b> ${lat}<br><b>Lng:</b> ${lng}`)
            .openPopup();
    });

    document.addEventListener("DOMContentLoaded", function() {
        // otomatis buka file explorer/galeri begitu halaman dibuka
        const fotoInput = document.getElementById("fotoInput");
        if (fotoInput) {
            fotoInput.click();
        }
    });
</script>

<script>
document.getElementById('fotoInput').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;

    // Tipe file yang diperbolehkan
    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];

    // Validasi tipe file
    if (!allowedTypes.includes(file.type)) {
        alert('File harus berupa gambar');
        this.value = ""; // reset input
        return;
    }

    // Validasi ukuran maksimal 2MB (opsional)
    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran gambar maksimal 2MB.');
        this.value = "";
        return;
    }
});
</script>
@endsection