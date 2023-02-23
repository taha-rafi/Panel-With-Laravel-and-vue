<?php

namespace Examyou\LaravelInstaller\Middleware;

use Closure;
use DB;

/**
 * Class canInstall
 * @package Examyou\LaravelInstaller\Middleware
 */

class canInstall
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

		if ($this->alreadyInstalled()) {
			abort(404);
		}

		return $next($request);
	}

	/**
	 * If application is already installed.
	 *
	 * @return bool
	 */
	public function alreadyInstalled()
	{
		return file_exists(storage_path('installed'));
	}
}
