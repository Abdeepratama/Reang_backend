@extends('admin.partials.app')

@section('title', 'Edit Info Plesir-Yu')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-briefcase"></i> Edit Tempat Plesir</h2>

    <form action="{{ route('admin.plesir.info.update', $info->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="d-flex gap-4">
            <!-- Bagian Form Input -->
            <div style="flex: 1; max-width: 400px;">
                <div class="form-group mb-3">
                    <label>Judul</label>
                    <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul', $info->judul) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label>Latitude</label>
                    <input type="text" name="latitude" id="latitude" class="form-control" readonly value="{{ old('latitude', $info->latitude) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label>Longitude</label>
                    <input type="text" name="longitude" id="longitude" class="form-control" readonly value="{{ old('longitude', $info->longitude) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label>Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" value="{{ old('alamat', $info->alamat) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label>Kategori</label>
                    <select name="fitur" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoriPlesir as $kategori)
                        <option value="{{ $kategori->nama }}" {{ (old('fitur', $info->fitur) == $kategori->nama) ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label>Foto</label>
                    <input type="file" name="foto" class="form-control">
                    @if($info->foto)
                    <small>Foto saat ini:</small><br>
                    <img src="{{ $info->foto }}" alt="Foto" width="150" style="border-radius:8px; margin-top:5px;">
                    @endif
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="editor" class="form-control" rows="5">{{ old('deskripsi', $info->deskripsi) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Update Data</button>
                <a href="{{ route('admin.plesir.info.index') }}" class="btn btn-secondary">Batal</a>
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
    // Data lokasi lama dari form (latitude dan longitude dari server)
    const initialLat = parseFloat(@json(old('latitude', $info->latitude)));
    const initialLng = parseFloat(@json(old('longitude', $info->longitude)));

    // Inisialisasi peta dengan posisi lama, atau default jika kosong
    const map = L.map('peta').setView([initialLat || -6.326511, initialLng || 108.3202685], 13);

    // Marker klik yang akan berubah posisi
    let clickMarker = null;

    // Load tile OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Custom icon sama seperti tambah
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

    // Tampilkan marker di posisi awal
    if (!isNaN(initialLat) && !isNaN(initialLng)) {
        clickMarker = L.marker([initialLat, initialLng], {
                icon: sehatIcon
            }).addTo(map)
            .bindPopup(`<b>Lokasi Saat Ini</b><br>Lat: ${initialLat.toFixed(6)}<br>Lng: ${initialLng.toFixed(6)}`)
            .openPopup();
    }

    // Event klik peta untuk memilih lokasi baru
    map.on('click', async function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;

        // Isi input lat dan lng dengan 6 desimal string
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');
        if (latInput) latInput.value = lat.toFixed(6);
        if (lngInput) lngInput.value = lng.toFixed(6);

        let alamat = 'Alamat tidak ditemukan';
        let namaTempat = '';

        try {
            // Panggil API reverse geocode Nominatim
            const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
            const data = await response.json();

            console.log('Reverse Geocode response:', data);

            if (data.address) {
                namaTempat = data.address.hospital ||
                    data.address.clinic ||
                    data.address.pharmacy ||
                    data.address.building ||
                    data.address.amenity || '';
            }

            if (!namaTempat && data.display_name) {
                namaTempat = data.display_name.split(',')[0];
            }

            alamat = data.display_name || alamat;
        } catch (error) {
            console.error('Gagal mendapatkan alamat:', error);
        }

        // Set value alamat dan nama tempat ke input form
        const addressInput = document.getElementById('alamat');
        const nameInput = document.getElementById('judul');
        if (addressInput) addressInput.value = alamat;
        // Optional: jika ingin update judul otomatis sesuai nama tempat
        // if(nameInput && !nameInput.value) nameInput.value = namaTempat;

        // Hapus marker sebelumnya jika ada
        if (clickMarker) {
            map.removeLayer(clickMarker);
        }

        // Tambahkan marker baru (pakai angka lat,lng)
        clickMarker = L.marker([lat, lng], {
                icon: sehatIcon
            }).addTo(map)
            .bindPopup(`<b>Alamat:</b><br>${alamat}<br><b>Lat:</b> ${lat.toFixed(6)}<br><b>Lng:</b> ${lng.toFixed(6)}`)
            .openPopup();
    });
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
.then(instance => { editor = instance; })
.catch(error => { console.error(error); });
</script>
@endsection