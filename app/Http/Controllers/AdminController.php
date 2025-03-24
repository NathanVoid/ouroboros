<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::where('role', 'user')->paginate(10);
        return view('admin.dashboard', compact('users'));
    }

    public function assignTask(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'task_type' => 'required|in:text,number'
        ]);

        // Generate task value
        $taskValue = $request->task_type === 'number'
            ? strval(mt_rand(1000000000, 9999999999))
            : substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10);

        // Create task
        $task = Task::create([
            'user_id' => $request->user_id,
            'admin_id' => auth()->id(),
            'task_type' => $request->task_type,
            'task_value' => $taskValue,
        ]);

        // Send email notification
        $user = User::find($request->user_id);
        Mail::raw("You have a new task: {$taskValue}", function ($message) use ($user) {
            $message->to($user->email)->subject('New Task Assigned');
        });

        // Return success response
        return response()->json([
            'message' => 'Task assigned successfully!',
        ]);
    }
}
