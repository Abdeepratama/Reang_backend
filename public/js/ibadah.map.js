document.addEventListener('DOMContentLoaded', () => {
    // Pastikan variabel global ada
    const items = window.ibadahItems || [];
    const center = window.mapCenter || [-7.2575, 112.7521];
    
    console.log('Data items:', items);
    console.log('Center:', center);

    // Pastikan elemen map ada
    const mapElement = document.getElementById('map');
    if (!mapElement) {
        console.error('Elemen map tidak ditemukan!');
        return;
    }

    // Cek apakah Leaflet sudah dimuat
    if (typeof L === 'undefined') {
        console.error('Leaflet library tidak ditemukan!');
        return;
    }

    // Inisialisasi peta
    const map = L.map('map').setView(center, 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Tambahkan marker
    items.forEach(item => {
        if (item.latitude && item.longitude) {
            try {
                const lat = parseFloat(item.latitude);
                const lng = parseFloat(item.longitude);
                
                if (isNaN(lat) || isNaN(lng)) {
                    console.error('Koordinat invalid untuk item:', item);
                    return;
                }

                const marker = L.marker([lat, lng]).addTo(map);
                marker.bindPopup(`<b>${item.nama || 'Tanpa Nama'}</b><br>${item.alamat || ''}`);
            } catch (error) {
                console.error('Error membuat marker:', error, item);
            }
        }
    });
});