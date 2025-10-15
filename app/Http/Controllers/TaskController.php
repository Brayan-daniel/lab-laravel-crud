<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TaskRepositoryInterface;

class TaskController extends Controller
{
    private TaskRepositoryInterface $tasks;

    public function __construct(TaskRepositoryInterface $tasks)
    {
        $this->tasks = $tasks;
    }

    public function index()
    {
        return response()->json($this->tasks->all(), 200);
    }

    public function show(int $id)
    {
        $task = $this->tasks->find($id);
        if (!$task) {
            return response()->json(['error' => 'Tarea no encontrada'], 404);
        }
        return response()->json($task, 200);
    }

    public function store(Request $request)
    {
        $task = $this->tasks->create([
            'title' => $request->input('title'),
            'completed' => $request->input('completed', false)
        ]);
        return response()->json($task, 201);
    }

    public function update(Request $request, int $id)
    {
        $task = $this->tasks->update($id, [
            'title' => $request->input('title'),
            'completed' => $request->input('completed', false)
        ]);

        if (!$task) {
            return response()->json(['error' => 'Tarea no encontrada'], 404);
        }

        return response()->json($task, 200);
    }

    public function destroy(int $id)
    {
        $deleted = $this->tasks->delete($id);
        if (!$deleted) {
            return response()->json(['error' => 'Tarea no encontrada'], 404);
        }
        return response()->json(['message' => 'Tarea eliminada'], 200);
    }
}
