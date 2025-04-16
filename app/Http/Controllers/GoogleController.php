<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
{
    return Socialite::driver('google')
        ->redirect();
}


    public function handleGoogleCallback()
    {
        
        $googleUser = Socialite::driver('google')->user();

        $fullName = $googleUser->getName();
        
        $nameParts = explode(' ', $fullName, 2);
        
        $firstName = $nameParts[0];
     
        $lastName = isset($nameParts[1]) ? $nameParts[1] : '';
        
        // Check if the user already exists
        $user = User::where('email', $googleUser->getEmail())->first();
        
        if (!$user) {
            // Register the user
            $user = User::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => bcrypt(Str::random(16)), // Set a random password
            ]);
        }

        // Log in the user
        Auth::login($user);

        return redirect()->route('home'); // Redirect to your desired route
    }
}
