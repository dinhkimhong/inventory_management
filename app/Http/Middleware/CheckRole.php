<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->authorizeRoles('AD'))
        {
            return $next($request);            
        }
        return back()->withMessage('Your are not authorized for this transaction');
    }
}
