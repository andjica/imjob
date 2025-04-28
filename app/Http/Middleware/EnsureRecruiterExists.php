<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureRecruiterExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && (Auth::user()->role_id == 2 || Auth::user()->role_id == 3)) 
        { 
            $user = Auth::user();

          
            if (!$user->recruiter) 
            {
               
                if(Auth::user()->role_id == 2)
                {
                    return redirect()->route('company-freelancer-create')->with('error', 'Please complete your freelancer profile to proceed. 1');
                }
                return redirect()->route('recruiter-create')->with('error', 'Please complete your freelancer profile to proceed. 2');
                
            }
        }
        return $next($request);
    }
}
