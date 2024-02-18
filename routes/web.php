<?php

use App\Http\Controllers\commentController;
use App\Http\Controllers\emailVerificationController;
use App\Http\Controllers\group_controller;
use App\Http\Controllers\groupMessageController;
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
    Route::get("viewTasks", [taskController::class, "getAllTask"])->name("viewTasks");
    Route::prefix("PlayGround")->group(function () {
        Route::get("/", [pageController::class, 'getPlayGround'])->name('getPlayGround');
        Route::get("/view/{id}", [pageController::class, "getComments"])->name("getComments");
    });
});

// main data routes
Route::prefix("/tasks")->group(function () {
    Route::post('/add', [taskController::class, "addTask"])->name('addTask');
    Route::get('/all', [taskController::class, "getAllTask"])->name('getAllTask');
    Route::post("/update", [taskController::class, "updateTask"])->name('updateTask');
    Route::get("/", [taskController::class, "sortTask"])->name('sortTask');
    Route::post("/comment", [commentController::class, "create"])->name('createComment');
});
require __DIR__ . '/auth.php';


Route::get('storage/{filename}', function ($filename) {
    $path = '../storage' . $filename;

    if (Storage::exists($path)) {
        return Storage::response($path);
    }

    abort(404);
})->where('filename', '.*');

Route::get("/verify_email/{username}/{tokenLink}", [emailVerificationController::class, "verificationCreation"]);

//  public route 

Route::group(['prefix' => 'group'], function () {
    Route::post('/create', [group_controller::class, 'createNewGroup']);
    Route::get('/view/{group_id}', [group_controller::class, "viewGroup"]);
    Route::post("/update", [group_controller::class, "editGroup"]);
    Route::post("/exit", [group_controller::class, "exitGroup"]);
    Route::post("/delete", [group_controller::class, "deleteGroup"]);
    Route::group(["prefix" => "/member"], function () {
        Route::post("/search", [group_controller::class, "searchMember"]);
        Route::post("/add", [group_controller::class, "inviteMember"]);
    });
});

Route::group(['prefix' => 'messages'], function () {
    Route::post('/add', [groupMessageController::class, 'addMessage']);
    Route::post("/task", [taskController::class, "assignTaskGroup"]);
});
