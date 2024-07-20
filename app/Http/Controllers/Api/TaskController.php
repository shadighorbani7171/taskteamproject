<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Comment;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class TaskController extends Controller
{
   

    public function index(Request $request)
    {
        $user = $request->user();
        $role = $user->getRoleNames()->first();

        if ($role == 'super_admin') {
            $tasks = Task::with(['users', 'team', 'project'])->get();
        } elseif ($role == 'owner') {
            $tasks = Task::whereHas('team', function ($query) use ($user) {
                $query->where('owner_id', $user->id);
            })->with(['users', 'team', 'project'])->get();
        } else {
            $tasks = Task::whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->orWhereHas('team', function ($query) use ($user) {
                $query->whereHas('users', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                });
            })->with(['users', 'team', 'project'])->get();
        }

        return response()->json($tasks);
    }

    public function show($id)
    {
        $task = Task::with(['users', 'team', 'project', 'comments.user', 'activityLogs.user'])->findOrFail($id);
        return response()->json($task);
    }

    public function addComment(Request $request, $taskId)
    {
        $request->validate([
            'content' => 'required|string|max:255',
            'file' => 'nullable|file|max:2048',
        ]);

        $task = Task::findOrFail($taskId);

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

        return response()->json(['message' => 'Comment added successfully.', 'comment' => $comment], 201);
    }
}

