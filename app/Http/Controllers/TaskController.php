<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->getRoleNames()->first();

        if ($role == 'super_admin') {
            $tasks = Task::with(['users', 'team', 'project', 'files'])->get();
        } elseif ($role == 'owner') {
            $tasks = Task::whereHas('team', function($query) use ($user) {
                $query->where('owner_id', $user->id);
            })->with(['users', 'team', 'project', 'files'])->get();
        } else {
            $tasks = Task::whereHas('users', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['users', 'team', 'project', 'files'])->get();
        }

        return view('tasks.index', compact('tasks'));
    }

    public function show(Task $task)
    {
        $user = Auth::user();
        $role = $user->getRoleNames()->first();

        if ($role != 'super_admin' && $task->team->owner_id != $user->id && !$task->users->contains($user)) {
            abort(403, 'Unauthorized action.');
        }

        $task->load(['users', 'team', 'project', 'comments.user', 'files']);
        return view('tasks.show', compact('task', 'role'));
    }

    public function completeTask(Request $request, Task $task)
    {
        $user = Auth::user();
        $role = $user->getRoleNames()->first();

        if ($role != 'super_admin' && $task->team->owner_id != $user->id && !$task->users->contains($user)) {
            abort(403, 'Unauthorized action.');
        }

        $task->is_completed = true;
        $task->end_time = now();
        $task->progress = 100; // فرض می‌کنیم که تکمیل شده و 100% پیشرفت داشته باشد
        $task->save();

        ActivityLog::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'description' => 'Completed the task: ' . $task->name,
        ]);

        return redirect()->back()->with('success', 'Task completed successfully.');
    }
}
