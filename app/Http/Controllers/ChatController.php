<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Interfaces\ChatInterface;
use App\Models\Message;

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
            'file' => 'nullable|file|max:5120',
            'receiver_id' => 'required|exists:users,id',
            'candidate_id' => 'required|int'
        ]);

        $filePath = null;
        $fileType = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('chat_uploads', 'public');
            $fileType = explode('/', $file->getMimeType())[0];
        }

        $message = new Message();
        $message->candidate_id = $data['candidate_id'];
        $message->user_id = auth()->user()->id;
        $message->receiver_id = $data['receiver_id'];
        $message->text = $data['text'];
        $message->file_path = $filePath ?? null;
        $message->file_type = $fileType ?? null;

        $message->save();

        //broadcast(new MessageSent($message->load('sender', 'receiver')))->toOthers();

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
