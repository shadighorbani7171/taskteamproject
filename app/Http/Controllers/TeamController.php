<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;


class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::with(['users', 'owner'])->get();
        return view('teams.index', compact('teams'));
    }

    public function show(Team $team)
    {
        $team->load(['users', 'owner']);
        return view('teams.show', compact('team'));
    }
}

