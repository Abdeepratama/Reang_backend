@extends('admin.partials.app')

@section('title', 'Edit Tempat Plesir')

@section('content')
<div class="container-fluid px-4">
    <h4 class="mt-4 mb-4">Edit Tempat Plesir</h4>

    <form action="{{ route('admin.plesir.tempat.update', $item->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- FORM -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Tempat</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $item->name }}" required>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <input type="text" id="address" name="address" class="form-control" value="{{ old('address', $item->address ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="latitude" class="form-label">Latitude</label>
                    <input type="text" name="latitude" id="latitude" class="form-control" value="{{ $item->latitude }}" required readonly>
                </div>

                <div class="mb-3">
                    <label for="longitude" class="form-label">Longitude</label>
                    <input type="text" name="longitude" id="longitude" class="form-control" value="{{ $item->longitude }}" required readonly>
                </div>

                <select name="fitur" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoriPlesir as $kategori)
                    <option value="{{ $kategori->nama }}" {{ $item->fitur == $kategori->nama ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                    @endforeach
                </select>

                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <div class="mb-2">
                        @if($item->foto)
                        <img id="currentPreview" src="{{ Storage::url($item->foto) }}" alt="Foto {{ $item->name }}" style="max-width:150px; height:auto; border:1px solid #ddd; padding:4px;">
                        @else
                        <img id="currentPreview" src="{{ asset('images/default-plesir.jpg') }}" alt="Default" style="max-width:150px; height:auto; border:1px solid #ddd; padding:4px;">
                        @endif
                    </div>
                    <input type="file" name="foto" id="fotoInput" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn btn-primary">Update Tempat</button>
            </div>

            <!-- PETA -->
            <div class="col-md-6">
                <label for="peta" class="form-label">Klik Peta untuk memilih lokasi</label>
                <div class="mb-3" style="height: 450px;">
                    <div id="peta" style="height: 100%; width: 100%; border: 1px solid #ccc; border-radius: 10px;"></div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    const map = L.map('peta').setView([-6.326511, 108.3202685], 13);
    let clickMarker = null;

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    const currentLat = parseFloat(`{{ $item->latitude }}`);
    const currentLng = parseFloat(`{{ $item->longitude }}`);
    const currentName = `{{ $item->name }}` || 'Lokasi Saat Ini';

    if (!isNaN(currentLat) && !isNaN(currentLng)) {
        clickMarker = L.marker([currentLat, currentLng]).addTo(map)
            .bindPopup(`<b>${currentName}</b><br>Latitude: ${currentLat}<br>Longitude: ${currentLng}`)
            .openPopup();
        map.setView([currentLat, currentLng], 16);
    }

    map.on('click', async function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;

        if (clickMarker) {
            map.removeLayer(clickMarker);
        }

        clickMarker = L.marker([lat, lng]).addTo(map);
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        try {
            const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
            const data = await response.json();
            const address = data.display_name || 'Alamat tidak ditemukan';
            document.getElementById('address').value = address;
            clickMarker.bindPopup(address).openPopup();
        } catch (err) {
            console.error('Gagal mengambil alamat:', err);
        }
    });
</script>
@endsection