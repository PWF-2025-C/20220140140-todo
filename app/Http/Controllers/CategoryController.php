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
        if ($category->user_id !== Auth::id()) {
            return redirect()->route('categories.index')->with('danger', 'Anda tidak diizinkan menghapus kategori ini.');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }

    public function show(string $id)
    {
        $category = Category::with('todos')->findOrFail($id);
        return view('categories.show', compact('category'));
    }   

    public function edit(category $category)
    {
        if (auth()->user()->id == $category->user_id) {
            return view('categories.edit', compact('category'));
        } else {
            return redirect()->route('categories.index')->with('danger', 'You are not authorized to edit this todo!');
        }

    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);
        $category->update([
            'name' => ucfirst($request->name),
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

}