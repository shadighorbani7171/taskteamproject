<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Comment;
use Illuminate\Http\Request;


class ProjectController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        $role = $user->getRoleNames()->first();

        switch ($role) {
            case 'super_admin':
                $projects = Project::with(['teams.users.tasks', 'teams.owner'])->get();
                break;
            case 'owner':
                $projects = Project::with(['teams.users.tasks', 'teams.owner'])->whereHas('teams', function($query) use ($user) {
                    $query->where('owner_id', $user->id);
                })->get();
                break;
            default:
                $projects = Project::with(['teams.users.tasks', 'teams.owner'])
                    ->whereHas('teams.users', function ($query) use ($user) {
                        $query->where('users.id', $user->id);
                    })->get();
                break;
        }

        return response()->json($projects);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'owner_id' => 'nullable|exists:users,id',
        ]);

        $project = Project::create($request->all());

        return response()->json($project, 201);
    }

    public function show($id)
    {
        $project = Project::with(['teams.users.tasks', 'teams.owner'])->findOrFail($id);
        $user = auth()->user();
        $role = $user->getRoleNames()->first();

        if ($role !== 'super_admin' && $role !== 'owner') {
            $isMember = $project->teams->pluck('users')->flatten()->contains('id', $user->id);

            if (!$isMember) {
                return response()->json(['message' => 'Unauthorized action.'], 403);
            }
        }

        return response()->json($project);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'owner_id' => 'nullable|exists:users,id',
        ]);

        $project = Project::findOrFail($id);
        $user = auth()->user();
        $role = $user->getRoleNames()->first();

        if ($role === 'super_admin' || ($role === 'owner' && $project->teams->contains('owner_id', $user->id))) {
            $project->update($request->all());
            return response()->json($project);
        }

        return response()->json(['message' => 'Unauthorized action.'], 403);
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $user = auth()->user();
        $role = $user->getRoleNames()->first();

        if ($role === 'super_admin' || ($role === 'owner' && $project->teams->contains('owner_id', $user->id))) {
            $project->delete();
            return response()->json(null, 204);
        }

        return response()->json(['message' => 'Unauthorized action.'], 403);
    }

    public function addComment(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $project = Project::findOrFail($id);
        $user = auth()->user();
        $role = $user->getRoleNames()->first();

        if ($role !== 'super_admin' && $role !== 'owner') {
            $isMember = $project->teams->pluck('users')->flatten()->contains('id', $user->id);

            if (!$isMember) {
                return response()->json(['message' => 'Unauthorized action.'], 403);
            }
        }

        $comment = new Comment();
        $comment->project_id = $project->id;
        $comment->user_id = $user->id;
        $comment->content = $request->input('content');
        $comment->save();

        return response()->json($comment, 201);
    }
}
