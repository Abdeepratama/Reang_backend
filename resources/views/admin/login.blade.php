<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login Admin - Wong Reang Apps</title>

    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="css/simplebar.css">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="css/feather.css">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="css/daterangepicker.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="css/app-light.css" id="lightTheme" disabled>
    <link rel="stylesheet" href="css/app-dark.css" id="darkTheme">
    <link rel="icon" href="{{ asset('landing/img/logo_reang.png') }}">

    <!-- Tambahkan CSS anti copy di sini -->
    <style>
        .no-select {
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            pointer-events: none;
        }
    </style>
</head>

<body class="bg-light d-flex align-items-center" style="height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-lg">
                    <div class="card-header text-center">
                        <a class="navbar-brand mx-auto d-block mb-2" href="#">
                            <img src="{{ asset('landing/img/logo_wongreang_apps.png') }}" alt="Logo Reang Apps" style="height:50px;">
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Alert Khusus untuk Error Instansi/Logout Paksa -->
                        @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ route('admin.login.post') }}" id="formLogin">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan Nama" value="{{ old('name') }}" required>
                                @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password" required>
                                @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="showPassword">
                                <label class="form-check-label" for="showPassword">Tampilkan password</label>
                            </div>

                            <div class="mb-3 text-center">
                                <span id="captcha-text"
                                    class="fw-bold h3 d-inline-block px-3 py-2 no-select"
                                    style="color: #000; letter-spacing: 3px; font-weight: 700;">
                                    {{ session('captcha_code') }}
                                </span>
                                <button type="button" id="refresh-captcha"
                                    class="btn btn-sm btn-outline-secondary ms-2">↻</button>
                            </div>

                            <div class="mb-3">
                                <input type="text" name="captcha" class="form-control @error('captcha') is-invalid @enderror" placeholder="Masukkan captcha" required>
                                @error('captcha')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                    <div class="card-footer text-muted text-center">
                        &copy; {{ date('Y') }} Wong Reang
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/simplebar.min.js"></script>
    <script src='js/daterangepicker.js'></script>
    <script src='js/jquery.stickOnScroll.js'></script>
    <script src="js/tinycolor-min.js"></script>
    <script src="js/config.js"></script>
    <script src="js/apps.js"></script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-56159088-1');
    </script>

    <script>
        // --- 1. FITUR REFRESH CAPTCHA AJAX ---
        document.getElementById('refresh-captcha').addEventListener('click', function() {
            fetch("{{ route('captcha.refresh') }}")
                .then(res => res.json())
                .then(data => {
                    document.getElementById('captcha-text').innerText = data.captcha;
                });
        });

        // --- 2. FITUR TAMPILKAN PASSWORD ---
        document.getElementById('showPassword').addEventListener('change', function() {
            const passwordInput = document.getElementById('password');
            passwordInput.type = this.checked ? 'text' : 'password';
        });

        // --- 3. FITUR PERTAHANKAN PASSWORD SAAT ERROR ---
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const formLogin = document.getElementById('formLogin');

            const savedPassword = sessionStorage.getItem('reang_temp_pass');
            if (savedPassword) {
                passwordInput.value = savedPassword;
                sessionStorage.removeItem('reang_temp_pass');
            }

            formLogin.addEventListener('submit', function() {
                sessionStorage.setItem('reang_temp_pass', passwordInput.value);
            });
        });
    </script>

</body>

</html>