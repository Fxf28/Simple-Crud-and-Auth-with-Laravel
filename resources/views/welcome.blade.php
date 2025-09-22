<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-white dark:bg-black text-gray-900 dark:text-white min-h-screen">
    <!-- Header -->
    <header class="sticky top-0 bg-white dark:bg-black border-b p-4">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600">
                {{ config('app.name', 'Laravel') }}
            </a>

            <div class="flex items-center gap-4">
                <button id="themeToggle" class="p-2">
                    <i class="fas fa-moon"></i>
                </button>

                <nav class="flex gap-2">
                    @auth
                    <a href="{{ url('/dashboard') }}" class="px-3 py-1 border rounded hover:bg-blue-600 hover:text-white">
                        Dashboard
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="px-3 py-1 border rounded hover:bg-blue-600 hover:text-white">
                        Login
                    </a>
                    @if(Route::has('register'))
                    <a href="{{ route('register') }}" class="px-3 py-1 border rounded hover:bg-blue-600 hover:text-white">
                        Register
                    </a>
                    @endif
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero -->
    <section class="bg-gradient-to-r from-blue-500 to-purple-600 text-white text-center py-16">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl font-bold mb-4">Welcome to Our Blog</h1>
            <p class="text-lg mb-8">Discover amazing stories and insights from our community.</p>
            @auth
            <a href="{{ url('/dashboard') }}" class="bg-orange-500 text-white px-6 py-2 rounded-full hover:bg-orange-400">
                Go to Dashboard
            </a>
            @else
            <a href="{{ route('register') }}" class="bg-orange-500 text-white px-6 py-2 rounded-full hover:bg-orange-400">
                Get Started
            </a>
            @endauth
        </div>
    </section>

    <!-- Posts -->
    <main class="max-w-6xl mx-auto p-4">
        <h2 class="text-3xl font-bold text-center mb-8">Latest Posts</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($posts as $post)
            <div class="bg-white dark:bg-gray-800 border rounded-lg p-6 shadow hover:shadow-lg transition">
                <div class="flex justify-between mb-4">
                    <span class="bg-blue-500 text-white px-2 py-1 text-sm rounded">
                        {{ $post->category->name ?? 'Uncategorized' }}
                    </span>
                    <span class="text-sm text-gray-500">{{ $post->created_at->format('M d, Y') }}</span>
                </div>

                <h3 class="text-lg font-semibold mb-3">{{ $post->title }}</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">{{ Str::limit($post->text, 100) }}</p>

                <a href="{{ route('posts.show', $post) }}" class="text-blue-500 hover:text-blue-600 font-medium">
                    Read More →
                </a>
            </div>
            @empty
            <div class="col-span-full text-center py-8">
                <p class="text-gray-500">No posts found.</p>
            </div>
            @endforelse
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-100 dark:bg-gray-900 border-t mt-8 py-6">
        <div class="max-w-6xl mx-auto text-center">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}</p>
        </div>
    </footer>

    <script>
        // Simple dark mode toggle
        document.getElementById('themeToggle').addEventListener('click', function() {
            document.body.classList.toggle('dark');
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-moon');
            icon.classList.toggle('fa-sun');

            // Save preference
            localStorage.setItem('theme', document.body.classList.contains('dark') ? 'dark' : 'light');
        });

        // Load saved theme
        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark');
            document.getElementById('themeToggle').querySelector('i').classList.replace('fa-moon', 'fa-sun');
        }
    </script>
</body>

</html>