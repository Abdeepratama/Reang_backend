<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Aplikasi Wong Reang</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8; /* Warna latar belakang yang lembut */
        }
        .gradient-bg {
            background: linear-gradient(to right, #4a90e2, #50b3e8); /* Gradien biru cerah */
        }
        .card-shadow {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-white shadow-md py-4 px-6 md:px-10 flex justify-between items-center rounded-b-lg">
        <div class="flex items-center space-x-3">
            <!-- Placeholder for Government Logo -->
            <img src="https://placehold.co/40x40/4a90e2/ffffff?text=LOGO" alt="Logo Instansi" class="rounded-full">
        </div>
        <nav>
            <a href="{{ route('admin.login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 card-shadow">
                Login Admin
            </a>
        </nav>
    </header>

    <!-- Hero Section -->
    <main class="flex-grow flex items-center justify-center py-12 px-6 md:px-10">
        <div class="text-center max-w-4xl bg-white p-8 md:p-12 rounded-xl card-shadow">
            <h2 class="text-3xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-4">
                Selamat Datang di Halaman Admin
            </h2>
            <p class="text-lg md:text-xl text-gray-600 mb-8">
                Kami berkomitmen untuk menyediakan layanan yang transparan, efisien, dan mudah diakses.
            </p>
            {{-- Tombol "Lihat Layanan Kami" dan "Cari Informasi" dihapus sesuai permintaan --}}
        </div>
    </main>

    <!-- Footer sederhana -->
    <footer class="bg-gray-800 text-white py-4 px-6 text-center">
        <p class="text-gray-500 text-sm">
            &copy; {{ date('Y') }} Dinas Komunikasi Dan Informatika. Semua Hak Cipta Dilindungi.
        </p>
    </footer>

</body>
</html>
