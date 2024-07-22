<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(Request $request, ChatRoom $chatRoom)
    {
        
        $request->validate([
            'message' => 'required'
        ]);

    
        Message::create([
            'chat_room_id' => $chatRoom->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        
        return redirect()->route('chats.show', $chatRoom);
    }
}
