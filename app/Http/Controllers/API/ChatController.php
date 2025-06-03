<?php
namespace app\Http\Controllers\API;
use App\Models\User;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

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

         Log::info(' Nova poruka kreirana:', $message->toArray());
    
        broadcast(new MessageSent($message));
        
        return response()->json([
            'success' => 'Message has been sent',
            'message' => $message
        ], 201);


    }

    public function getMessages($receiverId)
    {

         $user =  JWTAuth::parseToken()->authenticate();
         $messages = Message::where(function ($q) use ($user, $receiverId) {
            $q->where('user_id', $user->id)->where('receiver_id', $receiverId);
        })->orWhere(function ($q) use ($user, $receiverId) {
            $q->where('user_id', $receiverId)->where('receiver_id', $user->id);
        })
        ->orderBy('created_at', 'ASC')
        ->get();
    
        return response()->json($messages);
    }



    public function getChatContacts()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $userId = $user->id;

            // Pronađi sve poruke koje uključuju ovog korisnika
            $allMessages = Message::where('sender_id', $userId)
                ->orWhere('receiver_id', $userId)
                ->orderByDesc('created_at')
                ->get();

            // Grupisanje po korisniku s kojim se čatovalo (druga strana)
            $grouped = $allMessages->groupBy(function ($msg) use ($userId) {
                return $msg->sender_id === $userId ? $msg->receiver_id : $msg->sender_id;
            });

            // Sortiranje po najnovijoj poruci
            $sortedUserIds = $grouped->sortByDesc(function ($group) {
                return $group->first()->created_at;
            })->keys()->all();

            // Dohvatanje korisnika redosledom
            $users = User::whereIn('id', $sortedUserIds)
                ->get()
                ->sortBy(function ($user) use ($sortedUserIds) {
                    return array_search($user->id, $sortedUserIds);
                })
                ->values();

            return response()->json([
                'success' => true,
                'data' => $users
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Greška prilikom dohvaćanja kontakata.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}