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
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Declare controller namespace for the api routes.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string
     */
    protected string $apiNamespace = 'App\Http\Controllers\API';

    /**
     * Declare api version for the api routes.
     *
     * When present, controller route declarations will automatically be prefixed with this version.
     *
     * @var string
     */
    protected string $apiVersion = 'V1';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            $this->mapApiRoutes();

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Api Routes
     * @return void
     */
    protected function mapApiRoutes()
    {
       Route::middleware('api')
        ->prefix('api/v1')
        ->as('api.v1.')
        ->namespace("{$this->apiNamespace}\{$this->apiVersion}")
        ->group(base_path('routes/api.php'));
    }
}
