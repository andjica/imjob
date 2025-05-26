<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{


public function updateEmail(Request $request)
{
        $request->validate([
            'current_email' => 'required|email',
            'new_email' => 'required|email',
            'verification_code' => 'required',
        ]);

        $user = JWTAuth::parseToken()->authenticate();

        // (opciono) dodatna sigurnost: proveri da li current_email odgovara korisniku iz tokena
        if ($user->email !== $request->current_email) {
            return response()->json([
                'error' => 'Current email does not match logged-in user.',
            ], 403);
        }

        // Proveri da li novi email već postoji u sistemu
        $emailExists = User::where('email', $request->new_email)->exists();
        if ($emailExists) {
            return response()->json([
                'error' => 'New email is already in use.',
            ], 409);
        }

        // Proveri da li je verifikacioni kod istekao
        if (now()->greaterThan($user->verification_expires_at)) {
            return response()->json([
                'error' => 'Verification code expired.',
            ], 410);
        }

        // Proveri da li je kod tačan
        if ((string) $user->verification_code !== (string) $request->verification_code) {
            return response()->json([
                'error' => 'Invalid verification code.',
            ], 422);
        }

        // Ako je sve u redu – ažuriraj email
        $user->email = $request->new_email;
        $user->email_verified_at = now();
        $user->is_mobile_verified = 1;
        $user->save();

        return response()->json([
            'message' => 'Email successfully updated.',
            'user' => $user
        ], 200);
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8',
            'confirm_password' => 'required|string|same:new_password',
        ]);

        $user = JWTAuth::parseToken()->authenticate();

       
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'error' => 'Current password is incorrect.',
            ], 403);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        return response()->json([
            'message' => 'Password successfully updated.',
        ], 200);
    }


}