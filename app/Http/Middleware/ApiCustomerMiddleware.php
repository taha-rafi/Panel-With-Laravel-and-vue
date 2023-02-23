<?php

namespace App\Http\Middleware;

use Closure;
use Examyou\RestAPI\Exceptions\ApiException;

class ApiCustomerMiddleware
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
		if (!auth('api_front')->check()) {
			throw new ApiException('UNAUTHORIZED EXCEPTION', null, 401, 401);
		}

		return $next($request);
	}
}
