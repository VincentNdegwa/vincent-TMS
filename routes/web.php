<?php

use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\pageController;
use App\Http\Controllers\taskController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
//navigation routes
Route::get("/", [taskController::class, "getUserTasks"])->name('getUserTasks');

Route::prefix("/")->group(function () {
    Route::get('createTask', [taskController::class, "storeUserTask"])->name('createTask');
    Route::get("viewTasks",[taskController::class, "getAllTask"])->name("viewTasks");
    Route::get("PlayGround",[pageController::class, 'getPlayGround'])->name('getPlayGround');
});




// main data routes
Route::prefix("/tasks")->group(function () {
    Route::post('add', [taskController::class, "addTask"])->name('addTask');
    Route::get('all', [taskController::class, "getAllTask"])->name('getAllTask');
    Route::put("update", [taskController::class, "updateTask"])->name('updateTask');
    Route::get("/", [taskController::class, "sortTask"])->name('sortTask');
});
require __DIR__ . '/auth.php';


Route::get('storage/{filename}', function ($filename) {
    $path = '../storage' . $filename;

    if (Storage::exists($path)) {
        return Storage::response($path);
    }

    abort(404);
})->where('filename', '.*');
