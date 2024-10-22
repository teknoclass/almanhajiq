<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Carbon::macro('inApplicationTimezone', function() {
            return $this->tz(config('app.timezone_display'));
        });
        Carbon::macro('inUserTimezone', function() {
            return $this->tz(auth()->user()?->timezone ?? config('app.timezone_display'));
        });
        Carbon::macro('convertToTimezone', function($timezone) {
            return $this->copy()->tz($timezone);
        });
    }
}
