<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
        $this->mapPanelRoutes();

        $this->mapUserRoutes();

        $this->mapMarketerRoutes();

        $this->mapLecturerRoutes();

        $this->mapParentRoutes();
    }

    protected function mapPanelRoutes()
    {
        Route::prefix('/' . LaravelLocalization::setLocale() . '/admin')->name('panel.')
            ->middleware(['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'shareGeneralSettings'])
            ->namespace("$this->namespace\Admin")
            ->group(base_path('routes/admin.php'));
    }

    protected function mapUserRoutes()
    {
        Route::prefix(LaravelLocalization::setLocale() . '/user')->name('user.')
            ->middleware('web')
            ->namespace($this->namespace . '\Front\User')
            ->group(base_path('routes/user.php'));
    }

    protected function mapMarketerRoutes()
    {
        Route::prefix(LaravelLocalization::setLocale() . '/user/marketer')->name('user.marketer.')
            ->middleware('web')
            ->namespace($this->namespace . '\Front\User\Marketer')
            ->group(base_path('routes/marketer.php'));
    }

    protected function mapLecturerRoutes()
    {
        Route::prefix(LaravelLocalization::setLocale() . '/user/lecturer')->name('user.lecturer.')
            ->middleware('web')
            ->namespace($this->namespace . '\Front\User\Lecturer')
            ->group(base_path('routes/lecturer.php'));
    }

    protected function mapParentRoutes()
    {
        Route::prefix(LaravelLocalization::setLocale() . '/user/parent')->name('user.parent.')
            ->middleware('web')
            ->namespace($this->namespace . '\Front\User\Parent')
            ->group(base_path('routes/parent.php'));
    }

}
