<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CandidateProfileController;
use App\Http\Controllers\API\FrontController;
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

//store Candidat Profile
Route::post('/candidat/profile/create', [CandidateProfileController::class, 'store']);