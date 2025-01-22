<?php

use App\Models\Payment;
use App\Models\PrivateLessons;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\PagesController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\ParentController;
use App\Http\Controllers\Api\CoursesController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\LecturerController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\FavouriteController;
use App\Http\Controllers\Api\AssignmentController;
use App\Http\Controllers\Api\LiveSessionController;
use App\Http\Controllers\Api\TeacherHomeController;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Controllers\Api\MarketerHomeController;
use App\Http\Controllers\Api\CourseSessionsController;
use App\Http\Controllers\Api\LecturerCourseController;
use App\Http\Controllers\Api\PrivateLessonsController;
use App\Http\Controllers\Api\TeacherBalanceController;
use Twilio\Rest\Api\V2010\Account\Call\PaymentContext;
use App\Http\Controllers\TeacherStudentProfileController;
use App\Http\Controllers\Api\TeacherPrivateLessonsController;

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

// Group for routes related to 'parent', applying the 'language' middleware
Route::group(['middleware' => 'language', 'prefix' => 'parent'], function () {

    // Route for parent registration, no authentication required
    Route::post('/register', [ParentController::class, 'register']);

    // Group for routes that require both 'language' and 'auth:sanctum' middleware
    Route::group(['middleware' => ['auth:sanctum' , 'language']], function () {
        // Route to get the parent profile, requires authentication
        Route::get('/', [ParentController::class, 'showProfile']);

        Route::get('/home', [HomeController::class, 'home_parent']);
        Route::get('/my-sons', [ParentController::class, 'my_sons']);
        Route::get('/my-sons/{id}', [ParentController::class, 'show_sons']);
        Route::POST('/my-sons/store', [ParentController::class, 'store_sons']);
        Route::POST('/my-sons/store/verify', [ParentController::class, 'store_sons_verify']);

        // Route to update the parent's profile, requires authentication
        Route::post('/update', [ParentController::class, 'updateProfile']);
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

Route::group(['middleware' => ['language','check.sanctum.token'], 'prefix' => 'blog'], function () {
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
Route::post('/contactUs',[SettingsController::class,'contactUs']);

Route::get('/home', [HomeController::class, 'home'])->name('home')->middleware('language');
Route::get('/homeSearch',[HomeController::class,'homeSearch'])->middleware('language');

Route::get('/getAllOpinion',[HomeController::class,'getOpinion']);

Route::get('/calendar',[HomeController::class,'calendar']);

Route::group([ 'prefix' => 'courses'], function () {
    Route::post('/filter', [CourseController::class, 'courseFilter'])->name('filter')->middleware('check.sanctum.token');
    Route::get('/{id}', [CourseController::class, 'getCourse'])->name('singleCourse')->middleware('check.sanctum.token');
    Route::get('/purchase-options/{id}', [CourseSessionsController::class, 'purchaseOptions'])->name('session_groups');


});

Route::group(['middleware' => 'language', 'prefix' => 'live-sessions'], function () {
});

Route::get('/teacher/{id}', [TeacherController::class, 'findTeacherById'])->name('teacher')->middleware('language');
Route::get('/teacherTimes/{id}',[TeacherController::class,'getTimeByDate']);

//payment

Route::group(['prefix' => 'payment' , 'middleware' => 'auth:api'], function () {

    Route::post('/fullCourseDetails',[PaymentController::class,'fullSubscribeDetails']);
    Route::post('/fullCourse',[PaymentController::class,'fullSubscribe']);
    Route::get('/full-subscribe-course-confirm',[PaymentController::class,'fullConfirmSubscribe'])->withoutMiddleware('auth:api');

    Route::post('buyFree',[PaymentController::class,'buyFree']);

    Route::post('/subscribe-to-course-sessions-details',[PaymentController::class,'subscribeDetails']); //
    Route::post('/subscribe-to-course-sessions',[PaymentController::class,'subscribe']);
    Route::get('/subscribe-to-course-sessions-confirm',[PaymentController::class,'confirmSubscribe']);
    Route::get('/subscribe-to-course-group-confirm',[PaymentController::class,'confirmSubscribeGroup'])->withoutMiddleware('auth:api');

    Route::post('/pay-to-course-session-installment-details',[PaymentController::class,'installmentDetails']);
    Route::post('/pay-to-course-session-installment',[PaymentController::class,'installment']);
    Route::get('/pay-to-course-session-installment-confirm',[PaymentController::class,'confirmPayment'])->withoutMiddleware('auth:api');

    Route::post('pay-to-private-lesson-details',[PaymentController::class,'privateLessonDetails']);
    Route::post('pay-to-private-lesson',[PaymentController::class,'privateLesson']);
    Route::get('/pay-to-private-lesson-confirm',[PaymentController::class,'privateLessonConfirm'])->withoutMiddleware('auth:api');

    Route::post('/reserve-course-session-installment-free',[PaymentController::class,'subscribeDetailsFree']);

    Route::post('/buyFreeInstallment',[PaymentController::class,'freeInstallment']);

});

//coupon

Route::group(['middleware' => 'language', 'prefix' => 'coupon'], function () {

    Route::post('/check' , [CouponController::class,'check']);

});

Route::prefix('/comment')->group(function(){

    Route::post('/add/{course_id}',[CourseController::class,'saveComment'])->middleware('auth:api');

});



//course curriculum
Route::get('/itemApi/{id}',[CoursesController::class , 'getItemApi']);
Route::get('/itemComments',[CoursesController::class,'getComments']);
Route::get('/getReply/{comment_id}',[CoursesController::class,'getReplys']);
Route::post('/addRate',[CoursesController::class,'addRate'])->middleware('auth:api');
Route::get('/getRate',[CoursesController::class,'getRate']);


//lesson
Route::post('courseStudy/endLesson',[CoursesController::class,'endLesson'])->middleware('auth:api');

//quiz
Route::prefix('quiz')->middleware(['language', 'auth:sanctum'])->group(function(){
    Route::get('/{id}/start' , [QuizController::class,'start']);
    Route::get('/{id}/show-results' , [QuizController::class,'showResults']);
    Route::post('/store-result',[QuizController::class , 'storeResult']);
    Route::post('/submitAnswer',[QuizController::class,'submitAnswer']);
});
//assignment
Route::prefix('assignment')->middleware('auth:api')->group(function(){
    Route::get('/{id}/start' , [AssignmentController::class,'start']);
    Route::post('/submitAnswer',[AssignmentController::class,'submitAnswer']);
    Route::post('/storeResultApi',[AssignmentController::class,'endAssignmentApi']);
    Route::get('/{id}/show-results',[AssignmentController::class,'showResults']);
});


Route::prefix('/favourite')->middleware('auth:sanctum')->group(function(){
    Route::post('/set',[FavouriteController::class,'set'])->middleware('auth:api');
    Route::get('/get',[FavouriteController::class,'get'])->middleware('auth:api');
});

//private lessons
Route::prefix('privateLessons')->middleware('auth:sanctum')->group(function(){

    Route::get('/get/{type}',[PrivateLessonsController::class,'get']);
    Route::post('/postpone',[PrivateLessonsController::class,'postpone']);
    Route::get('/getRequests',[PrivateLessonsController::class,'getRequests']);
    Route::post('respondeToRequest',[PrivateLessonsController::class,'responde']);
    Route::get('/showRequest/{id}',[PrivateLessonsController::class,'show']);

});



//course session


Route::group(['middleware' => 'language', 'prefix' => 'courseSession'], function () {

    Route::post('/join',[LiveSessionController::class,'joinLiveSession']);


});

Route::group(['middleware' => 'language', 'prefix' => 'lecturer'], function () {

    Route::get('/',[LecturerController::class,'index']);


});

Route::group(['middleware' => ['language','auth:sanctum'], 'prefix' => 'user'], function () {

    Route::get('/myCourses',[UserProfileController::class,'myCourses']);


});


//chat

Route::prefix('chat')->middleware('auth:sanctum')->group(function(){

    Route::get('/index',[ChatController::class,'index']);
    Route::get('/create/{receiver_id}',[ChatController::class,'create']);
    Route::post('/sendMessage',[ChatController::class,'sendMessage']);
    Route::post('/saveToken',[ChatController::class,'saveToken']);
    Route::post('/readMessage/{id}',[ChatController::class,'readMessage']);

});


//my notification
Route::get('/myNotification',[UserProfileController::class,'myNotification'])->middleware('auth:sanctum');



//lecturer apis

Route::group(['middleware' => ['language','auth:sanctum'], 'prefix' => 'teacherApi'], function () {


    //courses
    Route::get('/courseStudent',[LecturerCourseController::class,'courseStudent']);
    Route::get('/myCourses',[LecturerCourseController::class,'myCourses']);
    Route::get('/getMyCategories',[LecturerCourseController::class,'getMyCategories']);

    ////assignment
    Route::get('/courseUserAssignments',[LecturerCourseController::class,'courseUserAssignments']);
    Route::get('/courseAssignment/{course_id}',[LecturerCourseController::class,'courseAssignment']);
    Route::get('/getStudentAnswerAssignment/{result_id}',[LecturerCourseController::class,'getStudentAnswer']);
    Route::post('submitMarkAssignment',[LecturerCourseController::class,'submitMark']);
    Route::post('submitResultAssignment',[LecturerCourseController::class,'submitResult']);
    Route::get('/getStudentHomeworks/{course_id}/{student_id}',[LecturerCourseController::class,'getStudentHomeworks']);
    Route::get('/previewAssignment/{assignment_id}',[LecturerCourseController::class,'showAssignment']);


    ////quiz
    Route::get('/courseUserQuizzes',[LecturerCourseController::class,'courseUserQuizzes']);
    Route::get('/courseQuiz/{course_id}',[LecturerCourseController::class,'courseQuiz']);
    Route::get('/previewUserQuiz/{id}' , [LecturerCourseController::class,'previewUserQuiz']);
    Route::get('/previewQuiz/{quiz_id}',[LecturerCourseController::class,'showQuiz']);

    ////session
    Route::get('createSession/{session_id}',     [LecturerCourseController::class , 'createLiveSession'])->name('createLiveSession');
    Route::post('/postpone', [LecturerCourseController::class, 'storePostponeRequest'])->name('postpone');



    //home
    Route::get('getHomeChart' , [TeacherHomeController::class,'getChart']);
    Route::get('getHomeData',[TeacherHomeController::class,'getData']);
    Route::get('incomingSessions',[TeacherHomeController::class,'incomingSessions']);
    Route::get('/getStudents',[TeacherHomeController::class,'getStudents']);
    Route::get('/courseFilter',[TeacherHomeController::class,'courseFilter']);
    Route::get('/myProfile',[TeacherHomeController::class,'profile']);
    Route::get('/calendar',[TeacherHomeController::class,'calendar']);





    //balances
    Route::prefix('balance')->group(function(){

        Route::get('/index',[TeacherBalanceController::class,'index']);
        Route::post('/sendRequest',[TeacherBalanceController::class,'send']);
        Route::post('/cancelRequest',[TeacherBalanceController::class,'cancel']);

    });

    //student profile
    Route::prefix('studentProfile')->group(function(){

        Route::get('/index/{id}',[TeacherStudentProfileController::class,'index']);
        Route::get('/courses/{id}',[TeacherStudentProfileController::class,'courses']);
        Route::get('/comments/{id}',[TeacherStudentProfileController::class,'comments']);

    });

    Route::prefix('privateLessons')->group(function(){

        Route::get('get/{type}',[TeacherPrivateLessonsController::class,'get']);
        Route::post('/createOrJoin/{id}',[TeacherPrivateLessonsController::class,'createOrJoin']);
        Route::get('/getRequests',[TeacherPrivateLessonsController::class,'getRequests']);

    });





});


Route::prefix('marketerApi')->middleware('auth:sanctum')->group(function(){

    Route::post('/joinAsMarketerRequest', [MarketerHomeController::class, 'joinAsMarketRequest'])->name('joinAsMarketRequest')->withoutMiddleware('auth:sanctum');;
    Route::get('/home',[MarketerHomeController::class,'home']);
    Route::get('/customers',[MarketerHomeController::class,'customers']);
    Route::get('/getRefferalLink/{id}',[MarketerHomeController::class,'getReferralLink']);

});



