<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

Route::get('/', [RoleController::class, 'getRoles']);

Route::post('/regiuser', [UserController::class, 'userregistration']);


Route::get('/dash', function () {
    return view('dash');
});

Route::post('/savetask', [TaskController::class, 'savetask']);

// Route to display the dashboard
Route::get('/dash', [TaskController::class, 'index']);

// Route to save a task
Route::post('/savetask', [TaskController::class, 'savetask']);


Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');

// Route to delete a single task
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

// Route to delete multiple tasks
Route::delete('/tasks', [TaskController::class, 'deleteSelected'])->name('tasks.deleteSelected');
