<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class SiteStatusCheck
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
        if (Cache::get(env('APP_NAME') . '_SETTINGS')['SITE_STATUS'] == '1') {
            return redirect(route('notice'));
        }
        return $next($request);
    }
}
