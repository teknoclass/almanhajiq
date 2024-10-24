<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\PagesController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\TeacherController;
//use App\Http\Controllers\Api\StudentController;
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

// Group routes for student profile and update with student prefix
Route::group(['middleware' => ['language', 'auth:sanctum'], 'prefix' => 'student'], function () {
//    Route::get('/profile', [StudentController::class, 'showProfile']);
    Route::post('/update', [AuthController::class, 'updateProfile']);
});

// Group routes for pages with pages prefix
Route::group(['middleware' => 'language', 'prefix' => 'page'], function () {
    Route::get('/{slug}', [PagesController::class, 'findPage'])->name('page');
    Route::get('/about', [PagesController::class, 'about'])->name('about');
});

// Auth routes with sanctum and language middleware
Route::middleware(['language', 'auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/delete', [AuthController::class, 'deleteUser']);
});

// Teacher registration routes with language middleware
Route::group(['middleware' => 'language', 'prefix' => 'teacher'], function () {
    Route::post('/register', [AuthController::class, 'registerTeacher']);
});

// Student registration routes with language middleware
Route::group(['middleware' => 'language', 'prefix' => 'student'], function () {
    Route::post('/register', [AuthController::class, 'registerStudent']);
});

Route::group(['middleware' => 'language', 'prefix' => 'blog'], function () {
    Route::get('/', [BlogController::class, 'home'])->name('blog_home');
    Route::get('/posts', [BlogController::class, 'posts'])->name('posts');
    Route::get('/{id}', [BlogController::class, 'single'])->name('single_post');
    Route::get('/category/{id}', [BlogController::class, 'getByCategory'])->name('posts_by_category');

});

// Auth routes without sanctum authentication
Route::post('/login', [AuthController::class, 'login'])->middleware('language');
Route::post('/forgot_password', [AuthController::class, 'forgotPassword'])->middleware('language');
Route::post('/reset_password', [AuthController::class, 'resetPassword'])->name('reset-password')->middleware('language');
// Additional routes
Route::get('/settings', [SettingsController::class, 'all'])->name('settings')->middleware('language');
Route::get('/FAQ', [SettingsController::class, 'faqs'])->name('faqs')->middleware('language');

Route::get('/home', [HomeController::class, 'home'])->name('home')->middleware('language');

Route::group(['middleware' => 'language', 'prefix' => 'courses'], function () {
    Route::post('/filter', [CourseController::class, 'courseFilter'])->name('filter');
    Route::get('/{id}', [CourseController::class, 'getCourse'])->name('singleCourse');
});

Route::get('/teacher/{id}', [TeacherController::class, 'findTeacherById'])->name('teacher')->middleware('language');
