<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\CommentprojectController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ChatRoomController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResourceAllocationController;




    





Route::get('/', function () {
    return view('welcome');
});

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });



Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        $user = auth()->user();
        $role = $user->getRoleNames()->first();

        switch ($role) {
            case 'super_admin':
                return redirect()->route('admin.dashboard');
            case 'owner':
                return redirect()->route('owner.dashboard');
            default:
                return view('dashboard');
        }
    })->name('dashboard');

    Route::middleware(['role:super_admin'])->group(function () {
        Route::get('/admindashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    });

    Route::middleware(['role:owner'])->group(function () {
        Route::get('/ownerdashboard', [OwnerDashboardController::class, 'index'])->name('owner.dashboard');
    });

    Route::resource('projects', ProjectController::class);
    Route::post('/projects/{project}/comments', [CommentprojectController::class, 'store'])->name('projects.comments.store');
    
    Route::resource('teams', TeamController::class);
   
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
        Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
        Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
        Route::post('/tasks/{task}/comments', [TaskController::class, 'addComment'])->name('tasks.addComment');
        Route::post('/tasks/{task}/upload-folder', [TaskController::class, 'uploadFolder'])->name('tasks.uploadFolder');
    });
   
    Route::resource('users',UserController::class);

    Route::get('/resources', [ResourceAllocationController::class, 'index'])->name('resources.index');
    
    

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

   
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        Route::get('/chats', [ChatRoomController::class, 'index'])->name('chats.index');
        Route::post('/chats', [ChatRoomController::class, 'store'])->name('chats.store');
        Route::get('/chats/{chatRoom}', [ChatRoomController::class, 'show'])->name('chats.show');
        Route::get('/chats/{chatRoom}/edit', [ChatRoomController::class, 'edit'])->name('chats.edit');
        Route::put('/chats/{chatRoom}', [ChatRoomController::class, 'update'])->name('chats.update');
        Route::delete('/chats/{chatRoom}', [ChatRoomController::class, 'destroy'])->name('chats.destroy');
        Route::post('/chats/{chatRoom}/messages', [MessageController::class, 'store'])->name('messages.store');
    });
});