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
}