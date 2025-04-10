<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Interfaces\ChatInterface;

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
        ]);

        $filePath = null;
        $fileType = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('chat_uploads', 'public');
            $fileType = explode('/', $file->getMimeType())[0];
        }

        $message = $request->user()->messages()->create([
            'receiver_id' => $data['receiver_id'],
            'text' => $data['text'] ?? null,
            'file_path' => $filePath ?? null,
            'file_type' => $fileType ?? null,
        ]);

        broadcast(new MessageSent($message->load('sender', 'receiver')))->toOthers();

        return response()->json(['message' => $message]);
    }

}
