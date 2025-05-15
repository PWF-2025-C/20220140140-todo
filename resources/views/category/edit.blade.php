@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-md">
    <h2 class="text-2xl font-bold mb-4">Edit Category</h2>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            <ul class="list-disc ml-4">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('category.update', $category->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label for="name" class="block font-semibold">Category Name</label>
            <input type="text" name="name" id="name" value="{{ $category->name }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('category.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded mr-2">Cancel</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        </div>
    </form>
</div>
@endsection
