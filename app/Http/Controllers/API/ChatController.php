<?php
namespace app\Http\Controllers\API;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Models\Message;

class ChatController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required',
            'receiver_id' => 'required'
        ]);

        $user =  JWTAuth::parseToken()->authenticate();
     
        $userId = $user->id;

        $message = new Message();
        $message->user_id = $userId;
        $message->receiver_id = $request->receiver_id;
        $message->text = $request->text;

        $message->save();

        return response()->json([
            'success' => 'Message has been sent',
            'message' => $message
        ], 201);


    }

    public function getMessage($receiverId)
    {

         $user =  JWTAuth::parseToken()->authenticate();
         $messages = Message::where(function ($q) use ($user, $receiverId) {
            $q->where('user_id', $user->id)->where('receiver_id', $receiverId);
        })->orWhere(function ($q) use ($user, $receiverId) {
            $q->where('user_id', $receiverId)->where('receiver_id', $user->id);
        })
        ->orderBy('created_at', 'DESC')
        ->get();
    
        return response()->json($messages);
    }
}