<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskControllert extends Controller
{
    public function savetask(Request $request)
{
    try {
        // Validate the request data
        $request->validate([
            'taskname' => 'required|string|max:255',
            'taskdes' => 'nullable|string',
            'taskdate' => 'required|date',
        ]);

        // Create a new task
        $task = new Task();
        $task->task_name = $request->taskname;
        $task->task_description = $request->taskdes;
        $task->task_date = $request->taskdate;
        $task->save();

        // Return a JSON response
        return response()->json([
            'success' => true,
            'message' => 'Task added successfully!',
        ]);
    } catch (\Exception $e) {
        // Return a JSON response with the error message
        return response()->json([
            'success' => false,
            'message' => 'An error occurred: ' . $e->getMessage(),
        ], 500);
    }
}
}