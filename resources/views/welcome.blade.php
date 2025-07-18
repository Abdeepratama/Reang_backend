<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Aplikasi Wong Reang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-white text-gray-800 flex flex-col">

    <!-- Header -->
    <header class="bg-white shadow-md py-4 px-6 md:px-10 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <img src="https://placehold.co/48x48/4a90e2/ffffff?text=LOGO" alt="Logo Instansi" class="rounded-full shadow">
            <h1 class="text-lg font-semibold text-blue-700">Admin Wong Reang</h1>
        </div>
        <a href="{{ route('admin.login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300 shadow">
            Login Admin
        </a>
    </header>

    <!-- Hero Section -->
    <main class="flex-grow flex items-center justify-center py-16 px-6">
        <div class="max-w-3xl w-full text-center bg-white p-8 md:p-12 rounded-2xl shadow-lg">
            <h2 class="text-4xl md:text-5xl font-extrabold text-blue-700 mb-4 leading-snug">
                Selamat Datang di Panel Admin
            </h2>
            <p class="text-lg md:text-xl text-gray-600 mb-8">
                Kelola data aplikasi Wong Reang dengan mudah, cepat, dan efisien.
            </p>
            <!-- Tombol jika suatu hari ingin ditambahkan -->
            <!-- <div class="space-x-4">
                <a href="#" class="bg-blue-600 text-white px-5 py-3 rounded-lg hover:bg-blue-700">Lihat Layanan</a>
                <a href="#" class="border border-blue-600 text-blue-600 px-5 py-3 rounded-lg hover:bg-blue-50">Cari Info</a>
            </div> -->
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t py-4 px-6 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} Dinas Komunikasi dan Informatika. Semua Hak Cipta Dilindungi.
    </footer>

</body>
</html>
