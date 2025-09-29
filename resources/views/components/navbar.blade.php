@props(['maxWidth' => '7xl'])

<header class="sticky top-0 glass-effect z-50">
    <div class="max-w-{{ $maxWidth }} mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-blog text-white text-xl"></i>
                </div>
                <span class="text-2xl font-bold gradient-text group-hover:scale-105 transition-transform duration-300">
                    {{ config('app.name', 'Laravel') }}
                </span>
            </a>

            <div class="flex items-center space-x-4">
                <!-- Theme Toggle -->
                <button id="themeToggle" class="p-3 rounded-xl glass-neumorphism hover-lift">
                    <i class="fas fa-moon text-gray-600 dark:text-yellow-300 text-lg"></i>
                </button>

                <!-- Navigation -->
                <nav class="flex items-center space-x-3">
                    @auth
                    <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded-xl glass-neumorphism hover-lift font-medium transition-all duration-300 group">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        Dashboard
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl glass-neumorphism hover-lift font-medium transition-all duration-300 group">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Login
                    </a>
                    @if(Route::has('register'))
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-xl hover-lift font-medium transition-all duration-300 group shadow-lg">
                        <i class="fas fa-user-plus mr-2"></i>
                        Register
                    </a>
                    @endif
                    @endauth
                </nav>
            </div>
        </div>
    </div>
</header>

<script>
    // Theme Toggle Script
    document.addEventListener('DOMContentLoaded', function() {
        const themeToggle = document.getElementById('themeToggle');
        if (themeToggle) {
            themeToggle.addEventListener('click', function() {
                const icon = this.querySelector('i');
                document.body.classList.toggle('dark');

                if (document.body.classList.contains('dark')) {
                    icon.classList.replace('fa-moon', 'fa-sun');
                    icon.classList.add('text-yellow-300');
                    this.classList.add('animate-spin');
                    setTimeout(() => this.classList.remove('animate-spin'), 500);
                } else {
                    icon.classList.replace('fa-sun', 'fa-moon');
                    icon.classList.remove('text-yellow-300');
                }

                localStorage.setItem('theme', document.body.classList.contains('dark') ? 'dark' : 'light');
            });

            // Load saved theme
            if (localStorage.getItem('theme') === 'dark') {
                document.body.classList.add('dark');
                themeToggle.querySelector('i').classList.replace('fa-moon', 'fa-sun');
                themeToggle.querySelector('i').classList.add('text-yellow-300');
            }
        }
    });
</script>