<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dash');
});

use App\Http\Controllers\TaskController;

Route::post('/savetask', [TaskController::class, 'savetask']);
