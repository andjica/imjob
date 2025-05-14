<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FrontController;
use App\Http\Controllers\API\CandidateProfileController;
use App\Models\CandidatProfile;

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
    Route::get('/messages', [ChatController::class, 'index']); // prikaz poruka
    Route::post('/messages', [ChatController::class, 'store']); // slanje poruka
<<<<<<< Updated upstream
    //store Candidat Profile
    // Route::post('/candidat/profile/create', [CandidateProfileController::class, 'store']);
    Route::post('/candidat/profile/update/{userId}', [CandidateProfileController::class, 'update']); // Ažuriranje profila
    Route::get('/candidat/{id}', [CandidateProfileController::class, 'getCandidat']);
    //jobs
    Route::get('/jobs/active/', [FrontController::class, 'activeJobs']); // Prikaz aktivnih poslova
    Route::get('/job/{id}', [FrontController::class, 'showJob']); // Detalji o poslu
    Route::post('/job/{id}/apply', [FrontController::class, 'applyJob']); // Prijava na posao
});

Route::middleware('auth:api')->get('/me', function (Request $request) {
    return response()->json($request->user());
});

// 🎯 WEB + VUE korisnici (Sanctum)
Route::middleware(['auth:sanctum'])->prefix('messages')->group(function () {
    Route::get('/messages', [ChatController::class, 'index']); // prikaz poruka
    Route::post('/messages', [ChatController::class, 'store']); // slanje poruka   
    Route::post('/mark-as-read/{userId}', [ChatController::class, 'markAsRead']);
    Route::get('/unread-count', [ChatController::class, 'unreadCount']);
    Route::get('/unread-total', [ChatController::class, 'unreadTotal']);
});
=======

});

Route::middleware('auth:sanctum')->post('/messages/mark-as-read/{userId}', [ChatController::class, 'markAsRead']);


// Route::middleware('auth:api')->get('/me', function (Request $request) {
//     return response()->json($request->user());
// });
>>>>>>> Stashed changes
