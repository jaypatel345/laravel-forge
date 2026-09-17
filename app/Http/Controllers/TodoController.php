<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Auth::user()->todos()->latest()->get();

        return view('home', compact('todos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Auth::user()->todos()->create($validated);

        return redirect()->back()->with('success', 'Todo created successfully!');
    }

    public function update(Request $request, Todo $todo)
    {
        $this->authorize('update', $todo);

        $validated = $request->validate([
            'completed' => 'required|boolean',
        ]);

        $todo->update($validated);

        return redirect()->back()->with('success', 'Todo updated successfully!');
    }

    public function destroy(Todo $todo)
    {
        $this->authorize('delete', $todo);

        $todo->delete();

        return redirect()->back()->with('success', 'Todo deleted successfully!');
    }
}
