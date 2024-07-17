<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Http\Request;

class ChatRoomController extends Controller
{
    public function index()
    {
        $chatRooms = ChatRoom::all();
        $users = User::all();
        return view('chats.index', compact('chatRooms', 'users'));
    }

    public function show(ChatRoom $chatRoom)
    {
        $messages = $chatRoom->messages()->with('user')->oldest()->get();
        return view('chats.show', compact('chatRoom', 'messages'));
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

        return redirect()->route('chats.index');
    }

    public function edit(ChatRoom $chatRoom)
    {
        $users = User::all();
        return view('chats.edit', compact('chatRoom', 'users'));
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

        return redirect()->route('chats.index');
    }

    public function destroy(ChatRoom $chatRoom)
    {
        $chatRoom->delete();

        return redirect()->route('chats.index');
    }
}
