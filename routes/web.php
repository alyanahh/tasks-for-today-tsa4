
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;

// PUBLIC PAGES
Route::get('/', [TaskController::class, 'welcome'])->name('welcome');

Route::get('/tasks', [TaskController::class, 'tasks'])->name('tasks.index');

Route::get('/about', [TaskController::class, 'about'])->name('about');

// DASHBOARD - REQUIRED BY BREEZE
Route::get('/dashboard', function () {
    return redirect()->route('tasks.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// TASK CRUD - AUTHENTICATED USERS ONLY
Route::middleware('auth')->group(function () {

    // Create
    Route::get('/tasks/create', [TaskController::class, 'create'])
        ->name('tasks.create');

    Route::post('/tasks', [TaskController::class, 'store'])
        ->name('tasks.store');

    // Edit and Update
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])
        ->name('tasks.edit');

    Route::put('/tasks/{task}', [TaskController::class, 'update'])
        ->name('tasks.update');

    // Soft Delete
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])
        ->name('tasks.destroy');

});

// BREEZE PROFILE MANAGEMENT
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

// AUTHENTICATION ROUTES
require __DIR__.'/auth.php';
