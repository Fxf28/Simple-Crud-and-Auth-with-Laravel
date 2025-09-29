<x-home-layout maxWidth="7xl">
    <x-slot name="title">{{ config('app.name', 'Laravel') }}</x-slot>

    <!-- Hero Section -->
    <section class="relative py-20 lg:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <!-- Floating Elements -->
            <div class="floating absolute top-10 left-10 w-20 h-20 bg-blue-200 dark:bg-blue-800 rounded-full opacity-20"></div>
            <div class="floating absolute top-20 right-20 w-16 h-16 bg-purple-200 dark:bg-purple-800 rounded-full opacity-30" style="animation-delay: 1s;"></div>
            <div class="floating absolute bottom-20 left-20 w-12 h-12 bg-pink-200 dark:bg-pink-800 rounded-full opacity-25" style="animation-delay: 2s;"></div>

            <div class="relative z-10">
                <h1 class="text-5xl lg:text-7xl font-bold mb-6">
                    <span class="text-shimmer">Welcome to</span>
                    <br>
                    <span class="gradient-text">The Future</span>
                    <span class="text-shimmer"> of Blogging</span>
                </h1>

                <p class="text-xl lg:text-2xl text-gray-600 dark:text-gray-300 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Explore cutting-edge content powered by AI and built with modern technology.
                    Join our community of innovators and thought leaders.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    @auth
                    <a href="{{ url('/dashboard') }}"
                        class="group px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-2xl hover-lift font-semibold text-lg transition-all duration-300 shadow-2xl">
                        <span class="flex items-center">
                            <i class="fas fa-rocket mr-3 group-hover:rotate-45 transition-transform duration-300"></i>
                            Launch Dashboard
                        </span>
                    </a>
                    @else
                    <a href="{{ route('register') }}"
                        class="group px-8 py-4 bg-gradient-to-r from-green-400 to-blue-500 text-white rounded-2xl hover-lift font-semibold text-lg transition-all duration-300 shadow-2xl">
                        <span class="flex items-center">
                            <i class="fas fa-star mr-3 group-hover:scale-110 transition-transform duration-300"></i>
                            Start Your Journey
                        </span>
                    </a>
                    <a href="{{ route('login') }}"
                        class="group px-8 py-4 glass-effect rounded-2xl hover-lift font-semibold text-lg transition-all duration-300">
                        <span class="flex items-center">
                            <i class="fas fa-sign-in-alt mr-3 group-hover:translate-x-1 transition-transform duration-300"></i>
                            Sign In
                        </span>
                    </a>
                    @endauth
                </div>

                <!-- Stats -->
                <div class="mt-16 grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-2xl mx-auto">
                    <div class="glass-effect rounded-2xl p-6 hover-lift">
                        <div class="text-3xl font-bold text-blue-500 mb-2">{{ $posts->count() }}+</div>
                        <div class="text-gray-600 dark:text-gray-300">Articles Published</div>
                    </div>
                    <div class="glass-effect rounded-2xl p-6 hover-lift">
                        <div class="text-3xl font-bold text-purple-500 mb-2">24/7</div>
                        <div class="text-gray-600 dark:text-gray-300">Available</div>
                    </div>
                    <div class="glass-effect rounded-2xl p-6 hover-lift">
                        <div class="text-3xl font-bold text-green-500 mb-2">AI</div>
                        <div class="text-gray-600 dark:text-gray-300">Powered</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Posts -->
    <section class="py-20 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold mb-4">
                    <span class="gradient-text">Featured</span>
                    <span class="text-shimmer"> Content</span>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    Discover the latest insights and innovations from our community of creators
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($posts as $post)
                <article class="group glass-effect rounded-3xl overflow-hidden hover-lift transition-all duration-500">
                    <!-- Post Image with Gradient Overlay -->
                    @if($post->image_public_id)
                    <div class="relative h-48 overflow-hidden">
                        <img
                            src="{{ $post->image_url }}"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                            alt="{{ $post->title }}" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-blue-500 text-white text-sm font-medium rounded-full">
                                {{ $post->category->name ?? 'Uncategorized' }}
                            </span>
                        </div>
                    </div>
                    @else
                    <div class="relative h-48 bg-gradient-to-br from-blue-400 to-purple-600 flex items-center justify-center">
                        <i class="fas fa-feather text-white text-4xl"></i>
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-white/20 text-white text-sm font-medium rounded-full backdrop-blur-sm">
                                {{ $post->category->name ?? 'Uncategorized' }}
                            </span>
                        </div>
                    </div>
                    @endif

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                                <i class="fas fa-user-circle"></i>
                                <span>{{ $post->user->name ?? 'Unknown Author' }}</span>
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                <i class="fas fa-clock mr-1"></i>
                                {{ $post->created_at->format('M d, Y') }}
                            </div>
                        </div>

                        <h3 class="text-xl font-bold mb-3 line-clamp-2 group-hover:text-blue-500 dark:group-hover:text-blue-400 transition-colors duration-300">
                            {{ $post->title }}
                        </h3>

                        <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3 leading-relaxed">
                            {{ Str::limit($post->text, 120) }}
                        </p>

                        <div class="flex items-center justify-between">
                            @auth
                            <a href="{{ route('posts.show', $post) }}"
                                class="inline-flex items-center text-blue-500 hover:text-blue-600 font-semibold transition-all duration-300 group/read">
                                Read More
                                <i class="fas fa-arrow-right ml-2 transform group-hover/read:translate-x-1 transition-transform duration-300"></i>
                            </a>
                            @else
                            <!-- For guests - SweetAlert trigger -->
                            <button onclick="showLoginAlert('{{ addslashes($post->title) }}')"
                                class="inline-flex items-center text-blue-500 hover:text-blue-600 font-semibold transition-all duration-300 group/read cursor-pointer">
                                Read More
                                <i class="fas fa-arrow-right ml-2 transform group-hover/read:translate-x-1 transition-transform duration-300"></i>
                            </button>
                            @endauth

                            @auth
                            @if($post->user_id === auth()->id() || auth()->user()->is_admin)
                            <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <a href="{{ route('posts.edit', $post) }}"
                                    class="p-2 text-green-500 hover:text-green-600 transition-colors duration-300"
                                    title="Edit Post">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                            @endif
                            @endauth
                        </div>
                    </div>
                </article>
                @empty
                <div class="col-span-full text-center py-16">
                    <div class="glass-effect rounded-3xl p-12 max-w-md mx-auto">
                        <i class="fas fa-feather text-6xl text-gray-400 mb-4"></i>
                        <h3 class="text-2xl font-bold text-gray-600 dark:text-gray-300 mb-2">No Content Yet</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-6">Be the first to create amazing content!</p>
                        @auth
                        <a href="{{ route('posts.create') }}"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-2xl hover-lift font-semibold">
                            <i class="fas fa-plus mr-2"></i>
                            Create Post
                        </a>
                        @else
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-400 to-blue-500 text-white rounded-2xl hover-lift font-semibold">
                            <i class="fas fa-user-plus mr-2"></i>
                            Join Now
                        </a>
                        @endauth
                    </div>
                </div>
                @endforelse
            </div>

            <!-- CTA Section -->
            @if($posts->count() > 0)
            <div class="text-center mt-16">
                <div class="glass-effect rounded-3xl p-12 max-w-4xl mx-auto">
                    <h3 class="text-3xl font-bold mb-4 gradient-text">Ready to Share Your Story?</h3>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mb-8">
                        Join our community of innovators and start creating amazing content today.
                    </p>
                    @auth
                    <a href="{{ route('posts.create') }}"
                        class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-2xl hover-lift font-semibold text-lg shadow-2xl">
                        <i class="fas fa-pen-fancy mr-3"></i>
                        Start Writing
                    </a>
                    @else
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-2xl hover-lift font-semibold text-lg shadow-2xl">
                            <i class="fas fa-rocket mr-3"></i>
                            Get Started Free
                        </a>
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center px-8 py-4 glass-effect rounded-2xl hover-lift font-semibold text-lg">
                            <i class="fas fa-sign-in-alt mr-3"></i>
                            Sign In
                        </a>
                    </div>
                    @endauth
                </div>
            </div>
            @endif
        </div>
    </section>

    <x-slot name="scripts">
        <script>
            // Additional animations hanya untuk home page
            document.addEventListener('DOMContentLoaded', function() {
                const observerOptions = {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                };

                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('animate-fade-in-up');
                        }
                    });
                }, observerOptions);

                document.querySelectorAll('article').forEach(card => {
                    card.classList.add('opacity-0', 'transform', 'translate-y-8');
                    card.style.transition = 'all 0.6s ease-out';
                    observer.observe(card);
                });
            });
        </script>
    </x-slot>
</x-home-layout>