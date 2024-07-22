<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ApiTeamController;
use App\Http\Controllers\Api\TaskController;






Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::get('me', [AuthController::class, 'me'])->middleware('auth:api');
});

Route::middleware('auth:sanctum')->get('/users', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('projects', ProjectController::class);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('teams', ApiTeamController::class);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('tasks', TaskController::class);
    Route::post('/tasks/{taskId}/comments', [TaskController::class, 'addComment']);
});
    