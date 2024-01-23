<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetChatMessagesRequest;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Models\Chat\ChatMessage;
use App\Models\User;
use App\Notifications\Chat\NewChatMessageRecieved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatMessageController extends Controller
{
    public function getUserChats()
    {
        return User::where('id', '<>', Auth::id())
            ->select(['id', 'name'])->get();
    }

    public function getChatMessages(GetChatMessagesRequest $request)
    {
        $chatMessages = ChatMessage::query()
            ->where([['sender_id', Auth::id()], ['recipient_id', $request->chatMemberId]])
            ->orWhere([['recipient_id', Auth::id()], ['sender_id', $request->chatMemberId]])
            ->orderByDesc('id')
            ->take($request->take)
            ->get()
            ->toArray();

        return response(array_reverse($chatMessages));
    }

    public function storeMessage(StoreMessageRequest $request)
    {
        $chatMessage = new ChatMessage();
        $chatMessage->sender_id = Auth::id();
        $chatMessage->recipient_id = $request->chatId;
        // VS-Code подсвечивает ошибку при Auth::user()->notify. поэтому User::find(Auth::id())->notify
        User::find(Auth::id())->notify(new NewChatMessageRecieved($request->chatId));
        $chatMessage->message = $request->message;
        
        return response($chatMessage->save());
    }

    public function updateMessage(UpdateMessageRequest $request)
    {
        $chatMessage = ChatMessage::findOrFail($request->editingMessageId);
        $chatMessage->message = $request->message;
        
        return response($chatMessage->save());
    }
}
