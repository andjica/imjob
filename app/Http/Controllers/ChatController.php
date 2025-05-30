<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Interfaces\ChatInterface;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    protected $chat;

    public function __construct(ChatInterface $chat)
    {
        $this->chat = $chat;
    }

    public function index(Request $request)
    {
        $request->validate(['receiver_id' => 'required|exists:users,id']);

        $userId = $request->user()->id;
        $receiverId = $request->receiver_id;

        $messages = $this->chat->getMessagesBetween($userId, $receiverId);

        return response()->json($messages);
    }
    

    public function store(Request $request)
    {
        $data = $request->validate([
            'text' => 'nullable|string',
            'receiver_id' => 'required|exists:users,id',
        ]);
    
        $message = new Message();
        if ($request->hasFile('file')) 
         {
                $file = $request->file('file');
                $path = $file->store('uploads/chat_files', 'public');
                $message->file_path = $path;
                $message->file_type = $file->getClientMimeType();
        }
        $message->user_id = auth()->user()->id;
        $message->receiver_id = $data['receiver_id'];
        $message->text = $data['text'];
    
        $message->save();
    
        $message->load('sender', 'receiver');
    
        Log::info(' Nova poruka kreirana:', $message->toArray());
    
        broadcast(new MessageSent($message));
    
        return response()->json(['message' => $message]);
    }
    

    public function getMessages($receiverId)
    {
        $user = auth('web')->user();
    
        $messages = Message::where(function ($q) use ($user, $receiverId) {
            $q->where('user_id', $user->id)->where('receiver_id', $receiverId);
        })->orWhere(function ($q) use ($user, $receiverId) {
            $q->where('user_id', $receiverId)->where('receiver_id', $user->id);
        })
        ->orderBy('created_at', 'DESC')
        ->get();
    
        return response()->json($messages);
    }
    
    public function markAsRead($userId, Request $request)
    {
        $receiverId = auth()->user()->id;
        $userId = $request->userId;

        Message::where('user_id', $userId)
            ->where('receiver_id', $receiverId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['status' => 'ok']);
    }

    public function unreadCount(Request $request)
    {
        $userId = $request->user()->id;

        $counts = Message::select('user_id')
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->groupBy('user_id')
            ->selectRaw('user_id, COUNT(*) as unread_count')
            ->get();

        return response()->json($counts);
    }


    public function unreadTotal(Request $request)
    {
        $userId = $request->user()->id;

        $count = Message::where('receiver_id', $userId)
            ->where('is_read', false)
            ->count();

        return response()->json(['unread_total' => $count]);
    }
}
