<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContributorMiddleware
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
        //contributor in roles table is id 4
        if (auth()->check() && auth()->user()->role_id != 4) {
            return abort(403);
        }
        return $next($request);
    }
}
