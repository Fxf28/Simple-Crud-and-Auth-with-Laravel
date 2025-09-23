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
                    <form method="POST" action="{{ route('posts.update', $post) }}" class="space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                            <input type="text" name="title" id="title"
                                value="{{ old('title', $post->title) }}"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 
                                          focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Text -->
                        <div>
                            <label for="text" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Text</label>
                            <textarea name="text" id="text" rows="5"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 
                                             focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>{{ old('text', $post->text) }}</textarea>
                            @error('text')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image Upload dengan Preview -->
                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Image
                            </label>

                            <!-- Preview Section -->
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Current Image:</p>
                                @if($post->image_public_id)
                                <div id="current-image-container">
                                    <img src="{{ $post->image_url }}" class="w-64 h-48 object-cover rounded-md border border-gray-300 dark:border-gray-600" alt="Current Image">
                                </div>
                                @else
                                <p class="text-yellow-500 text-sm">No image uploaded</p>
                                @endif

                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2 mt-4">New Image Preview:</p>
                                <img id="new-image-preview" src="" alt="New Image Preview"
                                    class="w-64 h-48 object-cover rounded-md border border-gray-300 dark:border-gray-600 hidden">
                            </div>

                            <input
                                type="file"
                                id="image"
                                name="image"
                                accept="image/*"
                                class="block w-full text-gray-700 dark:text-gray-300 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800
               file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-500 file:text-white file:font-semibold
               file:cursor-pointer hover:file:bg-blue-600 transition-all shadow-sm dark:shadow-none"
                                onchange="previewImage(event)" />

                            @error('image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Leave empty to keep current image</p>
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                            <select name="category_id" id="category_id"
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 
                                           focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Save Button -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('posts.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md 
                                           font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 
                                           focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 
                                           focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fas fa-arrow-left mr-2"></i> Back
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md 
                                           font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 
                                           focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 
                                           focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fas fa-save mr-2"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('new-image-preview');
            const currentImageContainer = document.getElementById('current-image-container');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');

                    // Sembunyikan gambar lama jika ada gambar baru
                    if (currentImageContainer) {
                        currentImageContainer.style.opacity = '0.5';
                    }
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.classList.add('hidden');
                if (currentImageContainer) {
                    currentImageContainer.style.opacity = '1';
                }
            }
        }
    </script>
</x-app-layout>