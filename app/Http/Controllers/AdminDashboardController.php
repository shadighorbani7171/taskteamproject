<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Project;
use App\Models\User;
use App\Models\Task;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $projectCount = Project::count();
        $taskCount = Task::count();
        $teamCount = Team::count();

        $projects = Project::with(['teams.users.tasks', 'teams.owner'])->get();
        return view('admindashboard', compact('userCount', 'projectCount', 'taskCount', 'teamCount', 'projects'));
    }
}
