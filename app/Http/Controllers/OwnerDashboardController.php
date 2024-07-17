<?php

// app/Http/Controllers/OwnerDashboardController.php
namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get the teams and projects where the user is the owner
        $teams = Team::where('owner_id', $user->id)->get();
        $projects = Project::where('owner_id', $user->id)->get();

        return view('ownerdashboard', compact('teams', 'projects'));
    }
}



