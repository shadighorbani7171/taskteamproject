<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Project;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $user = auth()->user();
        $isMember = $project->teams->pluck('users')->flatten()->contains('id', $user->id);

        if (!$isMember) {
            abort(403, 'Unauthorized action.');
        }

        $comment = new Comment();
        $comment->project_id = $project->id;
        $comment->user_id = $user->id;
        $comment->content = $request->input('content');
        $comment->save();

        return redirect()->route('projects.show', $project)->with('success', 'Comment added successfully.');
    }
}


