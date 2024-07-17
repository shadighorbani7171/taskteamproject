<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Project;
use App\Http\Requests\CommentRequest; 
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Project $project)
    {
        $comment = new Comment();
        $comment->project_id = $project->id;
        $comment->user_id = $request->user()->id;
        $comment->content = $request->input('content');
        $comment->url = $request->input('url') ?? null;

        if ($request->hasFile('file')) {
            $comment->file_path = $request->file('file')->store('comments');
        }

        $comment->save();

        return redirect()->back()->with('success', 'Comment added successfully.');
    }
}
