<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use Illuminate\Http\Request;

class MemberDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $teams = $user->teams()->with('projects')->get();
        $tasks = $user->tasks()->with(['team', 'project'])->get();
        $projects = Project::whereHas('teams.users', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })->get();

        return view('dashboard', compact('teams', 'tasks', 'projects'));
    }
}
