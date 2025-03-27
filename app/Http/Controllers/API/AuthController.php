<?php
namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\VerificationCodeMail;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
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

        // Generiši 4-cifreni verifikacioni kod
        $code = rand(1000, 9999);

        // Kreiraj korisnika
        $user = User::create([
            'first_name' => $validated['firstName'],
            'last_name' => $validated['lastName'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'verification_code' => $code,
        ]);

        // Pošalji kod na email
        Mail::to($user->email)->send(new VerificationCodeMail($user, $code));

        // Generiši JWT token
        $token = JWTAuth::fromUser($user);

        // Vrati podatke u odgovoru
        return response()->json([
            'jwt_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'message' => 'Verify code for authentification',
        ]);
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function verifyUser($userId,Request $request)
    {
        $user = User::findOrFail($userId);

        if($user)
        {
            $email = $request->email;
            $verificationCode = $request->verification_code;

            $user = User::where('email', $email)->where('verfication_code', $verificationCode)->first();
        
            if($user)
            {
                return response()->json([
                    'message' => 'User credentials is ok'
                ]);
            }
            else
            {
                return response()->json([
                    'error' => 'User with this credentials doesnt exist please check email and verification code', 
                ]);
            }

        }
        else
        {
            return response()->json([
                'error' => 'User doesnt exist', 
            ]);
        }
    }
}
