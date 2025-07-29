<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Web' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>{{ $title ?? 'Halaman Web' }}</h1>
        <p>Selamat datang di halaman pemetaan.</p>

        <a href="{{ route('map') }}" class="btn btn-primary">Lihat Peta</a>
    </div>
</body>
</html>
