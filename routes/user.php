<?php

declare(strict_types=1);

use App\Http\Controllers\Front\User\AssignmentsController;
use App\Http\Controllers\Front\User\ChatController;
use App\Http\Controllers\Front\User\CoursesController;
use App\Http\Controllers\Front\User\CourseSessionsController;
use App\Http\Controllers\Front\User\FinancialRecordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\User\HomeController;
use App\Http\Controllers\Front\User\NotificationsController;
use App\Http\Controllers\Front\User\ProfileSettingsController;
use App\Http\Controllers\Front\User\PaymentController;
use App\Http\Controllers\Front\User\PrivateLessonsController;
use App\Http\Controllers\Front\User\PackagesController;
use App\Http\Controllers\Front\User\QuizController;
use App\Http\Controllers\Front\User\RatingsController;
use App\Http\Controllers\Front\User\Lecturer\CoursesController as LecturerCoursesController;
use App\Http\Controllers\Front\User\CourseSessionSubscriptionsController;
use App\Http\Controllers\Front\User\CourseSessionInstallmentsController;
use App\Http\Controllers\Front\User\CourseFullSubscriptionsController;

Route::group(['middleware' => [ 'shareGeneralSettings']], function () {
    Route::group(['middleware' => 'checkActiveUser'], function () {

        // home
        Route::group(['prefix' => 'home', 'as' => 'home.'], function () {
            Route::get('/', [HomeController::class, 'index'])->name('index');
        });

        // notifications
        Route::group(['prefix' => 'notifications', 'as' => 'notifications.'], function () {
            Route::get('/', [NotificationsController::class, 'index'])->name('index');
            Route::post('/read-all', [NotificationsController::class, 'readAll'])->name('readAll');
            Route::get('/read/{id}', [NotificationsController::class, 'read'])->name('read');
        });

        // cart
        Route::group(['prefix' => 'cart', 'as' => 'cart.'], function () {
            Route::get('/', [HomeController::class, 'cart'])->name('index');
        });

        // settings profile
        Route::group(['prefix' => 'profile-settings', 'as' => 'profileSettings.'], function () {
            Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
                Route::get('/', [ProfileSettingsController::class, 'indexProfile'])->name('index');
                Route::post('/', [ProfileSettingsController::class, 'updateProfile'])->name('update');
            });

            Route::group(['prefix' => 'change-password', 'as' => 'changePassword.'], function () {
                //  Route::get('/', [ProfileSettingsController::class , 'indexChangePassword'])->name('index');
                Route::post('/', [ProfileSettingsController::class, 'chnagePassword'])->name('update');
            });
        });

        // settings
        Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
            Route::get('/', [HomeController::class, 'settings'])->name('index');
            //  Route::post('/', [HomeController::class , 'update'])->name('update');
        });

        // my points
        Route::group(['prefix' => 'my-points', 'as' => 'my_points.'], function () {
            Route::get('/', [HomeController::class, 'my_points'])->name('index');
            //  Route::post('/', [HomeController::class , 'update'])->name('update');
        });

        // purchases
        Route::group(['prefix' => 'my-purchases', 'as' => 'my_purchases.'], function () {
            Route::get('/', [HomeController::class, 'my_purchases'])->name('index');
            //  Route::post('/', [HomeController::class , 'update'])->name('update');
        });

        // certificate
        Route::group(['prefix' => 'certificate', 'as' => 'certificate.'], function () {
            Route::get('/', [HomeController::class, 'certificate'])->name('index');
            //  Route::post('/', [HomeController::class , 'update'])->name('update');
        });

        // payment
        Route::group(['prefix' => 'payment', 'as' => 'payment.'], function () {
            Route::get('/', [HomeController::class, 'payment'])->name('index');
            //  Route::post('/', [HomeController::class , 'update'])->name('update');
        });

        // chats
        Route::group(['prefix' => 'chat', 'as' => 'chat.'], function () {
            Route::get('/all',          [ChatController::class, 'index'])->name('index');
            Route::get('/{user_id}',    [ChatController::class, 'create'])->name('open.chat');
            Route::post('/sendMessage', [ChatController::class, 'sendMessage'])->name('send.message');
        });


        // Ratings
        Route::group(['prefix' => 'ratings', 'as' => 'ratings.'], function () {

            Route::post('add', [RatingsController::class, 'add'])->name('add');
        });

        // Private lessons
        Route::group(['prefix' => 'private-lessons', 'as' => 'private_lessons.'], function () {
            Route::get('/request', [PrivateLessonsController::class, 'request'])->name('request');
            Route::post('/cancel', [PrivateLessonsController::class, 'storeCancelRequest'])->name('cancel');
            Route::post('/postpone', [PrivateLessonsController::class, 'storePostponeRequest'])->name('postpone');
            Route::post('/respond', [PrivateLessonsController::class, 'respondToRequest'])->name('respond');
            Route::get('/{type?}', [PrivateLessonsController::class, 'index'])->name('index');


            Route::post('/book/{id?}', [PrivateLessonsController::class, 'book'])->name('book');

            Route::group(['prefix' => 'meeting', 'as' => 'meeting.'], function () {
                // joinMeeting
                Route::get('/join/{id}', [PrivateLessonsController::class, 'joinMeeting'])->name('join');
            });
        });

        // packages
        Route::group(['prefix' => 'packages', 'as' => 'packages.'], function () {

            Route::get('/', [PackagesController::class, 'index'])->name('index');

            Route::post('/book/{id}', [PackagesController::class, 'book'])->name('book');
        });

        // courses
        Route::group(['prefix' => 'courses', 'as' => 'courses.'], function () {
            Route::group(['prefix' => 'live', 'as' => 'live.'], function () {
                Route::group(['prefix' => 'requests', 'as' => 'requests.'], function () {
                    Route::get('/request', [CourseSessionsController::class, 'request'])->name('request');
                    Route::post('/cancel', [CourseSessionsController::class, 'storeCancelRequest'])->name('cancel');
                    Route::post('/postpone', [CourseSessionsController::class, 'storePostponeRequest'])->name('postpone');
                    Route::post('/respond', [CourseSessionsController::class, 'respondToRequest'])->name('respond');
                });
                Route::post('/join',     [CoursesController::class, 'joinLiveSession'])->name('joinLiveSession');
            });
            Route::get('/all',                  [CoursesController::class, 'myCourses'])->name('myCourses');
            Route::get('/completed',            [CoursesController::class, 'completedCourses'])->name('completed');
            Route::get('/certificate-issuance/{id}', [CoursesController::class, 'certificateIssuance'])
                ->name('certificateIssuance');
            Route::get('/my-activity/{id}',     [CoursesController::class, 'myActivity'])->name('myAcitivity');

            Route::group(['prefix' => 'curriculum', 'middleware' => ['CheckCourseSubscription'], 'as' => 'curriculum.'], function () {

                Route::get('/item/{course_id}/{curclm_item_id?}/{section_item_id?}',         [CoursesController::class, 'curriculumItem'])->name('item');
                Route::get('/open-item/{course_id}/{type}/{id}',         [CoursesController::class, 'openLearnPageByItemId'])->name('openByItem');
                Route::get('/navigation/{type}/{course_id}/{curclm_item_id?}/{section_item_id?}',   [CoursesController::class, 'Navigation'])->name('navigation');

                Route::group(['prefix' => 'lesson', 'as' => 'lesson.'], function () {
                    Route::get('/set-completed/{course_id}/{id}/{type}',           [CoursesController::class, 'setLessonAsCompleted'])->name('set.completed');
                });

                Route::group(['prefix' => 'comments', 'as' => 'comments.'], function () {
                    Route::post('save/{course_id}',     [CoursesController::class, 'saveComment'])->name('save');
                });


                Route::group(['prefix' => 'quiz', 'as' => 'quiz.'], function () {
                    Route::get('/{course_id}/{id}/start',           [QuizController::class, 'start'])->name('start');
                    Route::post('/{course_id}/{id}/store-result',   [QuizController::class, 'storeResult'])->name('store.result');
                });

                Route::group(['prefix' => 'assignment', 'as' => 'assignment.'], function () {
                    Route::get('/{course_id}/{id}/start',               [AssignmentsController::class, 'start'])->name('start');
                    Route::post('/{course_id}/{id}/store-result',       [AssignmentsController::class, 'storeResult'])->name('store.result');
                    Route::post('/upload-file/{course_id}', [AssignmentsController::class, 'uploadFile'])->name('file.upload');
                    Route::delete('/delete-file/{course_id}', [AssignmentsController::class, 'deleteFile'])->name('file.delete');
                });
            });

            Route::group(['prefix' => 'register', 'as' => 'register.'], function () {
                Route::post('/',           [CoursesController::class, 'register'])->name('submit');
            });
        });



        // financial-record
        Route::group(['prefix' => 'financial-record/{user_type}', 'as' => 'financialRecord.'], function () {
            Route::get('/', [FinancialRecordController::class, 'index'])
                ->name('index');

            Route::group(['prefix' => 'withdrawal-requests', 'as' => 'withdrawalRequests.'], function () {
                Route::post('/cancel-request', [FinancialRecordController::class, 'cancelRequest'])
                    ->name('cancel');
                Route::post('/store-request', [FinancialRecordController::class, 'storeRequest'])
                    ->name('store');
            });
        });

        //subscriptions offers
        Route::post('/subscribe-to-course-sessions',[CourseSessionSubscriptionsController::class,'subscribe']);
        Route::get('/subscribe-to-course-sessions-confirm',[CourseSessionSubscriptionsController::class,'confirmSubscribe']);
        //installments
        Route::post('/pay-to-course-session-installment',[CourseSessionInstallmentsController::class,'pay']);
        Route::get('/pay-to-course-session-installment-confirm',[CourseSessionInstallmentsController::class,'confirmPayment']);
        //full subscription
        Route::post('/full-subscribe-course',[CourseFullSubscriptionsController::class,'fullSubscribe']);
        Route::get('/full-subscribe-course-confirm',[CourseFullSubscriptionsController::class,'fullConfirmSubscribe']);
        
    });


});


//  payment
Route::group(['prefix' => 'payment', 'as' => 'payment.', 'middleware' => ['shareGeneralSettings']], function () {

    Route::get('checkout/{transaction_id}', [PaymentController::class, 'checkout'])->name('checkout')->middleware('checkActiveUser');
    Route::post('init', [PaymentController::class, 'init'])->name('init')->middleware('checkActiveUser');
    Route::get('check-status/{payment_id}', [PaymentController::class, 'checkStatus'])->name('checkStatus');

    //  Route::group(['prefix' => '/{action_type}/{action_id}', 'middleware' => ['shareGeneralSettings']], function () {
    //      Route::get('checkout', [PaymentController::class , 'checkout'])->name('checkout');
    //      Route::post('check-status', [PaymentController::class , 'checkStatus'])
    //        ->name('checkStatus');
    //  });
});

Route::post('/chat/update-token', [ChatController::class, 'saveToken'])->name('chat.update.token');
Route::get('/meeting-finished/{meeting_id?}/{user_id?}', [HomeController::class, 'meetingFinished'])->name('meeting.finished');
Route::get('/set-meeting-finished/{id}', [LecturerCoursesController::class, 'setMeetingFinished'])->name('set.meeting.finished');
