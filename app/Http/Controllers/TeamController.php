<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\User;


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

        return response()->json($teams);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $team = Team::create($request->all());

        return response()->json($team, 201);
    }

    public function show($id)
    {
        $team = Team::with(['projects', 'users'])->findOrFail($id);
        return response()->json($team);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $team = Team::findOrFail($id);
        $team->update($request->all());

        return response()->json($team);
    }

    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();

        return response()->json(null, 204);
    }
}
