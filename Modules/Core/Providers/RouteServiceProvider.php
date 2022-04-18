<?php

namespace Modules\Core\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapModuleRoutes();
    }

    /**
     * Map routes from all enabled modules.
     *
     * @return void
     */
    private function mapModuleRoutes()
    {
        foreach ($this->app['modules']->allEnabled() as $module) {
            $this->groupRoutes(function () use ($module) {
                $this->mapPublicRoutes("{$module->getPath()}/Routes/api.php");
            });
        }
    }


    /**
     * Group routes to common prefix and middleware.
     *
     * @param string $namespace
     * @param \Closure $callback
     * @return void
     */
    private function groupRoutes($callback)
    {
        Route::group([
            'prefix' => 'api',
            'middleware' => ['api'],
        ], function () use ($callback) {
            $callback();
        });
    }


    /**
     * Map public routes.
     *
     * @param string $path
     * @return void
     */
    private function mapPublicRoutes($path)
    {
        if (file_exists($path)) {
            require_once $path;
        }
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
