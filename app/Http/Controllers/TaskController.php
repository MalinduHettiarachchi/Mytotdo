<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    // Method to save a task
    public function savetask(Request $request)
    {
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
    }

    // Method to fetch tasks and display the dashboard
    public function index()
    {
        // Fetch all tasks from the database
        $tasks = Task::all();

        // Pass the tasks data to the view
        return view('dash', compact('tasks'));
    }

    // Method to update a task
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'task_name' => 'required|string|max:255',
            'task_description' => 'nullable|string',
            'task_date' => 'required|date',
        ]);

        // Find the task by ID
        $task = Task::findOrFail($id);

        // Update the task
        $task->task_name = $request->task_name;
        $task->task_description = $request->task_description;
        $task->task_date = $request->task_date;
        $task->save();

        // Return a JSON response
        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully!',
        ]);
    }

    // Method to delete a single task
    public function destroy($id)
    {
        // Find the task by ID
        $task = Task::findOrFail($id);

        // Delete the task
        $task->delete();

        // Return a JSON response
        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully!',
        ]);
    }

    // Method to delete multiple tasks
    public function deleteSelected(Request $request)
    {
        // Get the selected task IDs from the request
        $taskIds = $request->taskIds;

        // Delete the selected tasks
        Task::whereIn('id', $taskIds)->delete();

        // Return a JSON response
        return response()->json([
            'success' => true,
            'message' => 'Selected tasks deleted successfully!',
        ]);
    }
}