<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OpenAiService;
use App\Models\Category;
use App\Models\City;
use App\Models\Job;

class ChatAiController extends Controller
{
    protected $ai;

    public function __construct(OpenAiService $ai)
    {
        $this->ai = $ai;
    }

    public function handle(Request $request)
    {
        $userMessage = $request->input('message');

        // Prvo proveravamo da li je pitanje relevantno za poslove
        if (!$this->ai->askIntent($userMessage)) {
            return response()->json([
                'message' => 'Trenutno mogu da ti pomognem samo oko poslova. Na primer: "Frontend poslovi u Beogradu".'
            ]);
        }

        // Vadimo parametre iz AI odgovora
        $params = $this->ai->extractSearchParams($userMessage);

        $category = Category::where('name', 'ILIKE', $params['category'] ?? '')->first();
        $city = City::where('name', 'ILIKE', $params['city'] ?? '')->first();

        if (!$category || !$city) {
            return response()->json(['message' => 'Nismo uspeli da prepoznamo kategoriju ili grad. Probaj ponovo.']);
        }

        $jobs = Job::where('category_id', $category->id)
                   ->where('city_id', $city->id)
                   ->get();

        return response()->json(['jobs' => $jobs]);
    }

    public function handleWithUserRequest(Request $request)
    {
        $user = auth()->user(); // 🔐 Proveravamo JWT korisnika

        if (!$user) {
            return response()->json(['message' => 'Niste autentifikovani.'], 401);
        }

        $message = $request->input('message');

        if (!$this->ai->askIntent($message)) {
            return response()->json([
                'message' => 'Trenutno mogu da pomognem samo sa poslovima. Na primer: "Frontend u Novom Sadu".'
            ]);
        }

        // 🧠 AI obrada uz korisnika kao kontekst
        $params = $this->ai->extractSearchParamsWithUser($message, $user);

        $category = Category::where('name', 'ILIKE', $params['category'] ?? '')->first();
        $city = City::where('name', 'ILIKE', $params['city'] ?? '')->first();

        if (!$category || !$city) {
            return response()->json(['message' => 'Nismo prepoznali kategoriju ili grad.']);
        }

        $jobs = Job::where('category_id', $category->id)
                ->where('city_id', $city->id)
                ->get();

        return response()->json([
            'user_id' => $user->id,
            'search' => $params,
            'results' => $jobs
        ]);
    }

}
