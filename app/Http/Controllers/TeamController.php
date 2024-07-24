<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $role = $user->getRoleNames()->first();

        switch ($role) {
            case 'super_admin':
                $teams = Team::with(['projects', 'users'])->get();
                break;
            case 'owner':
                $teams = Team::with(['projects', 'users'])->where('owner_id', $user->id)->get();
                break;
            default:
                $teams = Team::with(['projects', 'users'])->whereHas('users', function ($query) use ($user) {
                    $query->where('users.id', $user->id);
                })->get();
                break;
        }

        return view('teams.index', compact('teams', 'role'));
    }

    public function show($id)
    {
        $team = Team::with(['projects', 'users'])->findOrFail($id);
        return view('teams.show', compact('team'));
    }
}
