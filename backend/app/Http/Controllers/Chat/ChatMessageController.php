<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\Chat\ChatMessage;
use App\Models\User;
use App\Notifications\Chat\NewChatMessageRecieved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatMessageController extends Controller
{
    public function getUserChats(Request $request)
    {
        return User::where('id', '<>', Auth::id())->select(['id', 'name'])->get();
    }

    public function getChatMessages(Request $request)
    {
        $request->validate([
            'chatMemberId' => 'numeric',
            'take' => 'numeric'
        ]);

        return ChatMessage::query()
            ->where([['sender_id', Auth::id()], ['recipient_id', $request->chatMemberId]])
            ->orWhere([['recipient_id', Auth::id()], ['sender_id', $request->chatMemberId]])
            ->orderByDesc('id')
            ->take($request->take)
            ->get()
        ;
    }

    public function saveMessage(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'editingMessageId' => 'numeric|nullable',
            'chatId' => 'numeric|nullable',
        ]);

        if($request->editingMessageId) {
            $chatMessage = ChatMessage::findOrFail($request->editingMessageId);
        } 
        else {
            $chatMessage = new ChatMessage();
            $chatMessage->sender_id = Auth::id();
            $chatMessage->recipient_id = $request->chatId;
            User::find(Auth::id())->notify(new NewChatMessageRecieved($request->chatId));
        }

        $chatMessage->message = $request->message;
        
        return response($chatMessage->save());
    }
}
