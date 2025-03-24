<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class CompanyFreelancerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        /** @var User $user */
        $user = auth()->user();

     
        if ($user->company) {
      
            if ($user->company->companyType->name !== 'Freelancer') {
                abort(403);
            }
        }

        return $next($request);
    }
}
