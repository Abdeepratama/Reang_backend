@extends('admin.partials.app')

@section('title', 'Tambah Info Keagamaan')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-moon-stars"></i> Tambah Info Keagamaan</h2>

    <form action="{{ route('admin.ibadah.info.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="d-flex gap-4">
            <!-- Bagian Form Input -->
            <div style="flex: 1; max-width: 400px;">
                <div class="form-group mb-3">
                    <label>Judul</label>
                    <input type="text" name="judul" id="judul" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label>Waktu</label>
                    <input type="time" name="waktu" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label>Latitude</label>
                    <input type="text" name="latitude" id="latitude" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label>Longitude</label>
                    <input type="text" name="longitude" id="longitude" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label>Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label>Lokasi</label>
                    <input type="text" name="lokasi" class="form-control" placeholder="Masukkan lokasi" required>
                </div>

                <div class="form-group mb-3">
                    <label>Kategori</label>
                    <select name="fitur" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoriInfoIbadah as $kategori)
                        <option value="{{ $kategori->nama }}" {{ old('fitur') == $kategori->nama ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label>Foto</label>
                    <input type="file" name="foto" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" id="editor" class="form-control" rows="5"></textarea>
                </div>

                <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan Data</button>
            </div>

            <!-- Bagian Peta -->
            <div style="flex: 1; min-width: 400px;">
                <label class="form-label mb-2">Klik pada Peta atau isi manual Latitude & Longitude</label>
                <div id="peta" style="height: 400px; border-radius: 10px; border: 1px solid #ccc;"></div>
            </div>
        </div>
    </form>
</div>

<script>
    // Inisialisasi peta
    const map = L.map('peta').setView([-6.326511, 108.3202685], 13);
    let clickMarker = null;

    // Tile OSM
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Data marker existing
    const locations = @json($lokasi);

    // Icon masjid
    const masjidIcon = L.divIcon({
        html: `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="48" height="48" fill="#2A9D8F" stroke="white" stroke-width="2">
            <path d="M32 8 L28 16 H36 L32 8 Z M20 24 H44 V56 H20 Z" />
        </svg>`,
        className: '',
        iconSize: [48, 48],
        iconAnchor: [24, 48],
        popupAnchor: [0, -48]
    });

    // Tampilkan marker existing
    locations.forEach(loc => {
        const latNum = parseFloat(loc.latitude);
        const lngNum = parseFloat(loc.longitude);

        if (!isNaN(latNum) && !isNaN(lngNum)) {
            const marker = L.marker([latNum, lngNum], {
                icon: masjidIcon
            }).addTo(map);
            marker.bindPopup(`
                <strong>${loc.name}</strong><br>
                <em>${loc.address}</em><br>
                ${loc.foto ? `<img src="${loc.foto}" width="100%" alt="${loc.name}" onerror="this.onerror=null; this.src='/images/placeholder.png';">` : ''}
            `);
        }
    });

    // fungsi ambil alamat dari Nominatim
    async function getAlamat(lat, lng) {
        let alamat = 'Alamat tidak ditemukan';
        try {
            const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
            const data = await response.json();
            alamat = data.display_name || alamat;
        } catch (error) {
            console.error('Gagal mendapatkan alamat:', error);
        }
        return alamat;
    }

    // update marker dan form
    async function updateMarker(lat, lng, isManual = false) {
        map.setView([lat, lng], 16);

        if (clickMarker) map.removeLayer(clickMarker);

        const alamat = await getAlamat(lat, lng);
        if (!isManual) {
            document.getElementById('alamat').value = alamat;
        }

        clickMarker = L.marker([lat, lng], {
                icon: masjidIcon
            }).addTo(map)
            .bindPopup(`<b>Alamat:</b><br>${alamat}<br><b>Lat:</b> ${lat}<br><b>Lng:</b> ${lng}`)
            .openPopup();
    }

    // Event klik peta
    map.on('click', async function(e) {
        const lat = e.latlng.lat.toFixed(6);
        const lng = e.latlng.lng.toFixed(6);
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
        await updateMarker(lat, lng);
    });

    // Event input manual lat/lng
    async function updateMapFromInput() {
        const lat = parseFloat(document.getElementById('latitude').value);
        const lng = parseFloat(document.getElementById('longitude').value);

        if (!isNaN(lat) && !isNaN(lng)) {
            await updateMarker(lat, lng, true);
        }
    }

    document.getElementById('latitude').addEventListener('input', updateMapFromInput);
    document.getElementById('longitude').addEventListener('input', updateMapFromInput);
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
// Inisialisasi CKEditor
let editor;

ClassicEditor
.create(document.querySelector('#editor'), {
    ckfinder: {
        uploadUrl: "{{ route('admin.sehat.info.upload.image') }}?_token={{ csrf_token() }}"
    }
})
.then(instance => {
    editor = instance;
})
.catch(error => {
    console.error(error);
});

// Validasi manual sebelum submit
document.getElementById('infoForm').addEventListener('submit', function(e) {
    // Validasi CKEditor content
    if (editor && editor.getData().trim() === '') {
        e.preventDefault();
        alert('Deskripsi harus diisi');
        return false;
    }
    
    // Validasi file type
    const fileInput = document.querySelector('input[name="foto"]');
    if (fileInput.files.length > 0) {
        const file = fileInput.files[0];
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!validTypes.includes(file.type)) {
            e.preventDefault();
            alert('Hanya file JPEG, PNG, dan JPG yang diizinkan');
            return false;
        }
    }
});
</script>
@endsection