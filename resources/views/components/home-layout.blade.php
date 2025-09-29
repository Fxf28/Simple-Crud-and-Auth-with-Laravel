<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dark .glass-effect {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-neumorphism {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        .dark .glass-neumorphism {
            background: rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.5);
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% {
                transform: translate(0, 0px);
            }

            50% {
                transform: translate(0, -10px);
            }

            100% {
                transform: translate(0, -0px);
            }
        }

        .text-shimmer {
            background: linear-gradient(90deg, #000, #fff, #000);
            background-size: 200% 100%;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 3s infinite;
        }

        .dark .text-shimmer {
            background: linear-gradient(90deg, #fff, #667eea, #fff);
            background-size: 200% 100%;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        .btn-glass {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .btn-glass:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .dark .btn-glass {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dark .btn-glass:hover {
            background: rgba(0, 0, 0, 0.4);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-900 dark:to-blue-900 text-gray-900 dark:text-white min-h-screen">
    <!-- Background Elements -->
    @include('components.background-elements')

    <!-- Navbar -->
    @include('components.navbar', ['maxWidth' => $maxWidth ?? '7xl'])

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    @include('components.footer', ['maxWidth' => $maxWidth ?? '7xl'])

    <!-- Script -->
    <script>
        function showLoginAlert(postTitle = 'this post') {
            if (typeof Swal === 'undefined') {
                console.error('SweetAlert2 is not loaded!');
                if (confirm(`Anda harus login untuk membaca: "${postTitle}"\n\nPergi ke halaman login?`)) {
                    window.location.href = "{{ route('login') }}";
                }
                return;
            }

            Swal.fire({
                title: '🔐 Login Diperlukan',
                html: `Untuk membaca "<b>${postTitle}</b>", silakan login atau daftar akun terlebih dahulu.`,
                icon: 'info',
                showCancelButton: true,
                showCloseButton: true,
                closeButtonHtml: '&times;',
                confirmButtonText: 'Login',
                cancelButtonText: 'Register'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('login') }}";
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    window.location.href = "{{ route('register') }}";
                }
            });
        }
    </script>

    <!-- Additional Scripts -->
    @stack('scripts')
</body>

</html>