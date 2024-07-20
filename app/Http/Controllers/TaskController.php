<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Comment;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $role = auth()->user()->getRoleNames()->first();

        if ($role == 'super_admin') {
            $tasks = Task::with(['users', 'team', 'project'])->get();
        } elseif ($role == 'owner') {
            $tasks = Task::whereHas('team', function ($query) {
                $query->where('owner_id', auth()->id());
            })->with(['users', 'team', 'project'])->get();
        } else {
            $tasks = Task::whereHas('users', function ($query) {
                $query->where('user_id', auth()->id());
            })->orWhereHas('team', function ($query) {
                $query->whereHas('users', function ($query) {
                    $query->where('user_id', auth()->id());
                });
            })->with(['users', 'team', 'project'])->get();
        }

        return view('tasks.index', compact('tasks', 'role'));
    }

    public function show(Task $task)
    {
        $task->load(['users', 'team', 'project', 'comments.user', 'activityLogs.user']);
        $role = auth()->user()->getRoleNames()->first();

        return view('tasks.show', compact('task', 'role'));
    }

    public function addComment(Request $request, Task $task)
    {
        $request->validate([
            'content' => 'required|string|max:255',
            'file' => 'nullable|file|max:2048',
        ]);

        $comment = new Comment();
        $comment->task_id = $task->id;
        $comment->project_id = $task->project_id; 
        $comment->user_id = $request->user()->id;
        $comment->content = $request->input('content');

        if ($request->hasFile('file')) {
            $comment->file_path = $request->file('file')->store('comments');
        }

        $comment->save();

       
        ActivityLog::create([
            'task_id' => $task->id,
            'user_id' => $request->user()->id,
            'description' => 'Added a comment: ' . $comment->content,
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }
}
