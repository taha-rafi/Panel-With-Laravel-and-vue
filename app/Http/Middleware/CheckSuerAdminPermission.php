<?php

namespace App\Http\Middleware;

use Closure;
use Examyou\RestAPI\Exceptions\UnauthorizedException;

class CheckSuerAdminPermission
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
        // api.users.index.v1

        if (auth('api')->check() && env('APP_ENV') == 'production') {

            $resourceRequests = ['store', 'update', 'destroy'];
            $urlArray = explode('.', $request->route()->action['as']);
            $resourcePathString = $urlArray[2];
            $resourceRequestString = $urlArray[3];

            // if ($urlArray && $urlArray[1]) {
            //     $routePathString = str_replace('-', '_', $urlArray[1]);
            // }

            // Those route for which we don't want to check permission
            // We will check permission for those on controller level
            $chekResourcePath = ['writer-categories', 'writer-templates'];

            if (in_array($resourcePathString, $chekResourcePath) === false && in_array($resourceRequestString, $resourceRequests)) {
                throw new UnauthorizedException("Not Allowed in Demo");
            }
        }

        return $next($request);
    }
}
