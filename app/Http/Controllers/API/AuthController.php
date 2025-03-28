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

        // Generiši 4-cifreni verifikacioni kod
        $code = rand(1000, 9999);

        $role = Role::where('name', 'candidat')->first();

        if($role)
        {
            $user = User::create([
                'first_name' => $validated['firstName'],
                'last_name' => $validated['lastName'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'verification_code' => $code,
                'verification_expires_at' => now()->addMinutes(2),
                'role_id' => 5,
    
            ]);
             // Pošalji kod na email
            Mail::to($user->email)->send(new VerificationCodeMail($user, $code));

            // Generiši JWT token
            $token = JWTAuth::fromUser($user);

            // Vrati podatke u odgovoruU
            return response()->json([
                'jwt_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
                'message' => 'Verify code for authentification',
            ]);
        }
        else
        {
            return response()->json([
                'error' => 'Role doesnt exists'
            ]);
        }
       

       
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

    public function verifyUser($userId, Request $request)
    {
        $verificationCode = trim((string)$request->verification_code);
     
        $user = User::find($userId);

        if ($user) {
           
           
                if (now()->greaterThan($user->verification_expires_at)) {
                    
                    return response()->json([
                        'error' =>  'Verification code expired, please click to resend verification code.',
                    ], 410);
                }
                else
                {
                    $storedCode = trim((string) $user->verification_code);
                    if($storedCode !== $verificationCode)
                    {
                        return response()->json([
                            'error' => 'Your code is not valid'
                        ], 422);
                    }
                    else
                    {
                        // Kod je validan i još važi
                        return response()->json([
                            'message' => 'User credentials are valid.',
                        ], 200);
                    }
                }
                
                
        } else {
            return response()->json([
                'error' => 'User doesnt exist',
            ], 404);
        }
    }

    public function verifyUserResendVerificationCode($userId)
    {
        $user = User::find($userId);

        if($user)
        {
            // Ako je kod istekao – generiši novi i pošalji
            if (now()->greaterThan($user->verification_expires_at)) {
                
                $newCode = rand(1000, 9999);
                $user->verification_code = $newCode;
                $user->verification_expires_at = now()->addMinutes(2);
                $user->save();
    
                // Pošalji novi kod
                Mail::to($user->email)->send(new VerificationCodeMail($user, $newCode));
    
                return response()->json([
                    'error' => 'Verification code expired. New verification code is sent by email.',
                    'resend' => true,
                ], 400);
            }
    
            // Kod je važeći – potvrdi korisnika ako želiš ovde
            return response()->json([
                'message' => 'Verification is successfully.',
            ], 200);
        }
        else
        {
            return response()->json([
                'error' => 'User doesnt exist', 
            ], 404);
        }
    }
}
