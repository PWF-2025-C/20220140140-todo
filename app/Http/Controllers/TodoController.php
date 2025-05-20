<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    // Show all todos for the logged-in user
    public function index()
    {
        $todos = Todo::with('category')
            ->where('user_id', auth()->id())
            ->orderBy('is_done', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        $todosCompleted = Todo::where('user_id', auth()->id())
            ->where('is_done', true)
            ->count();

        return view('todo.index', compact('todos', 'todosCompleted'));
    }

// TodoController.php
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('todo.create', compact('categories'));
    }

    

    // Store a new todo
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|integer|exists:categories,id',
        ]);
    
        Todo::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'user_id' => auth()->id(),
            'status' => 'Ongoing'
        ]);
    
        return redirect()->route('todo.index')->with('success', 'Todo created successfully.');
    }
    
    

    // Show form to edit a todo
    public function edit(Todo $todo)
    {
        if (auth()->id() !== $todo->user_id) {
            return redirect()
                ->route('todo.index')
                ->with('danger', 'You are not authorized to edit this todo!');
        }

        $categories = Category::orderBy('name')->get();
        return view('todo.edit', compact('todo', 'categories'));
    }

    // Update a todo
    public function update(Request $request, Todo $todo)
    {
        $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'nullable|exists:categories,id',
        ]);
    
        $todo->update([
            'name' => ucfirst($request->name),
            'category_id' => $request->category_id,
        ]);
    
        return redirect()
            ->route('todo.index')
            ->with('success', 'Todo updated successfully!');
    }
    

    // Mark todo as completed
    public function complete(Todo $todo)
    {
        if (auth()->id() !== $todo->user_id) {
            return redirect()->route('todo.index')
                ->with('danger', 'You are not authorized to complete this todo!');
        }

        $todo->update(['is_done' => true]);

        return redirect()->route('todo.index')
            ->with('success', 'Todo completed successfully!');
    }

    // Mark todo as not completed
    public function uncomplete(Todo $todo)
    {
        if (auth()->id() !== $todo->user_id) {
            return redirect()->route('todo.index')
                ->with('danger', 'You are not authorized to uncomplete this todo!');
        }

        $todo->update(['is_done' => false]);

        return redirect()->route('todo.index')
            ->with('success', 'Todo uncompleted successfully!');
    }

    // Delete a todo
    public function destroy(Todo $todo)
    {
        if (auth()->id() !== $todo->user_id) {
            return redirect()->route('todo.index')
                ->with('danger', 'You are not authorized to delete this todo!');
        }

        $todo->delete();

        return redirect()->route('todo.index')
            ->with('success', 'Todo deleted successfully.');
    }

    // Delete all completed todos
    public function destroyCompleted()
    {
        $todosCompleted = Todo::where('user_id', auth()->id())
            ->where('is_done', true)
            ->get();

        foreach ($todosCompleted as $todo) {
            $todo->delete();
        }

        return redirect()->route('todo.index')
            ->with('success', 'All completed todos deleted successfully!');
    }
}
