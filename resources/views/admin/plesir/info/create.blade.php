@extends('admin.partials.app')

@section('title', 'Tambah Info Plesir-Yu')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-briefcase"></i> Tambah Tempat Plesir</h2>

    <form action="{{ route('admin.plesir.info.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="d-flex gap-4">
            <!-- Bagian Form Input -->
            <div style="flex: 1; max-width: 400px;">
                <div class="form-group mb-3">
                    <label>Judul</label>
                    <input type="text" name="judul" id="judul" class="form-control" required>
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
                    <label>Kategori</label>
                    <select name="fitur" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoriPlesir as $kategori)
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

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="editor">{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>
                </div>

                <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan Data</button>
            </div>

            <!-- Bagian Peta -->
            <div style="flex: 1; min-width: 400px;">
                <label class="form-label mb-2">Klik pada Peta atau isi manual koordinat</label>
                <div id="peta" style="height: 400px; border-radius: 10px; border: 1px solid #ccc;"></div>
            </div>
        </div>
    </form>
</div>

<script>
    // Inisialisasi peta dengan titik awal
    const map = L.map('peta').setView([-6.326511, 108.3202685], 13);
    let clickMarker = null;

    // Tile layer OSM
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    // Custom icon
    const lokasiIcon = L.divIcon({
        html: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="38" height="38" fill="#E63946" stroke="white" stroke-width="2"><path d="M12 2C8 2 5 5 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-4-3-7-7-7z"/><circle cx="12" cy="9" r="2.5" fill="white"/></svg>`,
        className: '',
        iconSize: [38, 38],
        iconAnchor: [19, 38],
        popupAnchor: [0, -38]
    });

    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    const addressInput = document.getElementById('alamat');

    // Fungsi untuk update marker
    function updateMarker(lat, lng, alamat = '') {
        if (clickMarker) map.removeLayer(clickMarker);
        clickMarker = L.marker([lat, lng], {
                icon: lokasiIcon
            }).addTo(map)
            .bindPopup(`<b>Alamat:</b> ${alamat}<br><b>Lat:</b> ${lat}<br><b>Lng:</b> ${lng}`)
            .openPopup();
        map.setView([lat, lng], 16);
    }

    // Klik peta -> update form
    map.on('click', async function(e) {
        const lat = e.latlng.lat.toFixed(6);
        const lng = e.latlng.lng.toFixed(6);

        latInput.value = lat;
        lngInput.value = lng;

        let alamat = 'Alamat tidak ditemukan';
        try {
            const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
            const data = await response.json();
            if (data.display_name) alamat = data.display_name;
        } catch (err) {
            console.error(err);
        }

        if (addressInput) addressInput.value = alamat;
        updateMarker(lat, lng, alamat);
    });

    // Jika user isi manual lat/lng -> update peta
    function manualUpdate() {
        const lat = parseFloat(latInput.value);
        const lng = parseFloat(lngInput.value);
        if (!isNaN(lat) && !isNaN(lng)) {
            updateMarker(lat, lng, 'Lokasi manual');
        }
    }
    latInput.addEventListener('change', manualUpdate);
    lngInput.addEventListener('change', manualUpdate);
</script>

{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
    let editor;
    ClassicEditor
        .create(document.querySelector('#editor'), {
            ckfinder: {
                uploadUrl: "{{ route('admin.kerja.info.upload.image') }}?_token={{ csrf_token() }}"
            }
        })
        .then(instance => {
            editor = instance;
        })
        .catch(error => {
            console.error(error);
        });
</script>

@endsection