@extends('admin.partials.app')

@section('title', 'Edit Info Keagamaan')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-book"></i> Edit Info Keagamaan</h2>

    <form action="{{ route('admin.ibadah.info.update', $info->id) }}" method="POST" enctype="multipart/form-data">
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

                <div class="form-group mb-3">
                    <label>Waktu</label>
                    <input type="time" name="waktu" class="form-control" 
                           value="{{ old('waktu', $info->waktu) }}" required>
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
                        @foreach($kategoriIbadah as $kategori)
                            <option value="{{ $kategori->nama }}" 
                                {{ old('fitur', $info->fitur) == $kategori->nama ? 'selected' : '' }}>
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
                        <img src="{{ asset('storage/' . $info->foto) }}" alt="Foto" 
                             width="150" style="border-radius:8px; margin-top:5px;">
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3" required>{{ old('deskripsi', $info->deskripsi) }}</textarea>
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
@endsection
