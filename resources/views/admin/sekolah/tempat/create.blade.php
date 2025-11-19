@extends('admin.partials.app')

@section('title', 'Tambah Data Sekolah')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">🏫 Tambah Data Sekolah</h3>

    <div class="row">
        <!-- Form -->
        <div class="col-md-4">
            <form action="{{ route('admin.sekolah.tempat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Sekolah</label>
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
                        @foreach($kategoriSekolah as $kategori)
                            <option value="{{ $kategori->nama }}" {{ old('fitur') == $kategori->nama ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
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

    // custom icon sekolah
    const sekolahIcon = L.divIcon({
        html: `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="48" height="48" fill="#2A9D8F" stroke="white" stroke-width="2">
            <path d="M32 8 L2 24 L32 40 L62 24 Z" />
            <path d="M12 28 V44 H52 V28" fill="#2A9D8F" stroke="white" stroke-width="2"/>
        </svg>`,
        className: '',
        iconSize: [48, 48],
        iconAnchor: [24, 48],
        popupAnchor: [0, -48]
    });

    locations.forEach(loc => {
        const marker = L.marker([loc.latitude, loc.longitude], { icon: sekolahIcon }).addTo(map);
        marker.bindPopup(`
            <strong>${loc.name}</strong><br>
            <em>${loc.address}</em><br>
            ${loc.foto ? `<img src="${loc.foto}" width="100%" alt="${loc.name}" onerror="this.onerror=null; this.src='/images/placeholder.png';">` : ''}
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
                namaTempat = data.address.school ||
                    data.address.university ||
                    data.address.college ||
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

        clickMarker = L.marker([lat, lng], { icon: sekolahIcon }).addTo(map)
            .bindPopup(`<b>Alamat:</b><br>${alamat}<br><b>Lat:</b> ${lat}<br><b>Lng:</b> ${lng}`)
            .openPopup();
    });

    // preview image sebelum submit
    document.getElementById('fotoInput').addEventListener('change', function () {
        const [file] = this.files;
        if (file) {
            document.getElementById('preview').src = URL.createObjectURL(file);
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
