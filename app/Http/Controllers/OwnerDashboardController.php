<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        $teams = Team::with(['projects', 'users.tasks'])->where('owner_id', auth()->id())->get();
        $projects = Project::whereHas('teams', function ($query) {
            $query->where('owner_id', auth()->id());
        })->get();

        $teamCount = $teams->count();
        $projectCount = $projects->count();

        // اصلاح کوئری شمارش وظایف
        $taskCount = Task::whereHas('team', function ($query) {
            $query->where('owner_id', auth()->id());
        })->count();

        return view('ownerdashboard', compact('teams', 'projects', 'teamCount', 'projectCount', 'taskCount'));
    }
}
