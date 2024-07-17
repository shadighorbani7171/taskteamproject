<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProjectRequest;


class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['teams.users.tasks', 'teams.owner'])->get();
        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $project->load(['teams.users.tasks', 'teams.owner']);
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(ProjectRequest $request, Project $project)
    {
       

        $project->update($request->all());

        return redirect()->route('projects.show', $project)->with('success', 'Project updated successfully.');
    }
}
