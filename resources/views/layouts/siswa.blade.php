<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YTSS Student Portal</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <!-- Google Fonts: Barlow Condensed & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #050505;
        }
        .heading-font {
            font-family: 'Barlow Condensed', sans-serif;
        }
    </style>
</head>

<body class="text-white selection:bg-orange-500 selection:text-white antialiased">

    <!-- Sidebar & Mobile Menu State -->
    <div x-data="{ mobileMenuOpen: false }">
        <!-- Sidebar -->
        @include('partials.siswa-sidebar')

        <!-- Main Content -->
        <div class="lg:pl-[280px] min-h-screen flex flex-col">
            <!-- Navbar -->
            @include('partials.siswa-navbar')

            <!-- Content Area -->
            <main class="flex-1 p-6 lg:p-10 max-w-7xl w-full mx-auto">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            lucide.createIcons();
        });
    </script>
</body>
</html>