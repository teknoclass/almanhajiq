<?php

use App\Http\Controllers\Front\User\CourseSessionsController;
use App\Http\Controllers\Panel\LiveSessionsController;
use App\Http\Controllers\Panel\CoursesSessionsController;
use App\Http\Controllers\Panel\PrivateLessonRequestsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panel\Auth\LoginController;
use App\Http\Controllers\Panel\PagesController;
use App\Http\Controllers\Panel\HomeController;
use App\Http\Controllers\Panel\AdminsController;
use App\Http\Controllers\Panel\RolesController;
use App\Http\Controllers\Panel\SettingController;
use App\Http\Controllers\Panel\InboxController;
use App\Http\Controllers\Panel\FaqsController;
use App\Http\Controllers\Panel\CategoryController;
use App\Http\Controllers\Panel\PostsController;
use App\Http\Controllers\Panel\UsersController;
use App\Http\Controllers\Panel\OurPartnersController;
use App\Http\Controllers\Panel\OurTeamsController;
use App\Http\Controllers\Panel\StatisticsController;
use App\Http\Controllers\Panel\OurServicesController;
use App\Http\Controllers\Panel\OurMessagesController;
use App\Http\Controllers\Panel\StudentsOpinionsController;
use App\Http\Controllers\Panel\SlidersController;
use App\Http\Controllers\Panel\WorkStepsController;
use App\Http\Controllers\Panel\HomePageSectionsController;
use App\Http\Controllers\Panel\ProfileController;
use App\Http\Controllers\Panel\LoginActivityController;
use App\Http\Controllers\Panel\LanguagesController;
use App\Http\Controllers\Panel\TranslationController;
use App\Http\Controllers\Panel\PostsCommentsController;
use App\Http\Controllers\Panel\CoursesController;
use App\Http\Controllers\Panel\JoinAsTeacherRequestsController;
use App\Http\Controllers\Panel\PrivateLessonsController;
use App\Http\Controllers\Panel\PackagesController;
use App\Http\Controllers\Panel\CourseStudentsController;
use App\Http\Controllers\Panel\CourseCommentsController;
use App\Http\Controllers\Panel\CourseRatingsController;
use App\Http\Controllers\Panel\TransactiosController;
use App\Http\Controllers\Panel\WithdrawalRequestsController;
use App\Http\Controllers\Panel\NotificationsController;
use App\Http\Controllers\Panel\PrivateLessonRatingsController;
use App\Http\Controllers\Panel\AddCourseRequestsController;
use App\Http\Controllers\Panel\CertificateTemplatesController;
use App\Http\Controllers\Panel\CouponsController;
use App\Http\Controllers\Panel\CurriculumCreationController;
use App\Http\Controllers\Panel\MarketersJoiningRequestsController;
use App\Http\Controllers\Panel\MarketersTemplatesController;
use App\Http\Controllers\Panel\CourseSessionsController as AdminCourseSessionsController;
use App\Http\Controllers\Panel\InstallmentsSettingsController;
use App\Http\Controllers\Panel\RefundsController;

Route::group(
    [

    ], function(){

    //login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.showLoginForm');
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login');
    Route::post('/admin-logout', [LoginController::class, 'loggedOut'])->name('admin.logout');

    Route::get('/', [HomeController::class,'index'])->name('home');


    //profile
    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::post('/', [ProfileController::class, 'update'])->name('update');
    });

    //admin
    Route::group(['prefix' => 'admins', 'as' => 'admins.','middleware' => 'permission:show_admins'], function () {
        Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
            Route::get('/', [AdminsController::class, 'create'])->name('index');
            Route::post('/', [AdminsController::class, 'store'])->name('store');
        });
        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [AdminsController::class, 'edit'])->name('index');
            Route::post('/{id}', [AdminsController::class, 'update'])->name('update');
        });
        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [AdminsController::class, 'index'])->name('index');
            Route::get('/data', [AdminsController::class, 'getDataTable'])->name('data');
        });
        Route::delete('/{id}', [AdminsController::class, 'delete'])->name('delete');
    });


    //roles
    Route::group(['prefix' => 'roles', 'as' => 'roles.', 'middleware' => 'permission:show_roles'], function () {
        Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
            Route::get('/', [RolesController::class, 'create'])->name('index');
            Route::post('/', [RolesController::class, 'store'])->name('store');
        });
        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [RolesController::class, 'edit'])->name('index');
            Route::post('/{id}', [RolesController::class, 'update'])->name('update');
        });
        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [RolesController::class, 'index'])->name('index');
            Route::get('/data', [RolesController::class, 'getDataTable'])->name('data');
        });
        Route::delete('/{id}', [RolesController::class, 'delete'])->name('delete');
    });

    //users
    Route::group(['prefix' => 'users', 'as' => 'users.', 'middleware' => 'permission:show_users'], function () {

        Route::get('/search-students', [UsersController::class, 'searchStudents'])->name('searchStudents');
        Route::get('/search-lecturers', [UsersController::class, 'searchLecturers'])->name('searchLecturers');
        Route::get('/search-marketers', [UsersController::class, 'searchMarketers'])->name('searchMarketers');

        Route::group(['middleware' => 'permission:show_users'  ], function () {
            Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
                Route::get('/', [UsersController::class, 'create'])->name('index');
                Route::post('/', [UsersController::class, 'store'])->name('store');
            });

            Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
                Route::get('/{id}', [UsersController::class, 'edit'])->name('index');
                Route::post('/{id}', [UsersController::class, 'update'])->name('update');
            });

            Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
                Route::get('/', [UsersController::class, 'index'])->name('index');
                Route::get('/data', [UsersController::class, 'getDataTable'])->name('data');
            });
            ///lecturers
            Route::group(['prefix' => 'all_lecturers', 'as' => 'allLecturers.'], function () {
                Route::get('/', [UsersController::class, 'lecturers'])->name('index');
                Route::get('/data', [UsersController::class, 'getDataTableLecturers'])->name('data');
            });
            ///marketers
            Route::group(['prefix' => 'all_marketers', 'as' => 'allMarketers.'], function () {
                Route::get('/', [UsersController::class, 'marketers'])->name('index');
                Route::get('/data', [UsersController::class, 'getDataTableMarketers'])->name('data');
            });

            ///students
            Route::group(['prefix' => 'all_students', 'as' => 'allStudents.'], function () {
                Route::get('/', [UsersController::class, 'students'])->name('index');
                Route::get('/data', [UsersController::class, 'getDataTableStudents'])->name('data');
            });

            Route::delete('/{id}', [UsersController::class, 'delete'])->name('delete');
            Route::post('/operation', [UsersController::class, 'operation'])->name('operation');
            Route::post('/import-students-excel', [UsersController::class, 'importStudentsExcel'])->name('importStudentsExcel');
            Route::get('/export-excel', [UsersController::class, 'exportExcel'])->name('exportExcel');
        });
    });

    //login activity
    Route::group(['prefix' => 'login-activity', 'as' => 'loginActivity.', 'middleware' => 'permission:show_login_activity'], function () {
        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [LoginActivityController::class, 'index'])->name('index');
            Route::get('/data', [LoginActivityController::class, 'getDataTable'])->name('data');
        });
        Route::delete('/{id}', [LoginActivityController::class, 'delete'])->name('delete');
    });



    //settings
    Route::group(['prefix' => 'settings', 'as' => 'settings.', 'middleware' => 'permission:show_settings'], function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::put('/', [SettingController::class, 'update'])->name('update');
    });

    //languages
    Route::group(['prefix' => 'languages', 'as' => 'languages.', 'middleware' => 'permission:show_languages'], function () {
        Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
            Route::get('/', [LanguagesController::class, 'create'])->name('index');
            Route::post('/', [LanguagesController::class, 'store'])->name('store');
        });

        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [LanguagesController::class, 'edit'])->name('index');
            Route::post('/{id}', [LanguagesController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [LanguagesController::class, 'index'])->name('index');
            Route::get('/data', [LanguagesController::class, 'getDataTable'])->name('data');
        });

        Route::delete('/{id}', [LanguagesController::class, 'delete'])->name('delete');
    });


    //Translation
    Route::group(['prefix' => 'translation/{lang}', 'as' => 'translation.', 'middleware' => 'permission:show_languages'], function () {
        Route::group(['prefix' => 'all', 'as' => 'index.'], function () {
            Route::get('/', [TranslationController::class, 'index'])->name('index');
            Route::post('/', [TranslationController::class, 'update'])->name('update');
        });
    });


    //pages
    Route::group(['prefix' => 'pages', 'as' => 'pages.', 'middleware' => 'permission:show_pages'], function () {
        Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
            Route::get('/', [PagesController::class, 'create'])->name('index');
            Route::post('/', [PagesController::class, 'store'])->name('store');
        });

        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [PagesController::class, 'edit'])->name('index');
            Route::post('/{id}', [PagesController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [PagesController::class, 'index'])->name('index');
            Route::get('/data', [PagesController::class, 'getDataTable'])->name('data');
        });

        Route::delete('/{id}', [PagesController::class, 'delete'])->name('delete');
    });



    //inbox
    Route::group(['prefix' => 'inbox', 'as' => 'inbox.', 'middleware' => 'permission:show_inbox'], function () {
        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [InboxController::class, 'index'])->name('index');
            Route::get('/data', [InboxController::class, 'getDataTable'])->name('data');
        });

        Route::group(['prefix' => 'view/{id}', 'as' => 'view.'], function () {
            Route::get('/', [InboxController::class, 'view'])->name('index');
            Route::post('/', [InboxController::class, 'replay'])->name('replay');
        });

        Route::delete('/{id}', [InboxController::class, 'delete'])->name('delete');
    });

    //faqs
    Route::group(['prefix' => 'faqs', 'as' => 'faqs.', 'middleware' => 'permission:show_faqs'], function () {
        Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
            Route::get('/', [FaqsController::class, 'create'])->name('index');
            Route::post('/', [FaqsController::class, 'store'])->name('store');
        });

        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [FaqsController::class, 'edit'])->name('index');
            Route::post('/{id}', [FaqsController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [FaqsController::class, 'index'])->name('index');
            Route::get('/data', [FaqsController::class, 'getDataTable'])->name('data');
        });

        Route::delete('/{id}', [FaqsController::class, 'delete'])->name('delete');
    });


    //category
    Route::group(['prefix' => 'categories/{parent}', 'as' => 'categories.',
        'middleware' => 'permission:show_posts_comments|show_age_categories|show_course_levels|show_course_languages
    |show_course_categories|show_joining_certificates|show_countries|show_joining_sections|joining_sections|show_banks'], function () {
        Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
            Route::get('/', [CategoryController::class, 'create'])->name('index');
            Route::post('/', [CategoryController::class, 'store'])->name('store');
        });

        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [CategoryController::class, 'edit'])->name('index');
            Route::post('/{id}', [CategoryController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/data', [CategoryController::class, 'getDataTable'])->name('data');
        });

        Route::delete('/{id}', [CategoryController::class, 'delete'])->name('delete');
        Route::post('/operation', [CategoryController::class, 'operation'])->name('operation');
    });

    //posts
    Route::group(['prefix' => 'posts', 'as' => 'posts.', 'middleware' => 'permission:show_posts'], function () {
        Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
            Route::get('/', [PostsController::class, 'create'])->name('index');
            Route::post('/', [PostsController::class, 'store'])->name('store');
        });

        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [PostsController::class, 'edit'])->name('index');
            Route::post('/{id}', [PostsController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [PostsController::class, 'index'])->name('index');
            Route::get('/data', [PostsController::class, 'getDataTable'])->name('data');
        });

        Route::delete('/{id}', [PostsController::class, 'delete'])->name('delete');
        Route::post('/operation', [PostsController::class, 'operation'])->name('operation');
    });

    //posts_comments
    Route::group(['prefix' => 'posts_comments', 'as' => 'postsComments.',
        'middleware' => 'permission:show_posts_comments'], function () {
        Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
            Route::get('/', [PostsCommentsController::class, 'create'])->name('index');
            Route::post('/', [PostsCommentsController::class, 'store'])->name('store');
        });

        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [PostsCommentsController::class, 'edit'])->name('index');
            Route::post('/{id}', [PostsCommentsController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [PostsCommentsController::class, 'index'])->name('index');
            Route::get('/data', [PostsCommentsController::class, 'getDataTable'])->name('data');
        });

        Route::delete('/{id}', [PostsCommentsController::class, 'delete'])->name('delete');
        Route::post('/operation', [PostsCommentsController::class, 'operation'])->name('operation');
    });



    // ourPartner
    Route::group(['prefix' => 'our-partners', 'as' => 'ourPartners.',
        'middleware' => 'permission:show_our_partners'], function () {

        Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
            Route::get('/', [OurPartnersController::class, 'create'])->name('index');
            Route::post('/', [OurPartnersController::class, 'store'])->name('store');
        });

        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [OurPartnersController::class, 'edit'])->name('index');
            Route::post('/{id}', [OurPartnersController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [OurPartnersController::class, 'index'])->name('index');
            Route::get('/data', [OurPartnersController::class, 'getDataTable'])->name('data');
        });

        Route::post('/operation', [OurPartnersController::class, 'operation'])->name('operation');

        Route::delete('/{id}', [OurPartnersController::class, 'delete'])->name('delete');
    });

    // ourTeam
    Route::group(['prefix' => 'our-teams', 'as' => 'ourTeams.',
        'middleware' => 'permission:show_our_teams'], function () {

        Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
            Route::get('/', [OurTeamsController::class, 'create'])->name('index');
            Route::post('/', [OurTeamsController::class, 'store'])->name('store');
        });

        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [OurTeamsController::class, 'edit'])->name('index');
            Route::post('/{id}', [OurTeamsController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [OurTeamsController::class, 'index'])->name('index');
            Route::get('/data', [OurTeamsController::class, 'getDataTable'])->name('data');
        });

        Route::post('/operation', [OurTeamsController::class, 'operation'])->name('operation');

        Route::delete('/{id}', [OurTeamsController::class, 'delete'])->name('delete');
    });

    // ourservices
    Route::group(['prefix' => 'our-services', 'as' => 'ourServices.',
        'middleware' => 'permission:show_our_services'], function () {

        Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
            Route::get('/', [OurServicesController::class, 'create'])->name('index');
            Route::post('/', [OurServicesController::class, 'store'])->name('store');
        });

        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [OurServicesController::class, 'edit'])->name('index');
            Route::post('/{id}', [OurServicesController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [OurServicesController::class, 'index'])->name('index');
            Route::get('/data', [OurServicesController::class, 'getDataTable'])->name('data');
        });

        Route::post('/operation', [OurServicesController::class, 'operation'])->name('operation');

        Route::delete('/{id}', [OurServicesController::class, 'delete'])->name('delete');
    });

    // ourmessages
    Route::group(['prefix' => 'our-messages', 'as' => 'ourMessages.',
        'middleware' => 'permission:show_our_messages'], function () {

        Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
            Route::get('/', [OurMessagesController::class, 'create'])->name('index');
            Route::post('/', [OurMessagesController::class, 'store'])->name('store');
        });

        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [OurMessagesController::class, 'edit'])->name('index');
            Route::post('/{id}', [OurMessagesController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [OurMessagesController::class, 'index'])->name('index');
            Route::get('/data', [OurMessagesController::class, 'getDataTable'])->name('data');
        });

        Route::post('/operation', [OurMessagesController::class, 'operation'])->name('operation');

        Route::delete('/{id}', [OurMessagesController::class, 'delete'])->name('delete');
    });

    // StudentsOpinions
    Route::group(['prefix' => 'student_opinions', 'as' => 'studentsOpinions.',
        'middleware' => 'permission:show_students_opinions'], function () {

        Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
            Route::get('/', [StudentsOpinionsController::class, 'create'])->name('index');
            Route::post('/', [StudentsOpinionsController::class, 'store'])->name('store');
        });

        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [StudentsOpinionsController::class, 'edit'])->name('index');
            Route::post('/{id}', [StudentsOpinionsController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [StudentsOpinionsController::class, 'index'])->name('index');
            Route::get('/data', [StudentsOpinionsController::class, 'getDataTable'])->name('data');
        });

        Route::post('/operation', [StudentsOpinionsController::class, 'operation'])->name('operation');

        Route::delete('/{id}', [StudentsOpinionsController::class, 'delete'])->name('delete');
    });



    //statistics
    Route::group(['prefix' => 'statistics', 'as' => 'statistics.', 'middleware' => 'permission:show_statistics'], function () {
        Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
            Route::get('/', [StatisticsController::class, 'create'])->name('index');
            Route::post('/', [StatisticsController::class, 'store'])->name('store');
        });

        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [StatisticsController::class, 'edit'])->name('index');
            Route::post('/{id}', [StatisticsController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [StatisticsController::class, 'index'])->name('index');
            Route::get('/data', [StatisticsController::class, 'getDataTable'])->name('data');
        });

        Route::delete('/{id}', [StatisticsController::class, 'delete'])->name('delete');
    });

    //sliders
    Route::group(['prefix' => 'sliders', 'as' => 'sliders.', 'middleware' => 'permission:show_sliders'], function () {
        Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
            Route::get('/{type?}', [SlidersController::class, 'create'])->name('index');
            Route::post('/', [SlidersController::class, 'store'])->name('store');
        });

        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [SlidersController::class, 'edit'])->name('index');
            Route::post('/{id}', [SlidersController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [SlidersController::class, 'index'])->name('index');
            Route::get('/data', [SlidersController::class, 'getDataTable'])->name('data');
        });

        Route::delete('/{id}', [SlidersController::class, 'delete'])->name('delete');
    });


    //work_steps
    Route::group(['prefix' => 'work_steps', 'as' => 'workSteps.', 'middleware' => 'permission:show_work_steps'], function () {
        Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
            Route::get('/', [WorkStepsController::class, 'create'])->name('index');
            Route::post('/', [WorkStepsController::class, 'store'])->name('store');
        });

        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [WorkStepsController::class, 'edit'])->name('index');
            Route::post('/{id}', [WorkStepsController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [WorkStepsController::class, 'index'])->name('index');
            Route::get('/data', [WorkStepsController::class, 'getDataTable'])->name('data');
        });

        Route::delete('/{id}', [WorkStepsController::class, 'delete'])->name('delete');
    });


    // home page sections
    Route::group(['prefix' => 'home-page-sections', 'as' => 'homePageSections.',
        'middleware' => 'permission:show_home_page_sections'], function () {

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [HomePageSectionsController::class, 'index'])->name('index');
            Route::get('/data', [HomePageSectionsController::class, 'getDataTable'])->name('data');
        });



        Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
            Route::get('/', [HomePageSectionsController::class, 'indexOrders'])->name('index');
            Route::post('/', [HomePageSectionsController::class, 'storeOrders'])->name('store');
        });


        Route::post('/operation', [HomePageSectionsController::class, 'operation'])->name('operation');

    });

    //courses
    Route::group(['prefix' => 'courses', 'as' => 'courses.'], function () {


        Route::get('/search/{type}', [CoursesController::class, 'search'])->name('search');

        Route::get('/get-lecturers', [CoursesController::class, 'getLecturers'])->name('getLecturers');

        Route::get('/get-levels', [CoursesController::class, 'getLevels'])->name('getLevels');


        Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
            Route::get('/', [CoursesController::class, 'create'])->name('index');
            Route::post('/', [CoursesController::class, 'store'])->name('store');
            Route::get('/{id}', [CoursesController::class, 'publish'])->name('publish');

        });

        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            //base information
            Route::group(['prefix' => 'base-information', 'as' => 'baseInformation.'], function () {
                Route::get('/{id}', [CoursesController::class, 'edit'])->name('index');
                Route::post('/{id}', [CoursesController::class, 'update'])->name('update');

            });

            //price details
            Route::group(['prefix' => 'price-details', 'as' => 'priceDetails.'], function () {
                Route::get('/{id}', [CoursesController::class, 'editPriceDetails'])->name('index');
                Route::post('/{id}', [CoursesController::class, 'updatePriceDetails'])->name('update');
            });

            //content details
            Route::group(['prefix' => 'content-details', 'as' => 'contentDetails.'], function () {
                Route::get('/{id}/{type}', [CoursesController::class, 'editContentDetails'])->name('index');
                Route::post('/{id}/{type}', [CoursesController::class, 'updateContentDetails'])->name('update');
            });

            //requirements
            Route::group(['prefix' => 'requirements', 'as' => 'requirements.'], function () {
                Route::get('/{id}', [CoursesController::class, 'editCourseRequirements'])->name('index');
                Route::post('/{id}', [CoursesController::class, 'updatetCourseeRequirements'])->name('update');
            });

            //sections
            Route::group(['prefix' => 'sections', 'as' => 'sections.'], function () {
                Route::get('/{id}', [CoursesController::class, 'editSections'])->name('index');
                Route::post('/{id}', [CoursesController::class, 'updateSections'])->name('update');
            });

            //course-faqs
            Route::group(['prefix' => 'course-faqs', 'as' => 'courseFaqs.'], function () {
                Route::get('/{id}', [CoursesController::class, 'editCourseFaqs'])->name('index');
                Route::post('/{id}', [CoursesController::class, 'updateCourseFaqs'])->name('update');
            });
            Route::group(['prefix' => 'course_schedule', 'as' => 'courseSchedule.'], function () {
                Route::get('/{id}', [CoursesController::class, 'editCourseSchedule'])->name('index');
                Route::post('/{id}', [CoursesController::class, 'updateCourseSchedule'])->name('update');
                Route::post('/{courseId}/group', [LiveSessionsController::class, 'storeGroup'])->name('group.store');
                Route::put('/{courseId}/group/{groupId}', [LiveSessionsController::class, 'updateGroup'])->name('group.update');
                Route::delete('/{courseId}/group/{groupId}', [LiveSessionsController::class, 'deleteGroup'])->name('group.delete');
                Route::get('/{courseId}/group/sessions', [LiveSessionsController::class, 'getUsedSessions'])->name('group.sessions.used');
                Route::post('/{courseId}/group/sessions', [LiveSessionsController::class, 'getGroupWithSessions'])->name('getGroupWithSessions');
            });

            //installments-settings
            Route::group(['prefix' => 'installments-settings', 'as' => 'installments-settings.'], function () {
                Route::get('/{course_id}', [InstallmentsSettingsController::class, 'index'])->name('index');
                Route::get('/lessons/{id}', [InstallmentsSettingsController::class, 'getLessons']);
                Route::post('/store', [InstallmentsSettingsController::class, 'store']);
            });

            //welcome-text-for-registration
            Route::group(['prefix' => 'welcome-text-for-registration', 'as' => 'welcomeTextForRegistration.'], function () {
                Route::get('/{id}', [CoursesController::class, 'editWelcomeTextForRegistration'])->name('index');
                Route::post('/{id}', [CoursesController::class, 'updateWelcomeTextForRegistration'])->name('update');
            });
            //for_whom_this_course
            Route::group(['prefix' => 'for_whom_this_course', 'as' => 'ForWhomThisCourse.'], function () {
                Route::get('/{id}', [CoursesController::class, 'editForWhomThisCourse'])->name('index');
                Route::post('/{id}', [CoursesController::class, 'updateForWhomThisCourse'])->name('update');
            });
            //suggested dates
            Route::group(['prefix' => 'suggested-dates', 'as' => 'suggestedDates.'], function () {
                Route::get('/{id}', [CoursesController::class, 'editSuggestedDates'])->name('index');
                Route::post('/{id}', [CoursesController::class, 'updateSuggestedDates'])->name('update');
            });
            //Curriculum

            Route::group(['prefix' => 'curriculum', 'as' => 'curriculum.'], function () {

                // show modal
                Route::get('/get-lessons-modal', [CurriculumCreationController::class, 'getLessonModal'])->name('get_lesson_modal');
                Route::get('/get-exam-modal', [CurriculumCreationController::class, 'getExamModal'])->name('get_exam_modal');
                Route::get('/get-task-modal', [CurriculumCreationController::class, 'getTaskModal'])->name('get_task_modal');
                Route::get('/get-live-lesson-modal', [CurriculumCreationController::class, 'getLiveLessonModal'])->name('get_live_lesson_modal');
                Route::get('/get-correct-modal', [CurriculumCreationController::class, 'getCorrectModal'])->name('get_correct_modal');
                Route::get('/get-exam-solution-modal', [CurriculumCreationController::class, 'getQuizSolutionModal'])->name('get-exam-solution-modal');
                // end show modals

                Route::group(['prefix' => 'section', 'as' => 'section.'], function () {
                    Route::post('/set', [CurriculumCreationController::class, 'addSection'])->name('set_section');
                    Route::post('/delete', [CurriculumCreationController::class, 'deleteSection'])->name('delete_section');
                });

                Route::group(['prefix' => 'lesson', 'as' => 'lesson.'], function () {
                    Route::post('/set', [CurriculumCreationController::class, 'addLesson'])->name('set_lesson');
                    Route::post('/update', [CurriculumCreationController::class, 'updateLesson'])->name('update_lesson');
                    Route::post('/delete', [CurriculumCreationController::class, 'deleteLesson'])->name('delete_lesson');
                    Route::post('outer/delete', [CurriculumCreationController::class, 'deleteOuterLesson'])->name('delete_outer_lesson');
                });

                Route::group(['prefix' => 'live-lesson', 'as' => 'live_lesson.'], function () {
                    Route::get('/', [CourseSessionsController::class, 'index'])->name('index');
                    Route::post('/set', [CurriculumCreationController::class, 'addLiveLesson'])->name('set_live_lesson');
                    Route::post('/update', [CurriculumCreationController::class, 'updateLiveLesson'])->name('update_live_lesson');
                    Route::post('/delete', [CurriculumCreationController::class, 'deleteLiveLesson'])->name('delete_live_lesson');
                    Route::post('outer/delete', [CurriculumCreationController::class, 'deleteOuterLiveLesson'])->name('delete_outer_live_lesson');
                });

                Route::group(['prefix' => 'quiz', 'as' => 'quiz.'], function () {
                    Route::post('/set', [CurriculumCreationController::class, 'addQuiz'])->name('set_quiz');
                    Route::post('/update', [CurriculumCreationController::class, 'updateQuiz'])->name('update_quiz');
                    Route::post('/delete', [CurriculumCreationController::class, 'deleteQuiz'])->name('delete_quiz');
                    Route::post('outer/delete', [CurriculumCreationController::class, 'deleteOuterQuiz'])->name('delete_outer_quiz');
                });

                Route::group(['prefix' => 'assignment', 'as' => 'assignment.'], function () {
                    Route::post('/set', [CurriculumCreationController::class, 'addTask'])->name('set_assignment');
                    Route::post('/update',  [CurriculumCreationController::class, 'updateTask'])->name('update_assignment');
                    Route::post('/delete', [CurriculumCreationController::class, 'deleteTask'])->name('delete_assignment');
                    Route::post('outer/delete', [CurriculumCreationController::class, 'deleteOuterTask'])->name('delete_outer_assignment');
                });

                Route::delete('/delete-course-file/{img_id}/lesson_attachments', [CurriculumCreationController::class, 'deleteCourseAttachment'])
                     ->name('delete-course-file');

                Route::get('/{id}', [CoursesController::class, 'editCurriculum'])->name('index');
                // Route::post('/{id}', [CoursesController::class, 'updateSuggestedDates'])->name('update');
            });

        });

        Route::group(['prefix' => 'preview-curriculum', 'middleware' => [ 'CheckCanPreviewCourseCurriculum', 'shareGeneralSettings'], 'as' => 'preview_curriculum.'], function () {
            Route::get('/item/{course_id}/{curclm_item_id?}/{section_item_id?}',         [CoursesController::class , 'curriculumItem'])->name('item');
            Route::get('/open-item/{course_id}/{type}/{id}',                [CoursesController::class , 'openLearnPageByItemId'])->name('openByItem');
            Route::get('/navigation/{type}/{course_id}/{curclm_item_id?}/{section_item_id?}',   [CoursesController::class , 'Navigation'])->name('navigation');
        });

        Route::group(['prefix' => 'preview', 'middleware' => ['CheckCanPreviewCourseCurriculum', 'shareGeneralSettings'], 'as' => 'preview.'], function () {
            Route::get('/{course_id}',         [CoursesController::class , 'previewCourse'])->name('index');
        });

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [CoursesController::class, 'index'])->name('index');

            Route::get('/data', [CoursesController::class, 'getDataTable'])->name('data');
        });
        Route::delete('delete-video/{id}', [CoursesController::class, 'deleteVideo'])->name('deleteVideo');
        Route::delete('/{id}', [CoursesController::class, 'delete'])->name('delete');
        Route::group(['prefix' => 'live', 'as' => 'live.'], function () {
            Route::get('live/create/{session_id}',     [CoursesController::class , 'createLiveSession'])->name('createLiveSession');
        });
    });

    // Add Course Requests
    Route::group(['prefix' => 'add-course-requests', 'as' => 'addCourseRequests.',
        'middleware' => 'permission:show_add_course_requests'], function () {
        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [AddCourseRequestsController::class, 'edit'])->name('index');
            Route::post('/{id}', [AddCourseRequestsController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [AddCourseRequestsController::class, 'index'])->name('index');
            Route::get('/data', [AddCourseRequestsController::class, 'getDataTable'])->name('data');
        });

        Route::delete('/{id}', [AddCourseRequestsController::class, 'delete'])->name('delete');
    });



    //course_comments
    Route::group(['prefix' => 'course_comments', 'as' => 'courseComments.',
        /* 'middleware' => 'permission:show_course_comments' */], function () {

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [CourseCommentsController::class, 'index'])->name('index');
            Route::get('/data', [CourseCommentsController::class, 'getDataTable'])->name('data');
        });

        Route::group(['prefix' => 'course', 'as' => 'course.'], function () {
            Route::get('/{course_id}', [CourseCommentsController::class, 'course'])->name('index');
            Route::get('/data/{course_id}', [CourseCommentsController::class, 'getDataTableCourse'])->name('data');
        });

        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [CourseCommentsController::class, 'edit'])->name('index');
            Route::post('/{id}', [CourseCommentsController::class, 'update'])->name('update');
        });
        Route::delete('/{id}', [CourseCommentsController::class, 'delete'])->name('delete');
        Route::post('/operation', [CourseCommentsController::class, 'operation'])->name('operation');
    });

    //course_ratings
    Route::group(['prefix' => 'course_ratings', 'as' => 'courseRatings.',
        'middleware' => 'permission:show_course_ratings'], function () {

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [CourseRatingsController::class, 'index'])->name('index');
            Route::get('/data', [CourseRatingsController::class, 'getDataTable'])->name('data');
        });

        Route::group(['prefix' => 'course', 'as' => 'course.'], function () {
            Route::get('/{course_id}', [CourseRatingsController::class, 'course'])->name('index');
            Route::get('/data/{course_id}', [CourseRatingsController::class, 'getDataTableCourse'])->name('data');
        });

        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [CourseRatingsController::class, 'edit'])->name('index');
            Route::post('/{id}', [CourseRatingsController::class, 'update'])->name('update');
        });
        Route::delete('/{id}', [CourseRatingsController::class, 'delete'])->name('delete');
        Route::post('/operation', [CourseRatingsController::class, 'operation'])->name('operation');
    });

    // Join as Teacher Requests
    Route::group(['prefix' => 'join-as-teacher-requests', 'as' => 'joinAsTeacherRequests.', 'middleware' => 'permission:show_join_as_teacher_requests'], function () {
        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [JoinAsTeacherRequestsController::class, 'edit'])->name('index');
            Route::post('/{id}', [JoinAsTeacherRequestsController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [JoinAsTeacherRequestsController::class, 'index'])->name('index');
            Route::get('/data', [JoinAsTeacherRequestsController::class, 'getDataTable'])->name('data');
        });

        Route::delete('/{id}', [JoinAsTeacherRequestsController::class, 'delete'])->name('delete');
    });


    //private_lessons
    Route::group(['prefix' => 'private-lessons', 'as' => 'privateLessons.', 'middleware' => 'permission:show_private_lessons'], function () {
        Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
            Route::get('/', [PrivateLessonsController::class, 'create'])->name('index');
            Route::post('/', [PrivateLessonsController::class, 'store'])->name('store');
        });

        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [PrivateLessonsController::class, 'edit'])->name('index');
            Route::post('/{id}', [PrivateLessonsController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [PrivateLessonsController::class, 'index'])->name('index');
            Route::get('/data', [PrivateLessonsController::class, 'getDataTable'])->name('data');
        });

        Route::delete('/{id}', [PrivateLessonsController::class, 'delete'])->name('delete');
    });

    //private_lessons_ratings
    Route::group(['prefix' => 'private_lesson_ratings', 'as' => 'PrivateLessonRatings.',
        'middleware' => 'permission:show_private_lesson_ratings'], function () {

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [PrivateLessonRatingsController::class, 'index'])->name('index');
            Route::get('/data', [PrivateLessonRatingsController::class, 'getDataTable'])->name('data');
        });

        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [PrivateLessonRatingsController::class, 'edit'])->name('index');
            Route::post('/{id}', [PrivateLessonRatingsController::class, 'update'])->name('update');
        });
        Route::delete('/{id}', [PrivateLessonRatingsController::class, 'delete'])->name('delete');
        Route::post('/operation', [PrivateLessonRatingsController::class, 'operation'])->name('operation');
    });

    Route::group(['prefix' => 'private_lesson_requests', 'as' => 'PrivateLessonRequests.','middleware' => 'permission:show_private_lessons'], function() {
        Route::get('/', [PrivateLessonRequestsController::class, 'index'])->name('index');
        Route::post('/respond', [PrivateLessonRequestsController::class, 'respondToRequest'])->name('respond');
        Route::get('/data', [PrivateLessonRequestsController::class, 'getDataTable'])->name('data');

        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function() {
            Route::get('/{id}', [PrivateLessonRequestsController::class, 'edit'])->name('index');
            Route::post('/{id}', [PrivateLessonRequestsController::class, 'update'])->name('update');
        });
    });
  

    //private_lessons
    Route::group(['prefix' => 'packages', 'as' => 'packages.', 'middleware' => 'permission:show_private_lessons'], function () {
        Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
            Route::get('/', [PackagesController::class, 'create'])->name('index');
            Route::post('/', [PackagesController::class, 'store'])->name('store');
        });

        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [PackagesController::class, 'edit'])->name('index');
            Route::post('/{id}', [PackagesController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [PackagesController::class, 'index'])->name('index');
            Route::get('/data', [PackagesController::class, 'getDataTable'])->name('data');
        });

        Route::delete('/{id}', [PackagesController::class, 'delete'])->name('delete');
    });


    //Course students
    Route::group(['prefix' => 'course-students', 'as' => 'courseStudents.',
        'middleware' => 'permission:show_course_students'], function () {

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [CourseStudentsController::class, 'index'])->name('index');
            Route::get('/data', [CourseStudentsController::class, 'getDataTable'])->name('data');
        });

        Route::group(['prefix' => 'course', 'as' => 'course.'], function () {
            Route::get('/{course_id}', [CourseStudentsController::class, 'course'])->name('index');
            Route::get('/data/{course_id}', [CourseStudentsController::class, 'getDataTableCourse'])->name('data');
        });

        Route::group(['prefix' => 'create/', 'as' => 'create.'], function () {
            Route::get('/', [CourseStudentsController::class, 'create'])->name('index');
            Route::post('/', [CourseStudentsController::class, 'store'])->name('store');
        });
        Route::delete('/{id}', [CourseStudentsController::class, 'delete'])->name('delete');
        Route::get('/get-course-info', [CourseStudentsController::class, 'getCourseInfo'])->name('getCourseInfo');
        Route::post('/operation', [CourseStudentsController::class, 'operation'])->name('operation');
    });

    Route::group(['prefix' => 'course_session_requests', 'as' => 'CourseSessionRequests.', 'middleware' => 'permission:show_courses'], function() {
    
        Route::get('/', [CoursesSessionsController::class, 'index'])->name('index');
        Route::post('/respond', [CoursesSessionsController::class, 'respondToRequest'])->name('respond');
        Route::get('/data', [CoursesSessionsController::class, 'getDataTable'])->name('data');

        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function() {
            Route::get('/{id}', [CoursesSessionsController::class, 'edit'])->name('index');
            Route::post('/{id}', [CoursesSessionsController::class, 'update'])->name('update');
        });
    });

    //certificateTemplates
    Route::group(['prefix' => 'certificate-templates',
        'as' => 'certificateTemplates.', 'middleware' => 'permission:show_certificate_templates'], function () {
        Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
            Route::get('/', [CertificateTemplatesController::class, 'create'])->name('index');
            Route::post('/', [CertificateTemplatesController::class, 'store'])->name('store');
        });

        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [CertificateTemplatesController::class, 'edit'])->name('index');
            Route::post('/{id}', [CertificateTemplatesController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [CertificateTemplatesController::class, 'index'])->name('index');
            Route::get('/data', [CertificateTemplatesController::class, 'getDataTable'])->name('data');
        });

        Route::delete('/{id}', [CertificateTemplatesController::class, 'delete'])->name('delete');
        Route::post('/operation', [CertificateTemplatesController::class, 'operation'])->name('operation');

        Route::get('/certificate-test-issuance/{id}', [CertificateTemplatesController::class , 'certificateTestIssuance'])->name('certificateTestIssuance');
    });

    //Translation
    Route::group(['prefix' => 'translation/{lang}', 'as' => 'translation.', 'middleware' => 'permission:show_languages'], function () {
        Route::group(['prefix' => 'all', 'as' => 'index.'], function () {
            Route::get('/', [TranslationController::class, 'index'])->name('index');
            Route::post('/', [TranslationController::class, 'update'])->name('update');
        });
    });

    //transactios
    Route::group(['prefix' => 'transactios', 'as' => 'transactios.' ,
        'middleware' => 'permission:show_transactions'  ], function () {
        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [TransactiosController::class, 'index'])->name('index');
            Route::get('/data', [TransactiosController::class, 'getDataTable'])->name('data');
        });
        Route::post('/refund/{id}', [RefundsController::class, 'makeRefund'])->name('refund');
        Route::delete('/{id}', [TransactiosController::class, 'delete'])->name('delete');
    });

    //notifications
    Route::group(['prefix' => 'notifications', 'as' => 'notifications.' ,
        'middleware' => 'permission:show_notifications'  ], function () {
        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [NotificationsController::class, 'index'])->name('index');
            Route::get('/data', [NotificationsController::class, 'getDataTable'])->name('data');
        });
        Route::delete('/{id}', [NotificationsController::class, 'delete'])->name('delete');
        Route::get('read/{id}', [NotificationsController::class, 'read'])->name('read');
        Route::get('readAll', [NotificationsController::class, 'readAll'])->name('readAll');
    });

    //WithdrawalRequests
    Route::group(['prefix' => 'withdrawal-requests', 'as' => 'withdrawalRequests.',
        'middleware' => 'permission:show_withdrawal_requests'], function () {
        Route::group(['prefix' => 'view', 'as' => 'view.'], function () {
            Route::get('/{id}', [WithdrawalRequestsController::class, 'view'])->name('index');
            Route::post('/{id}', [WithdrawalRequestsController::class, 'update'])->name('update');
        });
        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [WithdrawalRequestsController::class, 'index'])->name('index');
            Route::get('/data', [WithdrawalRequestsController::class, 'getDataTable'])->name('data');
        });
    });



    //marketers joining requests
    Route::group(['prefix' => 'marketers-joining-requests', 'as' => 'marketersJoiningRequests.',
        'middleware' => 'permission:show_marketers_joining_requests'], function () {


        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [MarketersJoiningRequestsController::class, 'edit'])->name('index');
            Route::post('/{id}', [MarketersJoiningRequestsController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [MarketersJoiningRequestsController::class, 'index'])->name('index');
            Route::get('/data', [MarketersJoiningRequestsController::class, 'getDataTable'])->name('data');
        });

        Route::delete('/{id}', [MarketersJoiningRequestsController::class, 'delete'])->name('delete');
    });



    //marketersTemplates
    Route::group(['prefix' => 'marketers-templates',
        'as' => 'marketersTemplates.', 'middleware' => 'permission:show_marketers_templates'], function () {
        Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
            Route::get('/', [MarketersTemplatesController::class, 'create'])->name('index');
            Route::post('/', [MarketersTemplatesController::class, 'store'])->name('store');
        });

        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [MarketersTemplatesController::class, 'edit'])->name('index');
            Route::post('/{id}', [MarketersTemplatesController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [MarketersTemplatesController::class, 'index'])->name('index');
            Route::get('/data', [MarketersTemplatesController::class, 'getDataTable'])->name('data');
        });

        Route::delete('/{id}', [MarketersTemplatesController::class, 'delete'])->name('delete');
        Route::post('/operation', [MarketersTemplatesController::class, 'operation'])->name('operation');
    });



    //coupons
    Route::group(['prefix' => 'coupons', 'as' => 'coupons.', 'middleware' => 'permission:show_coupons'], function () {
        Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
            Route::get('/', [CouponsController::class, 'create'])->name('index');
            Route::post('/', [CouponsController::class, 'store'])->name('store');
        });

        Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
            Route::get('/{id}', [CouponsController::class, 'edit'])->name('index');
            Route::post('/{id}', [CouponsController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'all', 'as' => 'all.'], function () {
            Route::get('/', [CouponsController::class, 'index'])->name('index');
            Route::get('/data', [CouponsController::class, 'getDataTable'])->name('data');
        });

        Route::delete('/{id}', [CouponsController::class, 'delete'])->name('delete');
        Route::post('/operation', [CouponsController::class, 'operation'])->name('operation');
    });

    Route::get('/update-session-price',[AdminCourseSessionsController::class,'updateSessionPrice']);  

});
