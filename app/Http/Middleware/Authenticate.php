<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Authenticate
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
        if (!Auth::check()) {
            return redirect(route('login')) -> with('error', 'Time out, please sign in again.');
        }
        if (!isset(session('permissions')[$request -> getPathInfo()])) {
            return redirect(route('notify')) -> with('error', 'Oops, you don\'t have the permission.');
        }
        return $next($request);
    }
}
