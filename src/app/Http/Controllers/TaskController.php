<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(TaskStoreRequest $request)
    {
        $task = $request->user()->tasks()->create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id
        ]);

        if ($request->has('tags')) {
            $task->tags()->sync($request->tags);
        }

        return new TaskResource($task->load('category', 'tags'));
    }

    public function index(Request $request)
    {
        $tasks = $request->user()
            ->tasks()
            ->select('id', 'name')
            ->get();

        return new TaskCollection($tasks);
    }

    public function show(Request $request, $id)
    {
        $task = $request->user()->tasks()->findOrFail($id);
        return new TaskResource($task->load('category', 'tags'));
    }

    public function update(TaskUpdateRequest $request, $id)
    {
        $task = $request->user()->tasks()->findOrFail($id);

        $task->update($request->only(['name', 'description', 'category_id']));

        if ($request->has('tags')) {
            $task->tags()->sync($request->tags);
        }

        return new TaskResource($task->fresh()->load('category', 'tags'));
    }
    public function destroy(Request $request, $id)
    {
        $task = $request->user()->tasks()->findOrFail($id);
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }
}
