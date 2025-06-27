<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ]);
    
        // Создаём задачу
        $task = $request->user()->tasks()->create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'category_id' => $validated['category_id']
        ]);
    
        // Прикрепляем теги, если они переданы
        if (isset($validated['tags'])) {
            $task->tags()->attach($validated['tags']);
        }
    
        // Загружаем свежие данные с отношениями
        $task->load('category', 'tags');
    
        return response()->json($task, 201);
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ]);

        $task->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'category_id' => $validated['category_id']
        ]);

        $task->tags()->sync($validated['tags'] ?? []);

        $task->load('category', 'tags');
   

        return response()->json($task);
    }


    public function index()
    {
        $tasks = Task::select('id', 'name')->get();

        return response()->json($tasks);
    }

    public function show($id)
    {
        $task = Task::findOrFail($id);
        $task->load('category', 'tags');

        return response()->json($task);
    }


    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json([
            'message' => 'Task deleted successfully'
        ]);
    }
}
