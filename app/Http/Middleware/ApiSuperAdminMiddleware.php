<?php

namespace App\Http\Middleware;

use Closure;
use Examyou\RestAPI\Exceptions\ApiException;

class ApiSuperAdminMiddleware
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
        if (!auth('api')->check() || !auth('api')->user()->is_superadmin) {
            throw new ApiException('UNAUTHORIZED EXCEPTION', null, 401, 401);
        }

        return $next($request);
    }
}
