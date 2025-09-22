<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                {{ __('Posts') }}
            </h2>
            <a href="{{ route('posts.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow transition-all duration-200 hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <!-- Table Container -->
                    <div class="overflow-hidden rounded-lg">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">
                                        Title
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">
                                        Category
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">
                                        Date
                                    </th>
                                    <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700 dark:text-gray-200">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                @forelse($posts as $post)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-2 h-2 bg-indigo-500 rounded-full"></div>
                                            <span class="font-medium text-gray-900 dark:text-white line-clamp-1">
                                                {{ $post->title }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                            {{ $post->category ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200' }}">
                                            {{ $post->category->name ?? 'Uncategorized' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $post->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <!-- Show Button -->
                                            <a href="{{ route('posts.show', $post) }}"
                                                class="inline-flex items-center p-2 text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 
                                                       transition-colors duration-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600"
                                                title="View Post">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            <!-- Edit Button -->
                                            <a href="{{ route('posts.edit', $post) }}"
                                                class="inline-flex items-center p-2 text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 
                                                       transition-colors duration-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600"
                                                title="Edit Post">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <!-- Delete Button -->
                                            <form method="POST" action="{{ route('posts.destroy', $post) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this post?')"
                                                    class="inline-flex items-center p-2 text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 
                                                           transition-colors duration-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600"
                                                    title="Delete Post">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p class="text-lg font-medium">No posts found</p>
                                            <p class="text-sm mt-1">Get started by creating your first post</p>
                                            <a href="{{ route('posts.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                                Create Post
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($posts->hasPages())
                    <div class="mt-6 border-t border-gray-200 dark:border-gray-600 pt-6">
                        {{ $posts->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>