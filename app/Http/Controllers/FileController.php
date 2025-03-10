<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\File;
use App\Models\Comment;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    public function show(Task $task)
    {
        $comments = Comment::where('task_id', $task->id)->get();
        $files = File::where('task_id', $task->id)->get();
        return view('tasks.files', compact('task', 'comments', 'files'));
    }

    public function uploadFile(Request $request, Task $task)
    {
        $request->validate([
            'file' => 'required|file|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
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

        return redirect()->back()->with('success', 'File uploaded successfully.');
    }

    public function addComment(Request $request, Task $task)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        Comment::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }
}
