<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $tasks = Task::where('user_id', Auth::id())
                     ->where('status', 'pending')
                     ->paginate(10);

        return view('user.dashboard', compact('tasks'));
    }

    public function completeTask(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'task_value' => 'required|string'
        ]);

        $task = Task::where('id', $request->task_id)
                    ->where('user_id', Auth::id())
                    ->where('status', 'pending')
                    ->firstOrFail();

        if ($task->task_value === $request->task_value) {
            $task->update(['status' => 'completed']);
            
            // Fetch remaining tasks (ensure it returns JSON-friendly pagination)
            $tasks = Task::where('user_id', Auth::id())
                        ->where('status', 'pending')
                        ->paginate(10)
                        ->toArray(); // Convert to array for JSON response

            return response()->json([
                'message' => 'Task completed successfully!',
                'tasks' => $tasks
            ]);
        } else {
            return response()->json(['error' => 'Incorrect value. Try again.'], 422);
        }
    }

}