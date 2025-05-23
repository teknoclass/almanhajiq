<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Front\Auth\RegisterController;
use App\Http\Controllers\Front\Auth\ForgotPasswordController;
use App\Http\Controllers\Front\Auth\LoginController;
use App\Http\Controllers\Front\Auth\VerificationController;
use App\Http\Controllers\Front\ContactUsController;
use App\Http\Controllers\Front\FaqsController;
use App\Http\Controllers\Front\HomeController as FrontHomeController;
use App\Http\Controllers\Front\PagesController;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ImageHandlerController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Front\CoursesController as FrontCoursesController;
use App\Http\Controllers\Front\PackagesController as FrontPackagesController;
use App\Http\Controllers\Front\User\Marketer\HomeController as MarketerHomeController;
use App\Http\Controllers\Front\LecturerProfileController;
use App\Http\Controllers\Front\LecturersController;
use App\Http\Controllers\Front\PrivateLessonsController;
use App\Http\Controllers\Front\User\Lecturer\CoursesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\User\PaymentController;
use App\Http\Controllers\Front\User\PaymentCallBackController;
use App\Http\Controllers\LevelsControllers;
use App\Http\Controllers\Front\User\CourseSessionSubscriptionsController;
use App\Http\Controllers\Front\User\CourseSessionInstallmentsController;
use App\Http\Controllers\Front\User\CourseFullSubscriptionsController;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Http\Controllers\Front\User\PrivateLessonSubscriptionsController;
use App\Http\Controllers\Front\User\PaymentOperationsController;
use App\Models\Setting;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(
[
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'shareGeneralSettings' ]
], function(){

    Route::get('/', [FrontHomeController::class, 'index'])->name('index');
    //payment
    Route::get('/payment-failure',[PaymentCallBackController::class,'paymentFailure']);
    Route::get('/payment-cancelled',[PaymentCallBackController::class,'paymentCancelled']);
    Route::get('/payment-webhook',[PaymentCallBackController::class,'paymentWebhook']);
    //faqs
    Route::prefix('/faqs')->group(function () {
        Route::get('/', [FaqsController::class, 'index'])->name('faqs.index');
    });

    // lecturers
    Route::group(['prefix' => '/lecturers', 'as' => 'lecturers.'], function () {
        Route::get('/', [LecturersController::class, 'index'])->name('index');
    });

    //levels
    Route::get('get-sub-levels/{id}', [LevelsControllers::class, 'getSubLevels']);
    Route::get('get-materials/{id}', [LevelsControllers::class, 'getMaterials']);

    // private lessons
    /*Route::group(['prefix' => '/private-lessons', 'as' => 'private_lessons.'], function () {
        Route::get('/', [PrivateLessonsController::class, 'index'])->name('index');
    });*/

    // courses
    Route::group(['prefix' => '/courses', 'as' => 'courses.'], function () {
        Route::get('/',                     [FrontCoursesController::class, 'index'])->name('index');
        Route::get('/single/{id}/{title?}',  [FrontCoursesController::class, 'single'])->name('single')->where(['id' => '[0-9]+']);

        // These routes just to show html and will be DELETED
        Route::get('/test-courses',         [FrontHomeController::class, 'testCourses'])->name('test.courses');
        Route::get('/live',     [FrontHomeController::class, 'liveCourse'])->name('live');
        Route::get('/text',     [FrontHomeController::class, 'textCourse'])->name('text');
        // ----
        Route::get('/get-subjects/{gradeLevel}', [FrontHomeController::class, 'getSubjects']);
        Route::get('/get-topics/{subject}', [FrontHomeController::class, 'getTopics']);
    });

    // packages
    Route::group(['prefix' => '/packages', 'as' => 'packages.'], function () {
        Route::get('/',                     [FrontPackagesController::class, 'index'])->name('index');
        Route::get('/single/{id}/{title}',  [FrontPackagesController::class, 'single'])->name('single')->where(['id' => '[0-9]+']);
    });

    // forum
    Route::group(['prefix' => '/turkish-curriculum', 'as' => 'turkish_curriculum.'], function () {
        Route::get('/',                 [FrontHomeController::class, 'turkishCurriculumIndex'])->name('index');
        Route::get('/single',           [FrontHomeController::class, 'turkishCurriculumSingle'])->name('single');
    });

    // forum
    Route::group(['prefix' => '/forum', 'as' => 'forum.', 'middleware' => ['CheckForumStatus']], function () {
        Route::get('/',                 [FrontHomeController::class, 'forumIndex'])->name('index');
        Route::get('/categorized',      [FrontHomeController::class, 'catForum'])->name('categorized');
        Route::get('/single',           [FrontHomeController::class, 'ForumSingle'])->name('single');
    });

    // blog
    Route::group(['prefix' => '/blog', 'as' => 'blog.', 'middleware' => ['CheckBlogStatus']], function () {
        Route::get('/',             [BlogController::class, 'index'])->name('index');
        Route::get('/news',         [BlogController::class, 'news'])->name('news');
        Route::get('/posts',        [BlogController::class, 'posts'])->name('posts');
        Route::get('/post/{id}',    [BlogController::class, 'singlePost'])->name('single.post')->where(['id' => '[0-9]+']);
        Route::get('/category/{id}',[BlogController::class, 'categoryPosts'])->name('category.posts')->where(['id' => '[0-9]+']);
    });


    //pages
    Route::prefix('/pages')->group(function () {
        Route::get('/about', [PagesController::class, 'about'])->name('pages.about');
        Route::get('/{sulg}', [PagesController::class, 'single'])->name('pages.single');
    });

    // contact us
    Route::prefix('/contact-us')->group(function () {
        Route::get('/', [ContactUsController::class, 'index'])->name('contact.index');
        Route::post('/', [ContactUsController::class, 'store'])->name('contact.store');
    });

    //lecturer-profile
    Route::prefix('/lecturer-profile')->group(function () {
        // Route::get('/{id}/get-more-reviews', [LecturerProfileController::class, 'getMoreReviews'])->name('lecturerProfile.getMoreReviews');

        // Route::get('/{id}/get-more-courses', [LecturerProfileController::class, 'getMoreCourses'])->name('lecturerProfile.getMoreCourses');

        Route::get('courses/{id}', [LecturerProfileController::class, 'courses'])->name('lecturerProfile.courses');
        Route::get('/{id}/{name}', [LecturerProfileController::class, 'index'])->name('lecturerProfile.index');
    });

    // auth
    // Auth::routes();

    // Google Login
    Route::get('login/google', [RegisterController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('login/google/callback', [RegisterController::class, 'handleGoogleCallback'])->name('login.google.callback');


    Route::group(['as' => 'user.auth.', 'namespace' => 'Auth'], function () {
        //register
        Route::prefix('/register')->group(function () {
            Route::get('/',     [RegisterController::class, 'registerStudent'])->name('register');
            Route::post('/',    [RegisterController::class, 'registration'])->name('register.store');
        });

        //login
        Route::prefix('/login')->group(function () {
            Route::get('/',     [LoginController::class, 'index'])->name('login');
            Route::post('/',    [LoginController::class, 'login'])->name('login');
        });
        Route::get('/logout',   [LoginController::class, 'logout'])->name('logout');

        //forget password
        Route::get('forget-password',   [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
        Route::post('forget-password',  [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
        Route::get('reset-password/{token}/{email}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
        Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');


        Route::get('welcome/lecturer', [VerificationController::class, 'WelcomeLecturer'])->name('welcome.lecturer');
        Route::group(['middleware' => ['auth:web']], function () {
            //verify
            Route::prefix('/verify')->group(function () {
                Route::get('/user', [VerificationController::class, 'verifyUser'])->name('verify.user');
                Route::get('/lecturer', [VerificationController::class, 'verifyLecturer'])->name('verify.lecturer');
                Route::get('/marketer', [VerificationController::class, 'verifyMarketer'])->name('verify.marketer');

                //verification
                Route::post('/verification', [VerificationController::class, 'verification'])->name('verify.verification');
                Route::get('/resend', [VerificationController::class, 'resend'])->name('verify.resend');
            });
        });
    });

    //join as teacher request
    Route::prefix('/join-as-teacher-request')->group(function () {
        Route::post('/', [VerificationController::class , 'joinAsTeacherRequest'])    ->name('joinAsTeacherRequest');
    });

    //join as marketer request
    Route::prefix('/join-as-market-request')->group(function () {
        Route::post('/', [MarketerHomeController::class, 'joinAsMarketRequest'])->name('joinAsMarketRequest');
    });

    Route::get('show-quiz-result/{result_token}', [FrontHomeController::class , 'showQuizResult'])->name('show.quiz.result');
    Route::get('show-assignment-result/{result_token}', [FrontHomeController::class , 'showAssignmentResult'])->name('show.assignment.result');

});


Route::prefix('/image')->group(function () {
    Route::post('/upload', [ImageController::class, 'uploadImage'])->name('upload.image');
    Route::get('/{id}', [ImageHandlerController::class, 'getDefaultImage'])->name('image');
    Route::get('/{size}/{id}', [ImageHandlerController::class, 'getPublicImage']);
});


Route::get('/files/{link}', [FileController::class, 'getFileLink'])->name('file.getLink');
Route::get('/couponsDownload/{filename}', [FileController::class, 'couponsDownload'])->name('coupons.download');
Route::get('/files/video/{link}', [FileController::class, 'getVideoLink'])->name('file.video.getLink');
Route::post('/files/upload-file', [FileController::class, 'uploadFile'])->name('file.upload');

Route::group(['prefix' => '/get-course-file', 'middleware' => ['CheckCanAccessCourseFiles'], 'as' => 'get.course.file.'], function () {
    Route::get('{course_id}/{lesson_type}/{file}', [FileController::class, 'getCourseLessonItemLink'])->name('type');
});
Route::group(['prefix' => '/get-course-file-stream', 'middleware' => ['CheckCanAccessCourseFiles'], 'as' => 'get.course.file.stream'], function () {
    Route::get('{course_id}/{lesson_type}/{file}', [FileController::class, 'getCourseLessonItemLinkStream']);
});


////////////////////
//payment webhook
Route::post('/full-subscribe-course-webhook',[CourseFullSubscriptionsController::class,'handleWebhook']);
Route::post('/subscribe-to-course-sessions-webhook',[CourseSessionSubscriptionsController::class,'handleWebhook']);
Route::post('/pay-to-course-session-installment-webhook',[CourseSessionInstallmentsController::class,'handleWebhook']);
Route::post('/private-lesson-subscribe-webhook',[PrivateLessonSubscriptionsController::class,'handleWebhook']);
//handle payment webhook
Route::post('/user/payment-webhook',[PaymentOperationsController::class,'handleWebhook']);

////////////////////////

Route::get('checkout', [PaymentController::class, 'checkout']);
Route::post('after-checkout', [PaymentController::class, 'callback'])->name('payment_callback');
Route::get('/translations', function () {
    $locale = app()->getLocale();
    $translations = [];

    foreach (glob(resource_path("lang/{$locale}/*.php")) as $file) {
        $filename = basename($file, '.php');
        $translations[$filename] = require $file;
    }

    return $translations;
});

///////////subjects////////



Route::get('copy-subjects',function(){
    // Category::where('parent', 'joining_course')
    // ->whereDate('created_at', today())
    // ->delete();
    $levels = Category::where('parent', 'grade_levels')->where('id','!=',154)->pluck('id')->toArray();
    $subjects = Category::where('grade_sub_level_id',154)->get();
    foreach($levels as $level)
    {
        foreach($subjects as $subject)
        {
            $request['parent'] = "joining_course";
            $request["grade_sub_level_id"] = $level;

            $value = Category::select('id', 'key', 'parent', 'value')->where('parent', "joining_course")->withTrashed()->max('value');

            $request['value'] = $value + 1;

            $request['name_ar'] = $subject->translations()
            ->where('locale', 'ar')
            ->first()
            ->name ?? '';

            $request['name_en'] = $subject->translations()
            ->where('locale', 'en')
            ->first()
            ->name ?? '';

            $category = Category::create( $request);

            CategoryTranslation::create([
                'name' =>  $request['name_ar'],
                "locale" => 'ar',
                "category_id" => $category->id
            ]);
            CategoryTranslation::create([
                'name' =>  $request['name_en'],
                "locale" => 'en',
                "category_id" => $category->id
            ]);
        }
    }
    return "done";
});
///////////////////////////////////////////////////////

Route::get('/migrate',function(){
    $migrations = [
        "2025_03_13_132525_add_group_name_to_coupons_table.php"
    ];

    foreach($migrations as $migration)
    {
        \Artisan::call('migrate --path=database/migrations/'.$migration. ' --force');
    }

    return "migrations done";

});

//seeder

Route::get('seed',function(){
    $seeders = [
        'GradeLevelSeeder',
    ];
    foreach($seeders as $seeder)
    {
        \Artisan::call('db:seed --class='.$seeder);
    }

    return "seed done";
});

Route::get('add',function(){
    Setting::create([
        'key' => 'coupon_email',
        'value' => 'test@gmail.com'
    ]);
    return 1;
});

