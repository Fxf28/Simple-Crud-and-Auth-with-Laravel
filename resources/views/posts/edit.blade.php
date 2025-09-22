<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('posts.update', $post) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                            <input type="text" name="title" id="title"
                                value="{{ $post->title }}"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 
                                          focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        </div>

                        <!-- Text -->
                        <div>
                            <label for="text" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Text</label>
                            <textarea name="text" id="text" rows="5"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 
                                             focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>{{ $post->text }}</textarea>
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                            <select name="category_id" id="category_id"
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 
                                           focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected($category->id == $post->category_id)>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Save Button -->
                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md 
                                           font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 
                                           focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 
                                           focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fas fa-save mr-2"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>