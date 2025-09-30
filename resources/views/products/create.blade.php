<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Product Create') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form method="POST" action="{{ route('products.store') }}">
                        @csrf

                        {{-- Input Name --}}
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Name
                            </label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                                       shadow-sm focus:border-indigo-500 focus:ring-indigo-500 
                                       sm:text-sm bg-white dark:bg-gray-700 
                                       text-gray-900 dark:text-gray-100">
                            @error('name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Input Price --}}
                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Price
                            </label>
                            <input
                                type="number"
                                name="price"
                                id="price"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                                       shadow-sm focus:border-indigo-500 focus:ring-indigo-500 
                                       sm:text-sm bg-white dark:bg-gray-700 
                                       text-gray-900 dark:text-gray-100">
                            @error('price')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Input Description --}}
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Description
                            </label>
                            <textarea
                                name="description"
                                id="description"
                                rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                                       shadow-sm focus:border-indigo-500 focus:ring-indigo-500 
                                       sm:text-sm bg-white dark:bg-gray-700 
                                       text-gray-900 dark:text-gray-100"></textarea>
                            @error('description')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Submit Button --}}
                        <div>
                            <button
                                type="submit"
                                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 
                                       text-white rounded-md shadow-sm 
                                       focus:outline-none focus:ring-2 focus:ring-offset-2 
                                       focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>