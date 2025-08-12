@extends('admin.partials.app')

@section('title', 'Peta Info Plesir')

@section('content')
<div class="container mt-4">
    <h2>Peta Info Plesir</h2>
    <div id="peta" style="height: 600px; border-radius: 10px; border: 1px solid #ccc;"></div>
</div>
@endsection

@section('scripts')
<script>
    const lokasi = @json($lokasi);

    const map = L.map('peta').setView([-2.5, 118], 5);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    const iconInfo = L.divIcon({
        html: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="36" height="36" fill="#e76f51" stroke="white" stroke-width="2">
            <circle cx="32" cy="32" r="28" />
            <text x="32" y="40" text-anchor="middle" font-size="28" fill="white" font-family="Arial" font-weight="bold">i</text>
        </svg>`,
        className: '',
        iconSize: [36, 36],
        iconAnchor: [18, 36],
        popupAnchor: [0, -36]
    });

    lokasi.forEach(item => {
        const lat = parseFloat(item.latitude);
        const lng = parseFloat(item.longitude);

        if (!isNaN(lat) && !isNaN(lng)) {
            const marker = L.marker([lat, lng], { icon: iconInfo }).addTo(map);

            let fotoHtml = item.foto 
                ? `<img src="${item.foto}" alt="Foto ${item.name}" style="max-width:150px; border-radius:6px; margin-top:5px;">`
                : '';

            const popupContent = `
                <strong>${item.name}</strong><br>
                <em>${item.address || '-'}</em><br>
                ${fotoHtml}
                <br>Fitur: ${item.fitur || '-'}
                <br>Rating: ${item.rating ?? '-'}
            `;

            marker.bindPopup(popupContent);
        }
    });

    // Zoom agar semua marker terlihat
    const group = new L.featureGroup(
        lokasi
        .filter(item => !isNaN(parseFloat(item.latitude)) && !isNaN(parseFloat(item.longitude)))
        .map(item => L.marker([parseFloat(item.latitude), parseFloat(item.longitude)]))
    );

    if(group.getLayers().length > 0){
        map.fitBounds(group.getBounds().pad(0.2));
    }
</script>
@endsection
