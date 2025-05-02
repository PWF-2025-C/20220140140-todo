<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Todo Index') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">
            <!-- Sidebar -->
            <div class="w-1/4 pr-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="mb-4">
                            <strong>{{ Auth::user()->name }}</strong><br>
                            <small>{{ Auth::user()->email }}</small>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('profile.edit') }}" class="block text-blue-500 hover:underline">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block text-red-500 hover:underline">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="w-3/4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                        <div class="bg-gray-100 dark:bg-gray-700 p-8 rounded-lg shadow">
                            <h1 class="text-2xl font-bold">Welcome Todo Index</h1>
                        </div>
                    </div>
                </div>

                <!-- Flash message -->
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Tabel Todo -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <!-- Tombol Create Todo -->
                        <div class="mb-4 text-right">
                            <a href="{{ route('todo.create') }}" 
                               class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow">
                                + Create Todo
                            </a>
                        </div>

                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-900 dark:text-gray-100">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-200">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Title</th>
                                        <th scope="col" class="px-6 py-3">Status</th>
                                        <th scope="col" class="px-6 py-3">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse ($todos as $todo)
<tr class="odd:bg-white odd:dark:bg-gray-800 even:bg-gray-50 even:dark:bg-gray-700">
    <td class="px-6 py-4 text-white dark:text-white">
        {{ $todo->title }}
    </td>

    <td class="px-6 py-4">
        @if ($todo->is_done)
            <span class="inline-block px-2 py-1 text-xs font-semibold text-green-800 bg-green-200 rounded-full">Completed</span>
        @else
            <span class="inline-block px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-200 rounded-full">Ongoing</span>
        @endif
    </td>

    <td class="px-6 py-4">
        <div class="flex space-x-3">
            <a href="{{ route('todo.edit', $todo) }}" class="text-blue-500 hover:underline">Edit</a>

            <form action="{{ route('todo.destroy', $todo) }}" method="POST" onsubmit="return confirm('Delete this todo?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:underline">Delete</button>
            </form>

            @if ($todo->is_done)
                <form action="{{ route('todo.uncomplete', $todo) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="text-yellow-500 hover:underline">Uncomplete</button>
                </form>
            @else
                <form action="{{ route('todo.complete', $todo) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="text-green-500 hover:underline">Complete</button>
                </form>
            @endif
        </div>
    </td>
</tr>
@empty
<tr><td colspan="3" class="text-white">No todo found.</td></tr>
@endforelse

                                </tbody>
                            </table>
                            <div class="mt-4 p-4 rounded-xl bg-gray-800 border border-gray-600 shadow-md text-white flex justify-between items-center">
                             <span class="text-lg font-semibold">
                            🗑️ Delete All Completed Tasks
                             </span>

                             <form action="{{ route('todo.deleteCompleted') }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit">Delete Completed Todos</button>
</form>


                        </div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
