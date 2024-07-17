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
        // اعتبارسنجی درخواست
        $request->validate([
            'message' => 'required'
        ]);

        // ایجاد پیام جدید
        Message::create([
            'chat_room_id' => $chatRoom->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        // بازگشت به صفحه نمایش چت روم
        return redirect()->route('chats.show', $chatRoom);
    }
}
