<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;

use App\Http\Controllers\JobController;
use App\Http\Controllers\ChatAiController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FrontController;
use App\Http\Controllers\API\SettingsController;
use App\Http\Controllers\API\RecruitmentController;
use App\Http\Controllers\API\CandidateProfileController;
use App\Http\Controllers\API\ChatController as ApiChatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ✅ AUTH (PUBLIC)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/verify-user/{userId}', [AuthController::class, 'verifyUser']);
Route::post('/verify-user/{userId}/resend-code', [AuthController::class, 'verifyUserResendVerificationCode']);

// ✅ SYSTEM TEST / DEBUG (PUBLIC)
Route::get('/ping', fn () => response()->json(['pong' => true]));
Route::post('/chat/debug-test', function (\Illuminate\Http\Request $request) {
    try {
        $ai = app(\App\Services\AI\OpenAiService::class);
        $response = $ai->chat([
            'messages' => [
                ['role' => 'user', 'content' => 'Hello AI, are you working?']
            ]
        ]);

        return response()->json($response);
    } catch (\Throwable $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }
});


// ✅ BROADCASTING AUTH (PUBLIC, ali sa JWT zaštitom)
Route::post('/broadcasting/auth', fn (Request $request) => Broadcast::auth($request))->middleware('jwt.auth');
Route::post('/broadcasting/debug-auth', function (Request $request) {
    return response()->json([
        'auth_user' => auth()->user(),
        'token' => $request->bearerToken(),
        'channel' => $request->channel_name,
    ]);
})->middleware('jwt.auth');

// ✅ PUBLIC INFO (NO AUTH)
Route::get('/cities/{countryId}', [FrontController::class, 'getCitiesByCountry']);
Route::get('/countries', [FrontController::class, 'getCountries']);
Route::get('/country/{countryId}/currency', [FrontController::class, 'getCurrency']);
Route::get('/country/{countryId}/phone-code', [FrontController::class, 'getPhoneCode']);

// ✅ USER DATA ACCESS (AUTH)
Route::middleware('auth:api')->group(function () {
    Route::get('/me', fn (Request $request) => response()->json($request->user()));
    Route::get('/user', fn (Request $request) => $request->user());

    // ✅ CHAT (REAL-TIME)
    Route::get('/messages/{receiverId}', [ApiChatController::class, 'getMessages']);
    Route::post('/messages', [ApiChatController::class, 'store']);
    Route::post('/store/messages', [ApiChatController::class, 'store']); // moguće duplikat
    Route::get('/active/contacts/chats', [ApiChatController::class, 'getChatContacts']);
    Route::post('/messages/mark-as-read/{userId}', [ApiChatController::class, 'markAsRead']);
    Route::get('/messages/total/unread/count', [ApiChatController::class, 'totalUnreadCount']);
    Route::get('/messages/unread/count', [ApiChatController::class, 'unreadCount']);

    // ✅ CHAT AI
    Route::post('/chat/search', [ChatAiController::class, 'handle']);
    Route::post('/chat/search/user', [ChatAiController::class, 'handleWithUserRequest']);
    Route::get('/chat/history', [ChatAiController::class, 'history']);
    Route::get('/job/{id}/translated', [ChatAiController::class, 'getTranslatedJob']);

    // ✅ CANDIDATE PROFILE
    Route::post('/candidat/profile/update/{userId}', [CandidateProfileController::class, 'update']);
    Route::get('/candidat/{id}', [CandidateProfileController::class, 'getCandidat']);

    // ✅ JOBS
    Route::get('/jobs/active/national', [FrontController::class, 'activeJobs']);
    Route::get('/jobs/active/international', [FrontController::class, 'activeJobsInternational']);
    Route::get('/job/{id}', [FrontController::class, 'showJob']);
    Route::post('/job/{jobId}/candidat/{candidatId}/apply', [FrontController::class, 'applyJob']);
    Route::get('/job/{jobId}/candidat/{candidatId}/apply', [FrontController::class, 'alreadyApplyJob']);

    // ✅ RECRUITMENT
    Route::get('/applied-jobs', [RecruitmentController::class, 'getAppliedJobsByCandidate']);
    Route::get('/job/{jobId}/candidat/{candidateId}/check', [JobController::class, 'hasAlreadyApplied']);
    Route::get('/recruitment/status/{candidateJobId}', [RecruitmentController::class, 'showStatus']);

    // ✅ SETTINGS
    Route::post('/update-email', [SettingsController::class, 'updateEmail']);
    Route::post('/update-password', [SettingsController::class, 'updatePassword']);
});
