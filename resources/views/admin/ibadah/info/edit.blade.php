@extends('admin.partials.app')

@section('title', 'Edit Info Keagamaan')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-book"></i> Edit Info Keagamaan</h2>

    <form id="infoForm" action="{{ route('admin.ibadah.info.update', $info->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="d-flex gap-4">
            <!-- Bagian Form Input -->
            <div style="flex: 1; max-width: 400px;">
                <div class="form-group mb-3">
                    <label>Judul</label>
                    <input type="text" name="judul" class="form-control" 
                           value="{{ old('judul', $info->judul) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" 
                           value="{{ old('tanggal', $info->tanggal) }}" required>
                </div>

                <div class="form-group mb-3 position-relative">
    <label>Waktu</label>
    <input type="text" id="waktu" name="waktu" class="form-control"
           value="{{ old('waktu', $info->waktu) }}"
           placeholder="Klik untuk pilih waktu" readonly required>

    <div id="jam-popup"
        style="display:none; position:absolute; background:white; border-radius:12px;
        padding:20px; top:100%; left:0; z-index:9999; box-shadow:0 4px 10px rgba(0,0,0,0.1);">

        {{-- Lingkaran jam --}}
        <div id="clock-jam" class="clock-simple position-relative"
            style="width:250px; height:250px; border:3px solid #aaa; border-radius:50%;
            background:white; margin:auto;">
            @for ($i = 1; $i <= 24; $i++)
                @php
                    $angle = deg2rad(($i * 15) - 90);
                    $radius = 95;
                    $x = cos($angle) * $radius;
                    $y = sin($angle) * $radius;
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

        {{-- Lingkaran menit --}}
        <div id="clock-menit" class="clock-simple position-relative"
            style="width:250px; height:250px; border:3px solid #aaa; border-radius:50%;
            background:white; margin:auto; display:none;">
            @for ($i = 0; $i < 60; $i += 5)
                @php
                    $angle = deg2rad(($i * 6) - 90);
                    $radius = 95;
                    $x = cos($angle) * $radius;
                    $y = sin($angle) * $radius;
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
                    <label>Lokasi</label>
                    <input type="text" name="lokasi" class="form-control" 
                           value="{{ old('lokasi', $info->lokasi) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label>Latitude</label>
                    <input type="text" name="latitude" id="latitude" class="form-control" 
                           value="{{ old('latitude', $info->latitude) }}" readonly required>
                </div>

                <div class="form-group mb-3">
                    <label>Longitude</label>
                    <input type="text" name="longitude" id="longitude" class="form-control" 
                           value="{{ old('longitude', $info->longitude) }}" readonly required>
                </div>

                <div class="form-group mb-3">
                    <label>Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" 
                           value="{{ old('alamat', $info->alamat) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label>Kategori</label>
                    <select name="fitur" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoriInfoIbadah as $kategori)
                            <option value="{{ $kategori->nama }}" 
                                {{ old('fitur', $info->fitur) == $kategori->nama ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="foto">Foto</label>
            <input type="file" name="foto" id="fotoInput"
                class="form-control @error('foto') is-invalid @enderror"
                accept="image/*"> {{-- filter hanya foto --}}
            @error('foto')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            
                    @if($info->foto)
                        <small>Foto saat ini:</small><br>
                        <img src="{{ asset('storage/' . $info->foto) }}" alt="Foto" 
                             width="150" style="border-radius:8px; margin-top:5px;">
                    @endif
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="editor" class="form-control" rows="5">{{ old('deskripsi', $info->deskripsi) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Update Data</button>
                <a href="{{ route('admin.ibadah.info.index') }}" class="btn btn-secondary">Batal</a>
            </div>

            <!-- Bagian Peta -->
            <div style="flex: 1; min-width: 400px;">
                <label class="form-label mb-2">Klik pada Peta untuk memilih lokasi</label>
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
let selectedMinute = null;

// Ambil waktu dari input (kalau ada)
if (waktuInput.value) {
    const [jam, menit] = waktuInput.value.split(':');
    selectedHour = jam;
    selectedMinute = menit;
}

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
        document.querySelectorAll('.jam-item').forEach(b => {
            b.style.background = '#f9f9f9';
            b.style.color = '#000';
        });
        this.style.background = '#007bff';
        this.style.color = 'white';
        selectedHour = this.dataset.hour;
        jamCircle.style.display = 'none';
        menitCircle.style.display = 'block';
    });
});

// Pilih menit
document.querySelectorAll('.menit-item').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.menit-item').forEach(b => {
            b.style.background = '#f9f9f9';
            b.style.color = '#000';
        });
        this.style.background = '#007bff';
        this.style.color = 'white';
        selectedMinute = this.dataset.minute;

        // Format hasil ke "HH:MM"
        waktuInput.value = `${selectedHour}:${selectedMinute}`;
        popup.style.display = 'none';
    });
});
</script>

<script>
    const initialLat = parseFloat(@json(old('latitude', $info->latitude)));
    const initialLng = parseFloat(@json(old('longitude', $info->longitude)));

    const map = L.map('peta').setView([initialLat || -6.326511, initialLng || 108.3202685], 13);

    let clickMarker = null;

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    const iconMarker = L.divIcon({
        html: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="48" height="48" fill="#E76F51" stroke="white" stroke-width="2">
            <circle cx="32" cy="32" r="14"/>
        </svg>`,
        className: '',
        iconSize: [48, 48],
        iconAnchor: [24, 48],
        popupAnchor: [0, -48]
    });

    if (!isNaN(initialLat) && !isNaN(initialLng)) {
        clickMarker = L.marker([initialLat, initialLng], { icon: iconMarker }).addTo(map)
            .bindPopup(`<b>Lokasi Saat Ini</b><br>Lat: ${initialLat.toFixed(6)}<br>Lng: ${initialLng.toFixed(6)}`)
            .openPopup();
    }

    map.on('click', async function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;

        document.getElementById('latitude').value = lat.toFixed(6);
        document.getElementById('longitude').value = lng.toFixed(6);

        let alamat = 'Alamat tidak ditemukan';

        try {
            const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
            const data = await response.json();
            alamat = data.display_name || alamat;
        } catch (error) {
            console.error('Gagal mendapatkan alamat:', error);
        }

        document.getElementById('alamat').value = alamat;

        if (clickMarker) {
            map.removeLayer(clickMarker);
        }

        clickMarker = L.marker([lat, lng], { icon: iconMarker }).addTo(map)
            .bindPopup(`<b>Alamat:</b><br>${alamat}<br><b>Lat:</b> ${lat.toFixed(6)}<br><b>Lng:</b> ${lng.toFixed(6)}`)
            .openPopup();
    });
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
