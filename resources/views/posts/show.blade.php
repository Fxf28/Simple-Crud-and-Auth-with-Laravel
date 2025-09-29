<x-home-layout maxWidth="4xl">
    <x-slot name="title">{{ $post->title }} - {{ config('app.name', 'Laravel') }}</x-slot>

    <!-- Floating Elements -->
    <div class="floating absolute left-10 w-8 h-8 bg-blue-200 dark:bg-blue-800 rounded-full opacity-30"></div>
    <div class="floating absolute right-10 w-6 h-6 bg-purple-200 dark:bg-purple-800 rounded-full opacity-40" style="animation-delay: 1s;"></div>

    <article class="glass-neumorphism rounded-3xl overflow-hidden hover-lift transition-all duration-500">
        <!-- Featured Image -->
        @if($post->image_public_id)
        <div class="relative w-full h-64 md:h-96 overflow-hidden">
            <img
                src="{{ $post->image_url }}"
                class="w-full h-full object-cover"
                alt="{{ $post->title }}" />
            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
            <!-- Category Badge -->
            <div class="absolute top-6 left-6">
                <span class="px-4 py-2 glass-effect text-white font-medium rounded-2xl text-sm backdrop-blur-sm">
                    <i class="fas fa-tag mr-2"></i>
                    {{ $post->category->name ?? 'Uncategorized' }}
                </span>
            </div>
        </div>
        @else
        <div class="relative w-full h-48 bg-gradient-to-br from-blue-400 to-purple-600 flex items-center justify-center">
            <i class="fas fa-feather text-white text-5xl"></i>
            <!-- Category Badge -->
            <div class="absolute top-6 left-6">
                <span class="px-4 py-2 glass-effect text-white font-medium rounded-2xl text-sm backdrop-blur-sm">
                    <i class="fas fa-tag mr-2"></i>
                    {{ $post->category->name ?? 'Uncategorized' }}
                </span>
            </div>
        </div>
        @endif

        <!-- Post Header -->
        <div class="p-8">
            <!-- Meta Information -->
            <div class="flex flex-wrap items-center justify-between mb-6 gap-4">
                <div class="flex items-center space-x-4 text-sm">
                    <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-300">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium">{{ $post->user->name ?? 'Unknown Author' }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Author</div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-300">
                        <div class="w-10 h-10 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar text-white text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium">{{ $post->created_at->format('M j, Y') }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Published</div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-300">
                        <div class="w-10 h-10 bg-gradient-to-r from-orange-400 to-pink-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-clock text-white text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium">{{ $post->updated_at->format('M j, Y') }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Updated</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Title -->
            <h1 class="text-4xl lg:text-5xl font-bold mb-6 leading-tight">
                <span class="gradient-text">{{ $post->title }}</span>
            </h1>
        </div>

        <!-- Post Body -->
        <div class="px-8 pb-8">
            <div class="prose dark:prose-invert max-w-none text-lg leading-relaxed">
                <div class="glass-effect rounded-3xl p-8 backdrop-blur-sm">
                    <div class="text-gray-700 dark:text-gray-300 whitespace-pre-line leading-loose">
                        {{ $post->text }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Post Footer -->
        <div class="border-t border-gray-200 dark:border-gray-700 p-8">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-6">
                <!-- Back Button -->
                <a href="{{ route('home') }}"
                    class="group px-6 py-3 btn-glass rounded-2xl font-medium transition-all duration-300 flex items-center space-x-3">
                    <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform duration-300"></i>
                    <span>Back to Home</span>
                </a>

                <!-- Edit & Delete Buttons - Hanya untuk pemilik post atau admin -->
                @auth
                @if($post->user_id === auth()->id() || auth()->user()->is_admin)
                <div class="flex items-center space-x-4">
                    <a href="{{ route('posts.edit', $post) }}"
                        class="group px-6 py-3 bg-gradient-to-r from-green-400 to-blue-500 text-white rounded-2xl hover-lift font-medium transition-all duration-300 flex items-center space-x-3 shadow-lg">
                        <i class="fas fa-edit group-hover:rotate-12 transition-transform duration-300"></i>
                        <span>Edit Post</span>
                        @if(auth()->user()->is_admin && $post->user_id !== auth()->id())
                        <span class="text-xs bg-orange-500 px-2 py-1 rounded-full">Admin</span>
                        @endif
                    </a>

                    <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="group px-6 py-3 bg-gradient-to-r from-red-400 to-pink-500 text-white rounded-2xl hover-lift font-medium transition-all duration-300 flex items-center space-x-3 shadow-lg">
                            <i class="fas fa-trash group-hover:scale-110 transition-transform duration-300"></i>
                            <span>Delete</span>
                            @if(auth()->user()->is_admin && $post->user_id !== auth()->id())
                            <span class="text-xs bg-orange-500 px-2 py-1 rounded-full">Admin</span>
                            @endif
                        </button>
                    </form>
                </div>
                @endif
                @endauth
            </div>
        </div>
    </article>

    <!-- Navigation -->
    <div class="flex justify-between items-center mt-8 gap-4">
        @if($previousPost)
        <a href="{{ route('posts.show', $previousPost) }}"
            class="group flex items-center space-x-4 px-6 py-4 glass-neumorphism rounded-2xl hover-lift transition-all duration-300 flex-1 max-w-md">
            <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-purple-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-arrow-left text-white"></i>
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Previous Post</div>
                <div class="font-semibold truncate">{{ Str::limit($previousPost->title, 40) }}</div>
            </div>
        </a>
        @else
        <div class="flex-1"></div>
        @endif

        @if($nextPost)
        <a href="{{ route('posts.show', $nextPost) }}"
            class="group flex items-center space-x-4 px-6 py-4 glass-neumorphism rounded-2xl hover-lift transition-all duration-300 flex-1 max-w-md text-right">
            <div class="flex-1 min-w-0">
                <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Next Post</div>
                <div class="font-semibold truncate">{{ Str::limit($nextPost->title, 40) }}</div>
            </div>
            <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-arrow-right text-white"></i>
            </div>
        </a>
        @endif
    </div>
</x-home-layout>