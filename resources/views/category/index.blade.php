@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Category</h2>
        <a href="{{ route('category.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Create</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white shadow rounded">
        <thead class="bg-gray-200">
            <tr>
                <th class="py-2 px-4 text-left">No</th>
                <th class="py-2 px-4 text-left">Name</th>
                <th class="py-2 px-4 text-left">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $index => $category)
                <tr class="border-b">
                    <td class="py-2 px-4">{{ $index + 1 }}</td>
                    <td class="py-2 px-4">{{ $category->name }}</td>
                    <td class="py-2 px-4">
                        <a href="{{ route('category.edit', $category->id) }}" class="text-blue-500 mr-2">Edit</a>
                        <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-500">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
