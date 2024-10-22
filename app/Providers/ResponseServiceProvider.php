<?php

namespace App\Providers;

use App\Http\Response\ErrorResponse;
use App\Http\Response\SuccessResponse;

use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(ResponseFactory $factory)
    {
        $factory->macro('success', function(SuccessResponse $response) use ($factory) {

            return response()->json($response->getAttributes());
        });

        $factory->macro('error', function(ErrorResponse $response) use ($factory) {
            return response()->json($response->getAttributes());
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
