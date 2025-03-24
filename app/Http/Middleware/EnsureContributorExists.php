<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureContributorExists
{
    public function handle(Request $request, Closure $next)
    {
       // Ensure the user is authenticated and has the "Contributor" role
        if (!Auth::check() || Auth::user()->role_id != 4) {
            return abort(403); // Forbidden
        }

        $user = Auth::user();

        // Ensure the user has a contributor record
        if (!$user->contributor) {
            return redirect()->route('contributor-dashboard')->with('error', 'Please complete your contributor profile to proceed.');
        }

        return $next($request);

    }
}
