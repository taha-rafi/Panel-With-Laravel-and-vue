<?php

namespace App\Http\Middleware;

use Closure;
use Examyou\RestAPI\Exceptions\UnauthorizedException;

class CheckPermission
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

        if (auth('api')->check()) {
            $user = auth('api')->user();

            $resourceRequests = ['index', 'store', 'update', 'show', 'destroy'];
            $urlArray = explode('.', $request->route()->action['as']);
            $resourceRequestString = $urlArray[2];

            if ($urlArray && $urlArray[1]) {
                $routePathString = str_replace('-', '_', $urlArray[1]);
            }

            // Those route for which we don't want to check permission
            // We will check permission for those on controller level
            $skipResourcePath = ['work-spaces', 'writer-documents'];

            if (in_array($resourceRequestString, $resourceRequests) && in_array($routePathString, $skipResourcePath) === false) {

                // Lang resource will have translations permission
                if ($routePathString == 'langs') {
                    $routePathString = "translations";
                }

                $permission = "";
                $requestFields = $request->fields;

                if (($resourceRequestString == 'index' || $resourceRequestString == 'show') && $requestFields != null) {
                    $permission = $routePathString . '_view';
                }

                if ($resourceRequestString == 'store') {
                    $permission = $routePathString . '_create';
                } else if ($resourceRequestString == 'update') {
                    $permission = $routePathString . '_edit';
                } else if ($resourceRequestString == 'destroy') {
                    $permission = $routePathString . '_delete';
                }

                if ($permission != "" && !$user->ability('admin', $permission)) {
                    throw new UnauthorizedException("Don't have valid permission");
                }
            }
        }

        return $next($request);
    }
}
