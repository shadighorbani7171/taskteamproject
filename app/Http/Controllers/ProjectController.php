<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;

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
                $projects = Project::with(['teams.users.tasks', 'teams.owner'])->get();
                break;
            default:
                $projects = Project::with(['teams.users.tasks', 'teams.owner'])
                    ->whereHas('teams.users', function ($query) use ($user) {
                        $query->where('users.id', $user->id);
                    })->get();
                break;
        }

        return view('projects.index', compact('projects', 'role'));
    }

    public function show(Project $project)
    {
        $project->load(['teams.users.tasks', 'teams.owner', 'comments.user']);
        $role = auth()->user()->getRoleNames()->first();

        $user = auth()->user();

        if ($role !== 'super_admin' && $role !== 'owner') {
            $isMember = false;
            foreach ($project->teams as $team) {
                if ($team->users->contains($user)) {
                    $isMember = true;
                    break;
                }
            }

            if (!$isMember) {
                abort(403, 'Unauthorized action.');
            }
        }

        return view('projects.show', compact('project', 'role'));
    }

    public function edit(Project $project)
    {
        $user = auth()->user();
        $role = $user->getRoleNames()->first();

        if ($role === 'super_admin' || ($role === 'owner' && $project->teams->contains('owner_id', $user->id))) {
            return view('projects.edit', compact('project'));
        }

        abort(403, 'Unauthorized action.');
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $user = auth()->user();
        $role = $user->getRoleNames()->first();

        if ($role === 'super_admin' || ($role === 'owner' && $project->teams->contains('owner_id', $user->id))) {
            $project->update($request->all());
            return redirect()->route('projects.show', $project)->with('success', 'Project updated successfully.');
        }

        abort(403, 'Unauthorized action.');
    }
}


