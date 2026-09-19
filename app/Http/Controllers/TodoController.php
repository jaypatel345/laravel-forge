<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $todos = Auth::user()->todos()->latest()->get();
        $editing = $request->query('editing');

        return view('home', compact('todos', 'editing'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Auth::user()->todos()->create($validated);

        return redirect()->route('home')->with('success', 'Todo created successfully!');
    }

    public function update(Request $request, Todo $todo)
    {
        $this->authorize('update', $todo);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'completed' => 'sometimes|required|boolean',
        ]);

        $todo->update($validated);

        return redirect()->route('home')->with('success', 'Todo updated successfully!');
    }

    public function destroy(Todo $todo)
    {
        $this->authorize('delete', $todo);

        $todo->delete();

        return redirect()->route('home')->with('success', 'Todo deleted successfully!');
    }
}
