<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\VerificationCodeMail;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'firstName' => 'required|string|max:50',
            'lastName' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'passwordConfirm' => 'required|string|same:password',
        ]);
    
        $code = rand(1000, 9999);
    
        $role = Role::where('name', 'candidat')->first();
    
        if (!$role) {
            return response()->json([
                'error' => 'Role does not exist',
            ], 404);
        }
    
        $user = User::create([
            'first_name' => $validated['firstName'],
            'last_name' => $validated['lastName'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'verification_code' => $code,
            'verification_expires_at' => now()->addMinutes(2),
            'role_id' => $role->id,
        ]);
    
        Mail::to($user->email)->send(new VerificationCodeMail($user, $code));
    
        $token = JWTAuth::fromUser($user);
    
        return response()->json([
            'jwt_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'message' => 'Verify code sent to email.',
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        $user = auth()->user();
    
        return response()->json([
            'jwt_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'message' => 'Login successful.'
        ], 200);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function verifyUser($userId, Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'verification_code' => 'required|digits:4',
        ]);

        $user = User::where('id', $userId)
                    ->where('email', $request->email)
                    ->first();

        if (!$user) {
            return response()->json([
                'error' => 'User does not exist.',
            ], 404);
        }

        if (now()->greaterThan($user->verification_expires_at)) {
            return response()->json([
                'error' => 'Verification code expired, please resend.',
            ], 410);
        }

       
        if ((string) $user->verification_code !== (string) $request->verification_code) {
            return response()->json([
                'error' => 'Invalid verification code.',
            ], 422);
        }

       
        $user->email_verified_at = now();
        $user->save();

        return response()->json([
            'message' => 'Verification successful.',
        ], 200);
    }

    public function verifyUserResendVerificationCode($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'error' => 'User does not exist.',
            ], 404);
        }

        $newCode = rand(1000, 9999);
        $user->verification_code = $newCode;
        $user->verification_expires_at = now()->addMinutes(2);
        $user->save();

        Mail::to($user->email)->send(new VerificationCodeMail($user, $newCode));

        return response()->json([
            'message' => 'New verification code sent to email.',
        ], 200);
    }
}
