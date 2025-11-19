@extends('admin.partials.app')

@section('title', 'Tambah Info Keagamaan')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-moon-stars"></i> Tambah Info Keagamaan</h2>

    <form id="infoForm" action="{{ route('admin.ibadah.info.store') }}" method="POST" enctype="multipart/form-data">
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

                <div class="form-group mb-3 position-relative">
                    <label>Waktu</label>
                    <input type="text" id="waktu" name="waktu" class="form-control" placeholder="Klik untuk pilih waktu" readonly required>
                    @error('waktu')
                    <div class="invalid-feedback" style="display:block;">
                        {{ $message }}
                    </div>
                    @enderror

                    <div id="jam-popup"
                        style="display:none; position:absolute; background:white; border-radius:12px;
        padding:20px; top:100%; left:0; z-index:9999; box-shadow:0 4px 10px rgba(0,0,0,0.1);">

                        <div id="clock-jam" class="clock-simple position-relative"
                            style="width:250px; height:250px; border:3px solid #aaa; border-radius:50%;
            background:white; margin:auto;">

                            @for ($i = 1; $i <= 24; $i++)
                                @php
                                $angle=deg2rad(($i * 15) - 90);
                                $radius=95;
                                $x=cos($angle) * $radius;
                                $y=sin($angle) * $radius;
                                @endphp
                                <div class="jam-item" data-hour="{{ sprintf('%02d', $i) }}"
                                style="position:absolute; width:30px; height:30px; line-height:30px;
                        text-align:center; border-radius:50%; font-size:13px;
                        background:#f9f9f9; border:1px solid #ccc; cursor:pointer;
                        left:calc(50% + {{ $x }}px - 15px); top:calc(50% + {{ $y }}px - 15px);
                        transition:0.2s;">
                                {{ $i }}
                        </div>
                        @endfor

                        <div style="position:absolute; width:10px; height:10px; background:#333; border-radius:50%;
                top:50%; left:50%; transform:translate(-50%,-50%);"></div>
                    </div>

                    <!-- Lingkaran menit -->
                    <div id="clock-menit" class="clock-simple position-relative"
                        style="width:250px; height:250px; border:3px solid #aaa; border-radius:50%;
            background:white; margin:auto; display:none;">

                        @for ($i = 0; $i < 60; $i +=5)
                            @php
                            $angle=deg2rad(($i * 6) - 90); // 360/60=6 derajat per menit
                            $radius=95;
                            $x=cos($angle) * $radius;
                            $y=sin($angle) * $radius;
                            @endphp
                            <div class="menit-item" data-minute="{{ sprintf('%02d', $i) }}"
                            style="position:absolute; width:32px; height:32px; line-height:32px;
                        text-align:center; border-radius:50%; font-size:13px;
                        background:#f9f9f9; border:1px solid #ccc; cursor:pointer;
                        left:calc(50% + {{ $x }}px - 16px); top:calc(50% + {{ $y }}px - 16px);
                        transition:0.2s;">
                            {{ sprintf('%02d', $i) }}
                    </div>
                    @endfor

                    <div style="position:absolute; width:10px; height:10px; background:#333; border-radius:50%;
                top:50%; left:50%; transform:translate(-50%,-50%);"></div>
                </div>
            </div>
        </div>

        <div class="form-group mb-3">
            <label>Latitude</label>
            <input type="text" id="latitude" name="latitude"
                class="form-control @error('latitude') is-invalid @enderror"
                value="{{ old('latitude', $latitude ?? '') }}" required>
            @error('latitude')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label>Longitude</label>
            <input type="text" id="longitude" name="longitude"
                class="form-control @error('longitude') is-invalid @enderror"
                value="{{ old('longitude', $longitude ?? '') }}" required>
            @error('longitude')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label>Alamat</label>
            <input type="text" id="alamat" name="alamat"
                class="form-control @error('alamat') is-invalid @enderror"
                value="{{ old('alamat', $alamat ?? '') }}" required>
            @error('alamat')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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

        <div class="mb-3">
            <label for="foto">Foto</label>
            <input type="file" name="foto" id="fotoInput"
                class="form-control @error('foto') is-invalid @enderror"
                accept="image/*"> {{-- filter hanya foto --}}
            @error('foto')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="editor">{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>
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
    const waktuInput = document.getElementById('waktu');
    const popup = document.getElementById('jam-popup');
    const jamCircle = document.getElementById('clock-jam');
    const menitCircle = document.getElementById('clock-menit');
    let selectedHour = null;

    // Klik input → tampilkan popup
    waktuInput.addEventListener('click', () => {
        popup.style.display = 'block';
        jamCircle.style.display = 'block';
        menitCircle.style.display = 'none';
    });

    // Klik di luar → tutup popup
    document.addEventListener('click', function(e) {
        if (!popup.contains(e.target) && e.target !== waktuInput) {
            popup.style.display = 'none';
        }
    });

    // Pilih jam
    document.querySelectorAll('.jam-item').forEach(btn => {
        btn.addEventListener('click', function() {
            selectedHour = this.dataset.hour;
            jamCircle.style.display = 'none';
            menitCircle.style.display = 'block';
        });
    });

    // Pilih menit
    document.querySelectorAll('.menit-item').forEach(btn => {
        btn.addEventListener('click', function() {
            const minute = this.dataset.minute;
            waktuInput.value = `${selectedHour}:${minute}`;
            popup.style.display = 'none';
        });
    });
</script>

<script>
    document.getElementById('infoForm').addEventListener('submit', function(e) {
        const waktuInput = document.getElementById('waktu');
        if (!waktuInput.value.trim()) {
            e.preventDefault();
            waktuInput.classList.add('is-invalid');
            alert('Silakan pilih waktu terlebih dahulu!');
        }
    });
</script>

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

<script>
    document.getElementById('fotoInput').addEventListener('change', function() {
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