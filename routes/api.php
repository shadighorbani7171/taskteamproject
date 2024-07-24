<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ApiTeamController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\ApiChatroomController;
use App\Http\Controllers\Api\ApiFileController;
use App\Http\Controllers\Api\MessageController;








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
    Route::get('/tasks/{task}/files', [ApiFileController::class, 'show']);
    Route::post('/tasks/{task}/files', [ApiFileController::class, 'uploadFile']);
    Route::post('/tasks/{task}/comments', [ApiFileController::class, 'addComment']);
});



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/chatrooms', [ApiChatroomController::class, 'index']);
    Route::get('/chatrooms/{chatRoom}', [ApiChatroomController::class, 'show']);
    Route::post('/chatrooms', [ApiChatroomController::class, 'store']);
    Route::put('/chatrooms/{chatRoom}', [ApiChatroomController::class, 'update']);
    Route::delete('/chatrooms/{chatRoom}', [ApiChatroomController::class, 'destroy']);

    Route::post('/chatrooms/{chatRoom}/messages', [MessageController::class, 'store']);
});




    