@props(['maxWidth' => '7xl'])

<footer class="glass-effect border-t border-gray-200 dark:border-gray-800 mt-12 py-8">
    <div class="max-w-{{ $maxWidth }} mx-auto px-4 text-center">
        <div class="flex justify-center items-center space-x-6 mb-4">
            <a href="#" class="p-3 rounded-xl glass-neumorphism hover-lift transition-all duration-300">
                <i class="fab fa-twitter text-blue-400 text-lg"></i>
            </a>
            <a href="#" class="p-3 rounded-xl glass-neumorphism hover-lift transition-all duration-300">
                <i class="fab fa-github text-gray-700 dark:text-gray-300 text-lg"></i>
            </a>
            <a href="#" class="p-3 rounded-xl glass-neumorphism hover-lift transition-all duration-300">
                <i class="fab fa-linkedin text-blue-600 text-lg"></i>
            </a>
        </div>

        <p class="text-gray-600 dark:text-gray-400">
            &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}.
            <span class="text-shimmer">Crafted with passion</span>
        </p>
    </div>
</footer>