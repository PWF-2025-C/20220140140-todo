<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Welcome to Edit Todo Pages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="post" action="{{ route('todo.update', $todo) }}">
                        @csrf
                        @method('patch')

                        {{-- TITLE FIELD --}}
                        <div class="mb-6">
                            <x-input-label for="name" :value="__('Title')" />
                            <x-text-input 
                                id="name" 
                                name="name" 
                                type="text" 
                                class="mt-1 block w-full text-black dark:text-white bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600"
                                :value="old('name', $todo->name)" 
                                required 
                                autofocus 
                                autocomplete="name" 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        {{-- CATEGORY DROPDOWN --}}
                        <div class="mb-6">
                            <x-input-label for="category_id" :value="__('Category')" />
                            <select name="category_id" id="category_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">No Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $todo->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- BUTTONS --}}
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                            <a href="{{ route('todo.index') }}" class="text-gray-500 hover:underline">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
