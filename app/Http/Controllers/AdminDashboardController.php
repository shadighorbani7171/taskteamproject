<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Project;
use App\Models\User;
use App\Models\Task;
use App\Models\Resource;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $projectCount = Project::count();
        $taskCount = Task::count();
        $teamCount = Team::count();
        $resourceCount = Resource::count();

        $projects = Project::with(['teams.users.tasks', 'teams.owner', 'resources'])->get();

        $tasksByProject = Task::selectRaw('project_id, count(*) as total')
            ->groupBy('project_id')
            ->pluck('total', 'project_id')
            ->all();

        $chart = (new LarapexChart)->barChart()
            ->setTitle('Tasks by Project')
            ->setXAxis(Project::whereIn('id', array_keys($tasksByProject))->pluck('name')->toArray())
            ->setDataset('Total Tasks', array_values($tasksByProject));

        return view('admindashboard', compact('userCount', 'projectCount', 'taskCount', 'teamCount', 'resourceCount', 'projects', 'chart'));
    }
}
