<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Semua Fitur Aplikasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
    .hover-shadow:hover {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        transition: 0.3s;
    }

    .icon-size {
        font-size: 2rem;
        line-height: 1;
    }

    .icon-box {
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4 text-center">Semua Modul Aplikasi</h2>

    <div class="row g-3">

        <!-- Ibadah-Yu -->
<div class="col-md-3 col-6">
    <a href="{{ route('admin.ibadah.index') }}" class="text-decoration-none">
        <div class="p-3 border rounded text-center hover-shadow">
            <div class="icon-box">
                <i class="fas fa-mosque text-primary icon-size"></i>
            </div>
            <p class="mb-0 mt-2 text-primary">Ibadah-Yu</p>
        </div>
    </a>
</div>

<!-- Sehat-Yu -->
<div class="col-md-3 col-6">
    <a href="{{ route('admin.sehat.index') }}" class="text-decoration-none">
        <div class="p-3 border rounded text-center hover-shadow">
            <div class="icon-box">
                <i class="bi bi-heart-pulse text-success icon-size"></i>
            </div>
            <p class="mb-0 mt-2 text-success">Sehat-Yu</p>
        </div>
    </a>
</div>

        <!-- Pasar-Yu -->
<div class="col-md-3 col-6">
    <a href="{{ route('admin.pasar.index') }}" class="text-decoration-none">
        <div class="p-3 border rounded text-center hover-shadow">
            <div class="icon-box">
                <i class="bi bi-cart text-warning icon-size"></i>
            </div>
            <p class="mb-0 mt-2 text-warning">Pasar-Yu</p>
        </div>
    </a>
</div>

<!-- Plesir-Yu -->
<div class="col-md-3 col-6">
    <a href="{{ route('admin.plesir.index') }}" class="text-decoration-none">
        <div class="p-3 border rounded text-center hover-shadow">
            <div class="icon-box">
                <i class="bi bi-geo-alt text-info icon-size"></i>
            </div>
            <p class="mb-0 mt-2 text-info">Plesir-Yu</p>
        </div>
    </a>
</div>

<!-- Sekolah-Yu -->
<div class="col-md-3 col-6">
    <a href="{{ route('admin.sekolah.index') }}" class="text-decoration-none">
        <div class="p-3 border rounded text-center hover-shadow">
            <div class="icon-box">
                <i class="bi bi-book text-danger icon-size"></i>
            </div>
            <p class="mb-0 mt-2 text-danger">Sekolah-Yu</p>
        </div>
    </a>
</div>

<!-- DUMAS-Yu -->
<div class="col-md-3 col-6">
    <a href="{{ route('admin.dumas.index') }}" class="text-decoration-none">
        <div class="p-3 border rounded text-center hover-shadow">
            <div class="icon-box">
                <i class="bi bi-chat-left-text text-secondary icon-size"></i>
            </div>
            <p class="mb-0 mt-2 text-secondary">DUMAS-Yu</p>
        </div>
    </a>
</div>

<!-- Adminduk-Yu -->
<div class="col-md-3 col-6">
    <a href="{{ route('admin.adminduk.index') }}" class="text-decoration-none">
        <div class="p-3 border rounded text-center hover-shadow">
            <div class="icon-box">
                <i class="bi bi-card-list text-success icon-size"></i>
            </div>
            <p class="mb-0 mt-2 text-success">Adminduk-Yu</p>
        </div>
    </a>
</div>

<!-- Info-Yu -->
<div class="col-md-3 col-6">
    <a href="{{ route('admin.info.index') }}" class="text-decoration-none">
        <div class="p-3 border rounded text-center hover-shadow">
            <div class="icon-box">
                <i class="bi bi-info-circle text-primary icon-size"></i>
            </div>
            <p class="mb-0 mt-2 text-primary">Info-Yu</p>
        </div>
    </a>
</div>

<!-- Izin-Yu -->
<div class="col-md-3 col-6">
    <a href="{{ route('admin.izin.index') }}" class="text-decoration-none">
        <div class="p-3 border rounded text-center hover-shadow">
            <div class="icon-box">
                <i class="bi bi-shield-check text-info icon-size"></i>
            </div>
            <p class="mb-0 mt-2 text-info">Izin-Yu</p>
        </div>
    </a>
</div>

<!-- Kerja-Yu -->
<div class="col-md-3 col-6">
    <a href="{{ route('admin.kerja.index') }}" class="text-decoration-none">
        <div class="p-3 border rounded text-center hover-shadow">
            <div class="icon-box">
                <i class="bi bi-briefcase text-secondary icon-size"></i>
            </div>
            <p class="mb-0 mt-2 text-secondary">Kerja-Yu</p>
        </div>
    </a>
</div>

<!-- Pajak-Yu -->
<div class="col-md-3 col-6">
    <a href="{{ route('admin.pajak.index') }}" class="text-decoration-none">
        <div class="p-3 border rounded text-center hover-shadow">
            <div class="icon-box">
                <i class="bi bi-receipt text-dark icon-size"></i>
            </div>
            <p class="mb-0 mt-2 text-dark">Pajak-Yu</p>
        </div>
    </a>
</div>

<!-- Renbang-Yu -->
<div class="col-md-3 col-6">
    <a href="{{ route('admin.renbang.index') }}" class="text-decoration-none">
        <div class="p-3 border rounded text-center hover-shadow">
            <div class="icon-box">
                <i class="bi bi-building text-warning icon-size"></i>
            </div>
            <p class="mb-0 mt-2 text-warning">Renbang-Yu</p>
        </div>
    </a>
</div>

<!-- Wifi-Yu -->
<div class="col-md-3 col-6">
    <a href="{{ route('admin.wifi.index') }}" class="text-decoration-none">
        <div class="p-3 border rounded text-center hover-shadow">
            <div class="icon-box">
                <i class="bi bi-wifi text-dark icon-size"></i>
            </div>
            <p class="mb-0 mt-2 text-dark">Wifi-Yu</p>
        </div>
    </a>
</div>

    </div>
</div>

<!-- Script Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
