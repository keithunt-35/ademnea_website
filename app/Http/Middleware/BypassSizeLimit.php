<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BypassSizeLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        ini_set('upload_max_filesize', '50M');
        ini_set('post_max_size', '55M');
        return $next($request);
    }
}
