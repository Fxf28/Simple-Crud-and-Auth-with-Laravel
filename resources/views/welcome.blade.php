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
    <main class="max-w-6xl mx-auto p-4 py-8">
        <h2 class="text-3xl font-bold text-center mb-8">Latest Posts</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($posts as $post)
            <div class="bg-white dark:bg-gray-800 border rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300">
                <!-- Post Image -->
                @if($post->image_public_id)
                <div class="h-48 bg-gray-200 dark:bg-gray-700 overflow-hidden">
                    <img
                        src="{{ $post->image_url }}"
                        width="400"
                        height="200"
                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                        alt="{{ $post->title }}" />
                </div>
                @else
                <div class="h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                @endif

                <div class="p-6">
                    <div class="flex justify-between mb-3">
                        <span class="bg-blue-500 text-white px-2 py-1 text-sm rounded">
                            {{ $post->category->name ?? 'Uncategorized' }}
                        </span>
                        <span class="text-sm text-gray-500">{{ $post->created_at->format('M d, Y') }}</span>
                    </div>

                    <h3 class="text-lg font-semibold mb-3 line-clamp-2">{{ $post->title }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">{{ Str::limit($post->text, 120) }}</p>

                    <a href="{{ route('posts.show', $post) }}" class="inline-flex items-center text-blue-500 hover:text-blue-600 font-medium transition-colors duration-200">
                        Read More
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-8">
                <div class="flex flex-col items-center justify-center text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-lg font-medium">No posts available yet</p>
                    <p class="text-sm mt-1">Check back later for new content</p>
                </div>
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