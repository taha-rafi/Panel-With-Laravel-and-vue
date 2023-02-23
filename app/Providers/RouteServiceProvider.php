<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers';

    protected $superAdminNamespace = 'App\\SuperAdmin\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                // ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            if (app_type() == 'saas' && file_exists(storage_path('installed'))) {
                Route::middleware('web')
                    ->namespace($this->superAdminNamespace)
                    ->group(base_path('app/SuperAdmin/routes/front.php'));
            }

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/front.php'));

            if (app_type() == 'non-saas') {
                Route::middleware('web')
                    ->namespace($this->namespace)
                    ->group(base_path('routes/app.php'));
            } else {
                Route::middleware('web')
                    ->namespace($this->superAdminNamespace)
                    ->group(base_path('app/SuperAdmin/routes/app.php'));
            }

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            if (app_type() == 'saas') {
                Route::middleware('web')
                    ->namespace($this->superAdminNamespace)
                    ->group(base_path('app/SuperAdmin/routes/superadmin.php'));
            }

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/common.php'));

            if (app_type() == 'non-saas') {
                Route::middleware('web')
                    ->namespace($this->namespace)
                    ->group(base_path('routes/main.php'));
            } else {
                Route::middleware('web')
                    ->namespace($this->superAdminNamespace)
                    ->group(base_path('app/SuperAdmin/routes/main.php'));
            }
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
