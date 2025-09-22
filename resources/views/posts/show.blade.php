<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $post->title }} - {{ config('app.name', 'Laravel') }}</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-white dark:bg-black text-gray-900 dark:text-white min-h-screen">
    <!-- Header -->
    <header class="sticky top-0 bg-white dark:bg-black border-b p-4">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
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

    <!-- Post Content -->
    <main class="max-w-4xl mx-auto p-4 py-8">
        <article class="bg-white dark:bg-gray-800 rounded-lg shadow-lg">
            <!-- Post Header -->
            <div class="border-b p-6">
                <div class="flex justify-between items-start mb-4">
                    <span class="bg-blue-500 text-white px-3 py-1 rounded text-sm">
                        {{ $post->category->name ?? 'Uncategorized' }}
                    </span>
                    <span class="text-gray-500 text-sm">{{ $post->created_at->format('F j, Y') }}</span>
                </div>

                <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>

                <div class="flex items-center gap-4 text-sm text-gray-500">
                    <span>Posted on {{ $post->created_at->format('M j, Y') }}</span>
                    <span>•</span>
                    <span>Last updated {{ $post->updated_at->format('M j, Y') }}</span>
                </div>
            </div>

            <!-- Post Body -->
            <div class="p-6 prose dark:prose-invert max-w-none">
                <div class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                    {{ $post->text }}
                </div>
            </div>

            <!-- Post Footer -->
            <div class="border-t p-6">
                <div class="flex justify-between items-center">
                    <a href="{{ route('home') }}" class="text-blue-500 hover:text-blue-600 font-medium">
                        ← Back
                    </a>

                    @auth
                    <div class="flex gap-2">
                        <a href="{{ route('posts.edit', $post) }}" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                            Edit
                        </a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                Delete
                            </button>
                        </form>
                    </div>
                    @endauth
                </div>
            </div>
        </article>

        <!-- Navigation -->
        <!-- Navigation -->
        <div class="flex justify-between mt-8">
            @if($previousPost)
            <a href="{{ route('posts.show', $previousPost) }}" class="flex items-center gap-2 text-blue-500 hover:text-blue-600">
                ← Previous Post
            </a>
            @else
            <div></div>
            @endif

            @if($nextPost)
            <a href="{{ route('posts.show', $nextPost) }}" class="flex items-center gap-2 text-blue-500 hover:text-blue-600">
                Next Post →
            </a>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-100 dark:bg-gray-900 border-t mt-8 py-6">
        <div class="max-w-4xl mx-auto text-center">
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

            localStorage.setItem('theme', document.body.classList.contains('dark') ? 'dark' : 'light');
        });

        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark');
            document.getElementById('themeToggle').querySelector('i').classList.replace('fa-moon', 'fa-sun');
        }
    </script>
</body>

</html>