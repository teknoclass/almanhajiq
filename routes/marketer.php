<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\User\Marketer\HomeController;
use App\Http\Controllers\Front\User\Marketer\CustomersController;
use App\Http\Controllers\Front\User\Marketer\MarketersTemplatesController;

Route::group(['middleware' => ['auth:web', 'shareGeneralSettings','checkIsMarketer']], function () {
    Route::group(['middleware' => 'checkActiveUser'], function () {

        //home
        Route::group(['prefix' => 'home', 'as' => 'home.'], function () {
            Route::get('/', [HomeController::class , 'index'])
                ->name('index');
        });

        //customers
        Route::group(['prefix' => 'customers', 'as' => 'customers.'], function () {
            Route::get('/', [CustomersController::class , 'index'])
                ->name('index');
        });

        // templates
        Route::group(['prefix' => 'templates', 'as' => 'templates.'], function () {
            Route::get('/', [MarketersTemplatesController::class , 'index'])
                ->name('index');
            Route::get('/download/{id}', [MarketersTemplatesController::class , 'download'])
            ->name('download');
        });

    });

});
