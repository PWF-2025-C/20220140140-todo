<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::withCount('todos')->get();
        return view('categories.index', compact('categories'));
    }
    

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        Category::create([
            'name' => ucfirst($request->name),
            'user_id' => auth()->id(),
        ]);
    
        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }
    
    
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted!');
    }

    public function show(string $id)
    {
        $category = Category::with('todos')->findOrFail($id);
        return view('categories.show', compact('category'));
    }   

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $category->update(['name' => $request->name]);
        return redirect()->route('categories.index')->with('success', 'Category updated!');
    }
    public function myCategories()
{
    $user = Auth::user();

    $categories = Category::where('user_id', $user->id)->get();

    return response()->json([
        'status_code' => 200,
        'message' => 'Berhasil mengambil kategori milik user',
        'data' => $categories
    ]);
}

}