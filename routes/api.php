<?php
use Illuminate\Http\Request;
use App\Models\CandidatProfile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
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
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('/me', [AuthController::class, 'me']);
Route::post('/verify-user/{userId}', [AuthController::class, 'verifyUser']);
Route::post('/verify-user/{userId}/resend-code', [AuthController::class, 'verifyUserResendVerificationCode']);

Route::get('/cities/{countryId}', [FrontController::class, 'getCitiesByCountry']);
Route::get('/countries', [FrontController::class, 'getCountries']);
Route::get('/country/{countryId}/currency', [FrontController::class, 'getCurrency']);
Route::get('/country/{countryId}/phone-code', [FrontController::class, 'getPhoneCode']);

//only logged users can use chat
Route::middleware('auth:api')->group(function () {
    Broadcast::routes();

    //chats
    Route::get('/messages/{receiverId}', [ApiChatController::class, 'getMessages']); // prikaz poruka
    Route::post('/messages', [ApiChatController::class, 'store']); // slanje poruka
    Route::get('/active/contacts/chats', [ApiChatController::class, 'getChatContacts']);
    Route::post('/messages/mark-as-read/{userId}', [ApiChatController::class, 'markAsRead']);

    Route::get('/messages/total/unread/count', [ApiChatController::class, 'totalUnreadCount']);
    //store Candidat Profile
    // Route::post('/candidat/profile/create', [CandidateProfileController::class, 'store']);
    Route::post('/candidat/profile/update/{userId}', [CandidateProfileController::class, 'update']); // Ažuriranje profila
    Route::get('/candidat/{id}', [CandidateProfileController::class, 'getCandidat']);
    //jobs
    Route::get('/jobs/active/', [FrontController::class, 'activeJobs']); // Prikaz aktivnih poslova
    Route::get('/job/{id}', [FrontController::class, 'showJob']); // Detalji o poslu

    //kroz bodi neka dodje user id 
    Route::post('/job/{jobId}/candidat/{candidatId}/apply', [FrontController::class, 'applyJob']);
    Route::get('/job/{jobId}/candidat/{candidatId}/apply', [FrontController::class, 'alreadyApplyJob']);

    //recruitment process
    Route::get('/applied-jobs/', [RecruitmentController::class, 'getAppliedJobsByCandidate']);

    //settings
   Route::post('/update-email', [SettingsController::class, 'updateEmail']);
   Route::post('/update-password', [SettingsController::class, 'updatePassword']);

   //chat
   Route::post('/store/messages', [ApiChatController::class, 'store']);

   //recruitment process za joneta
    Route::get('/recruitment/status/{candidateJobId}', [RecruitmentController::class, 'showStatus']);

});



Route::middleware('auth:api')->get('/me', function (Request $request) {
    return response()->json($request->user());
});



Route::post('/broadcasting/auth', function (Request $request) {
    return Broadcast::auth($request);
})->middleware('jwt.auth');

Route::post('/broadcasting/debug-auth', function (Request $request) {
    return response()->json([
        'auth_user' => auth()->user(),
        'token' => $request->bearerToken(),
        'channel' => $request->channel_name,
    ]);
})->middleware('jwt.auth');

//AI ROUTES
Route::post('/chat/search', [ChatAiController::class, 'handle']);
Route::middleware('auth:api')->post('/chat/search/user', [ChatAiController::class, 'handleWithUserRequest']);
