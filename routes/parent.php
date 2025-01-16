<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\User\Parent\HomeController;
use App\Http\Controllers\Front\User\Parent\ParentSonsController;
use App\Http\Controllers\Front\User\Parent\SonRequestsController;

Route::group(['middleware' => ['auth:web', 'shareGeneralSettings','checkIsParent']], function () {
    Route::group(['middleware' => 'checkActiveUser'], function () {

        //home
        Route::group(['prefix' => 'home', 'as' => 'home.'], function () {
            Route::get('/', [HomeController::class , 'index'])
                ->name('index');
        });

        //sons
        Route::group(['prefix' => 'sons', 'as' => 'sons.'], function () {
            Route::post('/store', [ParentSonsController::class , 'addSon'])->name('store');
            Route::post('/make-active', [ParentSonsController::class , 'makeActive'])->name('makeActive');
            Route::get('/courses/{son_id}', [ParentSonsController::class , 'courses'])->name('courses');
            Route::get('/courses/details/{course_id}/{son_id}', [ParentSonsController::class , 'courseDetails'])->name('course.details');
        });

        Route::group(['prefix' => 'sons-requests', 'as' => 'sons-requests.'], function () {
            Route::get('/',[SonRequestsController::class,'index'])->name('index');
            Route::post('/update/{id}',[SonRequestsController::class,'update'])->name('update');
        });

    });
});
