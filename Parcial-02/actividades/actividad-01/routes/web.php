<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskController;

Route::resource('tasks', TaskController::class);
Route::patch('tasks/{task}/estado', [TaskController::class, 'changeStatus'])->name('tasks.changeStatus');

Route::get('/', function () {
    return redirect()->route('tasks.index');
});
