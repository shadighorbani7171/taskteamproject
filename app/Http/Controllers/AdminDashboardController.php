<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Project;


class AdminDashboardController extends Controller
{
    public function index()
    {
        $projects = Project::with(['teams.users.tasks', 'teams.owner'])->get();
    return view('admindashboard', compact('projects'));
    }
}

