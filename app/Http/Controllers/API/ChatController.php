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
            $allMessages = Message::where('user_id', $userId)
                ->orWhere('receiver_id', $userId)
                ->orderByDesc('created_at')
                ->get();

            // Grupisanje po korisniku s kojim se čatovalo (druga strana)
            $grouped = $allMessages->groupBy(function ($msg) use ($userId) {
                return $msg->user_id === $userId ? $msg->receiver_id : $msg->user_id;
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
            ->map(function ($user) use ($userId) {
                // Broj nepročitanih poruka od ovog korisnika ka meni
                $unreadCount = Message::where('user_id', $user->id)
                    ->where('receiver_id', $userId)
                    ->where('is_read', false)
                    ->count();

                return [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'unread_count' => $unreadCount,
                ];
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

    public function markAsRead($userId, Request $request)
    {
        
        $receiverAuth = JWTAuth::parseToken()->authenticate();
        $receiverId = $receiverAuth->id;

        $userId = $request->user_id;

         Message::where('user_id', $userId)
            ->where('receiver_id', $receiverId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['status' => 'ok'], 200);
    }

    public function totalUnreadCount()
    {
        $userId = auth()->user()->id;

        $count = Message::where('receiver_id', $userId)
            ->where('is_read', false)
            ->count();

        return response()->json(['unread_total' => $count]);
    }

    public function unreadCount()
        {
            $userId = JWTAuth::parseToken()->authenticate();

            $counts = Message::select('user_id')
                ->where('receiver_id', $userId)
                ->where('is_read', false)
                ->groupBy('user_id')
                ->selectRaw('user_id, COUNT(*) as unread_count')
                ->get();

            return response()->json($counts);
        }

}

     public function unreadCount()
        {
            $userId = JWTAuth::parseToken()->authenticate();

            $counts = Message::select('user_id')
                ->where('receiver_id', $userId)
                ->where('is_read', false)
                ->groupBy('user_id')
                ->selectRaw('user_id, COUNT(*) as unread_count')
                ->get();

            return response()->json($counts);
        }

}