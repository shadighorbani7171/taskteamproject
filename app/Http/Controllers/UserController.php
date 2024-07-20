<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('teams', 'tasks')->get();
        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('teams', 'tasks');
        return view('users.show', compact('user'));
    }
}

