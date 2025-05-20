<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Category Index') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                
                @if(session('success'))
                    <div class="mb-4 font-medium text-sm text-green-600 px-6 py-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between items-center px-6 py-4 border-b border-gray-600">
                    <h3 class="text-lg font-semibold text-white">Welcome Category Index</h3>
                    <a href="{{ route('categories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow">
                        + Create Category
                    </a>
                </div>

                <table class="w-full text-sm text-left text-white">
                    <thead class="uppercase bg-gray-700 text-gray-300">
                        <tr>
                            <th scope="col" class="px-6 py-3">Title</th>
                            <th scope="col" class="px-6 py-3">Todo</th>
                            <th scope="col" class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-800">
                        @forelse($categories as $category)
                            <tr class="border-b border-gray-600">
                                <td class="px-6 py-4 font-medium text-blue-400 whitespace-nowrap">
                                    {{ $category->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $category->todos_count }}
                                </td>
                                <td class="px-6 py-4 space-x-2">
                                <a href="{{ route('categories.edit', $category->id) }}" class="text-blue-400 hover:underline">Edit</a>

                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </td>


                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-400">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
