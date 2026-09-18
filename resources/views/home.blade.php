<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold text-gray-800">My Todos</h1>
                <p class="text-gray-600 mt-1">{{ auth()->user()->email }}</p>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors shadow-md">Logout</button>
            </form>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded-xl shadow-lg mb-6 border border-gray-100">
            <form action="{{ route('todos.store') }}" method="POST" class="flex gap-3">
                @csrf
                <input type="text" name="title" placeholder="Add a new todo..." class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-md font-medium">Add</button>
            </form>
        </div>

        <div class="space-y-3">
            @forelse($todos as $todo)
                <div class="bg-white p-4 rounded-xl shadow-md flex items-center justify-between border border-gray-100 {{ $todo->completed ? 'opacity-60' : '' }} hover:shadow-lg transition-shadow">
                    <div class="flex items-center gap-4">
                        <form action="{{ route('todos.update', $todo) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="completed" value="{{ $todo->completed ? '0' : '1' }}">
                            <button type="submit" class="w-7 h-7 rounded-full border-2 {{ $todo->completed ? 'bg-green-500 border-green-500' : 'border-gray-300 hover:border-blue-400' }} flex items-center justify-center transition-colors">
                                @if($todo->completed)
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @endif
                            </button>
                        </form>
                        <span class="{{ $todo->completed ? 'line-through text-gray-400' : 'text-gray-800' }} text-lg font-medium">
                            {{ $todo->title }}
                        </span>
                    </div>
                    <form action="{{ route('todos.destroy', $todo) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this todo?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors">Delete</button>
                    </form>
                </div>
            @empty
                <div class="bg-white p-8 rounded-xl shadow-md text-center border border-gray-100">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <p class="text-gray-500 text-lg">No todos yet. Add one above!</p>
                </div>
            @endforelse
        </div>
    </div>
</body>
</html>