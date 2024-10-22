<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\SettingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'language', 'prefix' => 'teacher'], function () {
    Route::post('/register', [AuthController::class, 'registerTeacher']);
});

Route::group(['middleware' => 'language', 'prefix' => 'student'], function () {
    Route::post('/register', [AuthController::class, 'registerStudent']);
});

Route::post('/login', [AuthController::class, 'login'])->middleware('language');
Route::post('/forgotPassword', [AuthController::class, 'forgotPassword'])->middleware('language');
Route::post('/reset_password', [AuthController::class, 'resetPassword'])->name('reset-password');
Route::get('/settings', [SettingsController::class, 'all'])->name('settings')->middleware('language');
Route::get('/home', [HomeController::class, 'home'])->name('home')->middleware('language');
Route::post('/filter', [CourseController::class, 'courseFilter'])->name('filter')->middleware('language');
