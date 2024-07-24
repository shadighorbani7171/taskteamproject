<?php



namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Http\Request;

class ApiChatroomController extends Controller
{
    public function index()
    {
        $chatRooms = ChatRoom::all();
        $users = $this->getAccessibleUsers();
        return response()->json(['chatRooms' => $chatRooms, 'users' => $users], 200);
    }

    public function show(ChatRoom $chatRoom)
    {
        $messages = $chatRoom->messages()->with('user')->oldest()->get();
        return response()->json(['chatRoom' => $chatRoom, 'messages' => $messages], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'users' => 'required|array',
            'users.*' => 'exists:users,id'
        ]);

        $chatRoom = ChatRoom::create([
            'name' => $request->name,
        ]);

        $chatRoom->users()->attach($request->users);

        return response()->json(['message' => 'Chat Room created successfully', 'chatRoom' => $chatRoom], 201);
    }

    public function edit(ChatRoom $chatRoom)
    {
        $users = $this->getAccessibleUsers();
        return response()->json(['chatRoom' => $chatRoom, 'users' => $users], 200);
    }

    public function update(Request $request, ChatRoom $chatRoom)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'users' => 'required|array',
            'users.*' => 'exists:users,id'
        ]);

        $chatRoom->update([
            'name' => $request->name,
        ]);

        $chatRoom->users()->sync($request->users);

        return response()->json(['message' => 'Chat Room updated successfully', 'chatRoom' => $chatRoom], 200);
    }

    public function destroy(ChatRoom $chatRoom)
    {
        $chatRoom->delete();

        return response()->json(['message' => 'Chat Room deleted successfully'], 200);
    }

    private function getAccessibleUsers()
    {
        $role = auth()->user()->getRoleNames()->first();

        if ($role == 'super_admin' || $role == 'owner') {
            return User::all();
        } else {
            $user = auth()->user()->load('teams.projects');
            $projectIds = $user->teams->flatMap(function ($team) {
                return $team->projects->pluck('id');
            })->unique()->toArray();

            $teamIds = $user->teams->pluck('id')->toArray();

            return User::whereHas('teams.projects', function ($query) use ($projectIds) {
                $query->whereIn('project_id', $projectIds);
            })->orWhereHas('teams', function ($query) use ($teamIds) {
                $query->whereIn('team_id', $teamIds);
            })->get();
        }
    }
}

