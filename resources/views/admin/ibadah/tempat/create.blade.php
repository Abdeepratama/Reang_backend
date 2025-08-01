@extends('admin.partials.app')

@section('title', 'Tambah Tempat Ibadah')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">🕌 Tambah Tempat Ibadah</h3>

    <div class="row">
        <!-- Form -->
        <div class="col-md-4">
            <form action="{{ route('admin.ibadah.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Tempat</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="latitude" class="form-label">Latitude</label>
                    <input type="text" id="latitude" name="latitude" class="form-control" value="{{ old('latitude', $latitude ?? '') }}" required readonly>
                </div>

                <div class="mb-3">
                    <label for="longitude" class="form-label">Longitude</label>
                    <input type="text" id="longitude" name="longitude" class="form-control" value="{{ old('longitude', $longitude ?? '') }}" required readonly>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <input type="text" id="address" name="address" class="form-control" value="{{ old('address', $alamat ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="fitur" class="form-label">Kategori</label>
                    <select name="fitur" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoriIbadah as $kategori)
                            <option value="{{ $kategori->nama }}" {{ old('fitur') == $kategori->nama ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @php
                    // karena ini halaman create, tidak ada $item => pakai default preview
                    $previewSrc = asset('images/default-ibadah.jpg');
                @endphp

                <div class="form-group mb-3">
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

    locations.forEach(loc => {
        const marker = L.marker([loc.latitude, loc.longitude]).addTo(map);
        marker.bindPopup(`
            <strong>${loc.name}</strong><br>
            <em>${loc.address}</em><br>
            ${loc.foto ? `<img src="${loc.foto}" width="100%" alt="${loc.name}">` : ''}
        `);
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
                namaTempat = data.address.attraction ||
                    data.address.building ||
                    data.address.mosque ||
                    data.address.church ||
                    data.address.shop ||
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
        document.getElementById('name').value = namaTempat;

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

    function handleSimpan(e) {
        e.preventDefault();

        const nama = document.getElementById('nama').value;
        const lat = document.getElementById('latitude').value;
        const lng = document.getElementById('longitude').value;
        const alamat = document.getElementById('alamat').value;

        if (lat && lng && alamat) {
            const url = `/admin/ibadah/tempat/create?nama=${nama}&latitude=${lat}&longitude=${lng}&alamat=${encodeURIComponent(alamat)}`;
            window.location.href = url;
        } else {
            alert('Klik peta dulu untuk mengambil lokasi!');
        }
    }

    // preview image sebelum submit
    document.getElementById('fotoInput').addEventListener('change', function () {
        const [file] = this.files;
        if (file) {
            document.getElementById('preview').src = URL.createObjectURL(file);
        }
    });
</script>

@endsection
