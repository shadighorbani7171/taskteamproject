<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Comment;
use App\Models\File;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['users', 'team', 'project', 'files'])->get();
        return view('tasks.index', compact('tasks'));
    }

    public function show(Task $task)
    {
        $task->load(['users', 'team', 'project', 'comments.user', 'files']);
        $role = auth()->user()->getRoleNames()->first();

        return view('tasks.show', compact('task', 'role'));
    }

    public function addComment(Request $request, Task $task)
    {
        $request->validate([
            'content' => 'required|string|max:255',
            'files.*' => 'nullable|file|max:2048',
        ]);

        $comment = Comment::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'content' => $request->input('content')
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $slug = Str::slug(pathinfo($fileName, PATHINFO_FILENAME)) . '-' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = Storage::disk('s3')->putFileAs('files', $file, $slug);

                File::create([
                    'comment_id' => $comment->id,
                    'name' => $fileName,
                    'slug' => $slug,
                    'url' => Storage::disk('s3')->url($filePath),
                    'user_id' => Auth::id(),
                ]);
            }
        }

        ActivityLog::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'description' => 'Added a comment: ' . $comment->content,
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }

    public function uploadFolder(Request $request, Task $task)
    {
        $request->validate([
            'files.*' => 'file|max:2048',
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $slug = Str::slug(pathinfo($fileName, PATHINFO_FILENAME)) . '-' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = Storage::disk('s3')->putFileAs('files', $file, $slug);

                File::create([
                    'task_id' => $task->id,
                    'name' => $fileName,
                    'slug' => $slug,
                    'url' => Storage::disk('s3')->url($filePath),
                    'user_id' => Auth::id(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Folder uploaded successfully.');
    }

    public function completeTask(Request $request, Task $task)
    {
        $task->is_completed = true;
        $task->end_time = now();
        $task->save();

        ActivityLog::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'description' => 'Completed the task: ' . $task->name,
        ]);

        return redirect()->back()->with('success', 'Task completed successfully.');
    }
}
