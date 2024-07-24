<?php




namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Comment;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class ApiFileController extends Controller
{
    public function show(Task $task)
    {
        $comments = Comment::where('task_id', $task->id)->get();
        $files = File::where('task_id', $task->id)->get();
        return response()->json(['task' => $task, 'comments' => $comments, 'files' => $files], 200);
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

            return response()->json(['message' => 'File uploaded successfully.'], 201);
        }

        return response()->json(['message' => 'No file uploaded.'], 400);
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

        return response()->json(['message' => 'Comment added successfully.'], 201);
    }
}
