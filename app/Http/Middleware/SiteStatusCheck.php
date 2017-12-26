<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class SiteStatusCheck
{
    /**
     * Handle an incoming request.
     * 检测网站状态
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        if (!isset(Cache::get('SETTINGS')['SITE_STATUS']) || Cache::get('SETTINGS')['SITE_STATUS'] == '0') {
            return redirect(route('notice'));
        }
        return $next($request);
    }
}
