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
            'candidate_id' => 'required|int'
        ]);
    
        $filePath = null;
        $fileType = null;
    
        $message = new Message();
        $message->candidate_id = $data['candidate_id'];
        $message->user_id = auth()->user()->id;
        $message->receiver_id = $data['receiver_id'];
        $message->text = $data['text'];
        $message->file_path = $filePath;
        $message->file_type = $fileType;
    
        $message->save();
    
        $message->load('sender', 'receiver');
    
        Log::info('📨 Nova poruka kreirana:', $message->toArray());
    
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
        ->orderBy('created_at', 'asc')
        ->get();
    
        return response()->json($messages);
    }
    
}
