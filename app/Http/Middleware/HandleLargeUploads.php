<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HandleLargeUploads
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
        // Override PHP settings for this request
        ini_set('upload_max_filesize', '50M');
        ini_set('post_max_size', '55M');
        ini_set('memory_limit', '256M');
        ini_set('max_execution_time', '300');

        return $next($request);
    }
}
