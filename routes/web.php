<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('login');
});

Route::get('/', function () {
    return view('dash');
});

use App\Http\Controllers\TaskController;

Route::post('/savetask', [TaskController::class, 'savetask']);

// Route to display the dashboard
Route::get('/', [TaskController::class, 'index']);

// Route to save a task
Route::post('/savetask', [TaskController::class, 'savetask']);


Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');

// Route to delete a single task
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

// Route to delete multiple tasks
Route::delete('/tasks', [TaskController::class, 'deleteSelected'])->name('tasks.deleteSelected');
