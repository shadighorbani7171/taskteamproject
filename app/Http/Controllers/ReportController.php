<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;

class ReportController extends Controller
{
    public function index()
    {
        $projects = Project::with('tasks')->get();
        $teams = Team::with('users')->get();

       
        $projectProgress = $projects->map(function ($project) {
            $completedTasks = $project->tasks->where('status', 'completed')->count();
            $totalTasks = $project->tasks->count();
            return [
                'name' => $project->name,
                'progress' => $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0,
            ];
        });

        $teamPerformance = $teams->map(function ($team) {
            $totalTasks = $team->users->reduce(function ($carry, $user) {
                return $carry + $user->tasks->count();
            }, 0);
            $completedTasks = $team->users->reduce(function ($carry, $user) {
                return $carry + $user->tasks->where('status', 'completed')->count();
            }, 0);
            return [
                'name' => $team->name,
                'performance' => $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0,
            ];
        });

        return view('reports.index', compact('projectProgress', 'teamPerformance'));
    }
}

