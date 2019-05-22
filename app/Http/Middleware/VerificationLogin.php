<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\Common\ReturnJson;

class VerificationLogin
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
        if (empty($request->user_id)) {
            return ReturnJson::response([],'300','非法操作');
        }

        return $next($request);
    }
}
