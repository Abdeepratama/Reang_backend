<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Wong Reang - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background: #0e6fd1ff;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.5);
        }
        .sidebar .nav-link:hover {
            color: rgba(255,255,255,.75);
        }
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,.1);
        }
    </style>
    <style>
        #peta {
            height: 600px;
            width: 100%;
            margin-top: 10px;
        }

        .leaflet-control-geosearch {
            z-index: 1000;
        }

        .search-controls {
            margin-bottom: 10px;
        }

        input[type="text"] {
            padding: 6px;
            margin-right: 5px;
        }

        button {
            padding: 6px 10px;
        }

        .form-simpan {
            margin-top: 10px;
        }
    </style>

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body>
    <div class="d-flex">
        @include('admin.layouts.sidebar')

        <div class="flex-grow-1">
            @include('admin.layouts.header')

            <main class="container-fluid py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Tambahkan baris ini agar script Leaflet dari child blade tampil --}}
    @stack('scripts')
</body>

</html>
