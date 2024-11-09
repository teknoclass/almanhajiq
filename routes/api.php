<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\CourseSessionsController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\LecturerController;
use App\Http\Controllers\Api\LiveSessionController;
use App\Http\Controllers\Api\PagesController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\UserProfileController;
use App\Models\Payment;
use Illuminate\Support\Facades\Route;
use Twilio\Rest\Api\V2010\Account\Call\PaymentContext;

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

// Group for routes related to 'student', applying the 'language' middleware
Route::group(['middleware' => 'language', 'prefix' => 'student'], function () {

    // Route for student registration, no authentication required
    Route::post('/register', [StudentController::class, 'registerStudent']);

    // Group for routes that require both 'language' and 'auth:sanctum' middleware
    Route::group(['middleware' => 'auth:sanctum'], function () {
        // Route to get the student profile, requires authentication
        Route::get('/', [StudentController::class, 'showProfile']);

        // Route to update the student's profile, requires authentication
        Route::post('/update', [StudentController::class, 'updateProfile']);
    });
});

// Group routes for pages with pages prefix
Route::group(['middleware' => 'language', 'prefix' => 'page'], function () {
    Route::get('/{slug}', [PagesController::class, 'findPage'])->name('page');
    Route::get('/about', [PagesController::class, 'about'])->name('about');
});

// Auth routes with sanctum and language middleware
Route::middleware(['language', 'auth:sanctum'])->group(function () {
    Route::post('/verify',[StudentController::class,'verify']);
    Route::post('/resendCode',[StudentController::class,'resend']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user/delete', [AuthController::class, 'deleteUser']);
});

// Teacher registration routes with language middleware
Route::group(['middleware' => 'language', 'prefix' => 'teacher'], function () {
    Route::post('/register', [AuthController::class, 'registerTeacher']);
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

Route::group([ 'prefix' => 'courses'], function () {
    Route::post('/filter', [CourseController::class, 'courseFilter'])->name('filter');
    Route::get('/{id}', [CourseController::class, 'getCourse'])->name('singleCourse')->middleware(['check.sanctum.token']);
    Route::get('/purchase-options/{id}', [CourseSessionsController::class, 'purchaseOptions'])->name('session_groups')->middleware(['check.sanctum.token']);

});

Route::group(['middleware' => 'language', 'prefix' => 'live-sessions'], function () {
});

Route::get('/teacher/{id}', [TeacherController::class, 'findTeacherById'])->name('teacher')->middleware('language');

//payment

Route::group(['prefix' => 'payment'], function () {

    Route::post('/fullCourse',[PaymentController::class,'fullSubscribe']);
    Route::get('/full-subscribe-course-confirm',[PaymentController::class,'fullConfirmSubscribe']);

    Route::post('buyFree',[PaymentController::class,'buyFree']);

    Route::post('/subscribe-to-course-sessions',[PaymentController::class,'subscribe']);
    Route::get('/subscribe-to-course-sessions-confirm',[PaymentController::class,'confirmSubscribe']);
    Route::get('/subscribe-to-course-group-confirm',[PaymentController::class,'confirmSubscribeGroup']);

    Route::post('/pay-to-course-session-installment',[PaymentController::class,'paymentGateway']);
    Route::get('/pay-to-course-session-installment-confirm',[PaymentController::class,'confirmPayment']);

});


//course session


Route::group(['middleware' => 'language', 'prefix' => 'courseSession'], function () {

    Route::post('/join',[LiveSessionController::class,'joinLiveSession']);


});

Route::group(['middleware' => 'language', 'prefix' => 'lecturer'], function () {

    Route::get('/',[LecturerController::class,'index']);


});

Route::group(['middleware' => 'language', 'prefix' => 'user'], function () {

    Route::get('/myCourses',[UserProfileController::class,'myCourses']);


});



