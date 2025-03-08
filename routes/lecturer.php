<?php

use App\Http\Controllers\Front\User\CourseSessionsController;
use App\Http\Controllers\Panel\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\User\HomeController;
use App\Http\Controllers\Front\User\Lecturer\CoursesController as LecturerCoursesController;
use App\Http\Controllers\Front\User\Lecturer\CurriculumCreationController;
use App\Http\Controllers\Front\User\Lecturer\FinancialRecordController;
use App\Http\Controllers\Front\User\Lecturer\HomeController as LecturerHomeController;
use App\Http\Controllers\Front\User\Lecturer\LecturerPrivateLessonsController;
use App\Http\Controllers\Front\User\Lecturer\LecturerSettingsController;

Route::group(['middleware' => ['auth:web', 'checkIsLecturer', 'shareGeneralSettings']], function () {
    Route::group(['middleware' => 'checkActiveUser'], function () {
        Route::get('/get-attachment-modal', [LecturerCoursesController::class, 'getAttachmentModal'])->name('get_attachment_modal');
        Route::post('/delete-attachment',[LecturerCoursesController::class,'deleteAttachemnt'])->name('delete_attachment');
        Route::post('/add-attachment',[LecturerCoursesController::class,'addAttachemnt'])->name('add_attachment');
        //home
        Route::group(['prefix' => 'home', 'as' => 'home.'], function () {
            Route::get('/', [HomeController::class, 'index'])->name('index');
        });
        Route::group(['prefix' => 'live', 'as' => 'live.'], function () {
            Route::get('live/create/{session_id}',     [LecturerCoursesController::class , 'createLiveSession'])->name('createLiveSession');
        });
        //course sessions
        //  Route::get('/ratings', [LecturerHomeController::class , 'ratings'])->name('ratings');
        //my courses
        /*  Route::group(['prefix' => 'my-courses', 'as' => 'my_courses.'], function () {
            Route::get('/', [LecturerHomeController::class , 'myCourses'])->name('index');
            Route::get('/quizzes', [LecturerHomeController::class , 'quizzes'])->name('quizzes.all');
            Route::get('/quizz-students', [LecturerHomeController::class , 'quizz_students'])->name('quizzes.students');
            Route::get('/tasks', [LecturerHomeController::class , 'tasks'])->name('tasks.all');
            Route::get('/task-students', [LecturerHomeController::class , 'task_students'])->name('tasks.students');
            Route::get('/ratings', [LecturerHomeController::class , 'myCoursesratings'])->name('ratings');
            Route::get('/student-activity', [LecturerHomeController::class , 'studentActivity'])->name('student_activity');
            Route::get('/certificates', [LecturerHomeController::class , 'certificates'])->name('certificates');

        });*/

        // Old routes for New Course Frontend
        // Route::group(['prefix' => 'course', 'as' => 'course.'], function () {

        //     Route::post('/store', [LecturerHomeController::class, 'AddCourse'])->name('store');
        //     Route::get('/create/{active_tab?}', [LecturerHomeController::class, 'createCourse'])->name('create');

        //     Route::group(['prefix' => 'price', 'as' => 'price.'], function () {
        //         Route::post('/set', [LecturerHomeController::class, 'addPrice'])->name('set_price');
        //     });

        //     Route::group(['prefix' => 'faqs', 'as' => 'faqs.'], function () {
        //         Route::post('/set', [LecturerHomeController::class, 'addFaq'])->name('set_faq');
        //     });
        // });


        //Settings
        Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
            Route::get('/{active_tab?}', [LecturerSettingsController::class, 'index'])->name('index');
            Route::post('/update', [LecturerSettingsController::class, 'update'])->name('update');
            Route::group(['prefix' => 'experty', 'as' => 'experty.'], function () {
                Route::post('/set', [LecturerSettingsController::class, 'setExperty'])->name('set');
                Route::post('/delete', [LecturerSettingsController::class, 'deleteExperty'])->name('delete');
            });
            Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
                Route::post('/set', [LecturerSettingsController::class, 'setCategory'])->name('set');
                Route::post('/delete', [LecturerSettingsController::class, 'deleteCategory'])->name('delete');
            });
        });


        //students
        Route::group(['prefix' => 'students', 'as' => 'students.'], function () {
            Route::get('/', [LecturerHomeController::class, 'students'])->name('index');
            Route::post('/filter',  [LecturerHomeController::class, 'studentsFilter'])->name('filter');
            Route::get('/{id}/courses', [LecturerHomeController::class, 'studentCourses'])->name('student.courses');
            Route::get('/{id}/lessons', [LecturerHomeController::class, 'studentLessons'])->name('student.lessons');
        });



        //financial-record
        Route::group(['prefix' => 'financial-record', 'as' => 'financialRecord.'], function () {
            Route::get('/', [FinancialRecordController::class, 'index'])
                ->name('index');

            Route::group(['prefix' => 'withdrawal-requests', 'as' => 'withdrawalRequests.'], function () {
                Route::post('/cancel-request', [FinancialRecordController::class, 'cancelRequest'])
                    ->name('cancel');
                Route::post('/store-request', [FinancialRecordController::class, 'storeRequest'])
                    ->name('store');
            });
        });

        //Private Lessons
        Route::group(['prefix' => 'private-lessons', 'as' => 'private_lessons.'], function () {
            Route::post('/filter',  [LecturerPrivateLessonsController::class, 'filter'])->name('filter');
            Route::post('delete',   [LecturerPrivateLessonsController::class, 'delete'])->name('delete');
            Route::post('/set',     [LecturerPrivateLessonsController::class, 'set'])->name('set'); // MA Delete

            Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
                Route::get('/',  [LecturerPrivateLessonsController::class, 'create'])->name('index'); // MA Delete
            });
            Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
                Route::get('/{id}',  [LecturerPrivateLessonsController::class, 'edit'])->name('index');
            });
            /*
            Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
                Route::get('/', [LecturerPrivateLessonsController::class, 'settings'])->name('index');
                Route::post('/', [LecturerPrivateLessonsController::class, 'storeSettings'])->name('store');
                Route::post('/store/prices', [LecturerPrivateLessonsController::class, 'storeCategoriesPrices'])->name('store-prices');
            });*/
            Route::group(['prefix' => 'meeting', 'as' => 'meeting.'], function () {
                // create and join a meeting
                Route::get('/create/{id}', [LecturerPrivateLessonsController::class, 'createMeeting'])->name('create');

                //joinMeeting
                Route::get('/join/{id}', [LecturerPrivateLessonsController::class, 'joinMeeting'])->name('join');
            });

            Route::get('/{type?}',         [LecturerPrivateLessonsController::class, 'index'])->name('index');
        });

        Route::get('/update-session-price', [LecturerCoursesController::class, 'updateSessionPrice']);
        //courses
         Route::group(['prefix' => 'my-courses', 'as' => 'my_courses.'], function () {

             Route::get('/grade-levels/children', [CategoryController::class, 'getChildren'])->name('category_child');

             Route::get('/', [LecturerCoursesController::class , 'myCourses'])->name('index');
            Route::get('/my-live-lessons/', [LecturerCoursesController::class , 'myLiveLessons'])->name('my_live_lessons');
            Route::get('/create', [LecturerCoursesController::class , 'create'])->name('create');
            Route::post('/create', [LecturerCoursesController::class , 'store'])->name('store');
            Route::get('/quizzes', [LecturerHomeController::class , 'quizzes'])->name('quizzes.all');
            Route::get('/quizz-students', [LecturerHomeController::class , 'quizz_students'])->name('quizzes.students');
            Route::get('/tasks/{course_id}', [LecturerCoursesController::class , 'tasks'])->name('tasks.all');
            Route::get('/task-students/{task_id}', [LecturerCoursesController::class , 'task_students'])->name('tasks.students');
            Route::post('/submitMark',[LecturerCoursesController::class,'submitMark'])->name('tasks.submitMark');
            Route::post('/submitResult',[LecturerCoursesController::class,'submitResult'])->name('tasks.submitResults');
            Route::get('/comments/{course_id}', [LecturerCoursesController::class, 'comments'])->name('comments');
            Route::post('comment/delete/{comment_id}', [LecturerCoursesController::class, 'deleteComment'])->name('delete_comment');
            Route::post('comment/operation', [LecturerCoursesController::class, 'publish_comment'])->name('comment_publish');
            Route::get('/exams/{course_id}', [LecturerCoursesController::class , 'exams'])->name('exams.all');
            Route::get('/exam-students/{exam_id}', [LecturerCoursesController::class , 'exam_students'])->name('exams.students');
            //   Route::get('/ratings', [LecturerCoursesController::class , 'myCoursesratings'])->name('ratings');
            Route::get('all/ratings/{course_id}', [LecturerCoursesController::class , 'viewRatings'])->name('viewRatings.index');
            Route::get('/student-activity', [LecturerHomeController::class , 'studentActivity'])->name('student_activity');
            Route::get('/certificates', [LecturerHomeController::class , 'certificates'])->name('certificates');
            Route::delete('/delete-course-file/{img_id}/lesson_attachments', [CurriculumCreationController::class, 'deleteCourseAttachment'])
              ->name('delete-course-file');
            Route::post('delete-course', [LecturerCoursesController::class, 'deleteCourse'])->name('delete_course');
             Route::get('/{id}', [LecturerCoursesController::class, 'publish'])->name('publish');

            Route::get('/create/curriculum/{id}', [LecturerCoursesController::class, 'courseCurriculum'])->middleware('CheckCourseWaitingEvaluation')->name('create_curriculum');
            Route::get('/waiting-evaluation/{id}', [LecturerCoursesController::class, 'waitingEvaluation'])->name('waiting_evaluation');
            Route::get('/evaluation-unaccepted/{id}', [LecturerCoursesController::class, 'unacceptedEvaluation'])->name('unaccepted_evaluation');

            Route::group(['prefix' => 'edit', 'as' => 'edit.', 'middleware' => 'CheckCourseWaitingEvaluation'], function () {
                Route::group(['prefix' => 'course_schedule', 'as' => 'courseSchedule.'], function () {
                    Route::get('/{id}', [LecturerCoursesController::class, 'editCourseSchedule'])->name('index');
                    Route::get('/preview/{id}', [LecturerCoursesController::class, 'previewCourseSchedule'])->name('preview');
                    Route::post('/{id}', [LecturerCoursesController::class, 'updateCourseSchedule'])->name('update');
                });
                Route::group(['prefix' => 'request-review', 'as' => 'requestReview.'], function () {
                    Route::post('/{id}', [LecturerCoursesController::class, 'updateRequestReview'])->name('update');
                });

                //information
                Route::group(['prefix' => 'base-information', 'as' => 'baseInformation.'], function () {
                    Route::get('/{id}', [LecturerCoursesController::class, 'edit'])->name('index');
                    Route::post('/{id}', [LecturerCoursesController::class, 'update'])->name('update');
                });

                //price details
                Route::group(['prefix' => 'price-details', 'as' => 'priceDetails.'], function () {
                    Route::get('/{id}', [LecturerCoursesController::class, 'editPriceDetails'])->name('index');
                    Route::post('/{id}', [LecturerCoursesController::class, 'updatePriceDetails'])->name('update');
                });

                //content details
                Route::group(['prefix' => 'content-details', 'as' => 'contentDetails.'], function () {
                    Route::get('/{id}/{type}', [LecturerCoursesController::class, 'editContentDetails'])->name('index');
                    Route::post('/{id}/{type}', [LecturerCoursesController::class, 'updateContentDetails'])->name('update');
                });

                //course-faqs
                Route::group(['prefix' => 'course-faqs', 'as' => 'courseFaqs.'], function () {
                    Route::get('/{id}', [LecturerCoursesController::class, 'editCourseFaqs'])->name('index');
                    Route::post('/{id}', [LecturerCoursesController::class, 'updateCourseFaqs'])->name('update');
                });

                //welcome-text-for-registration
                Route::group(['prefix' => 'welcome-text-for-registration', 'as' => 'welcomeTextForRegistration.'], function () {
                    Route::get('/{id}', [LecturerCoursesController::class, 'editWelcomeTextForRegistration'])->name('index');
                    Route::post('/{id}', [LecturerCoursesController::class, 'updateWelcomeTextForRegistration'])->name('update');
                });
                //suggested dates
                Route::group(['prefix' => 'suggested-dates', 'as' => 'suggestedDates.'], function () {
                    Route::get('/{id}', [LecturerCoursesController::class, 'editSuggestedDates'])->name('index');
                    Route::post('/{id}', [LecturerCoursesController::class, 'updateSuggestedDates'])->name('update');
                });

                //requirements
                Route::group(['prefix' => 'requirements', 'as' => 'requirements.'], function () {
                    Route::get('/{id}', [LecturerCoursesController::class, 'editCourseRequirements'])->name('index');
                    Route::post('/{id}', [LecturerCoursesController::class, 'updatetCourseeRequirements'])->name('update');
                });
            });
        });

        // Curriculum Routes
        Route::group(['prefix' => 'course-curriculum', 'as' => 'course.curriculum.'], function () {

            Route::group(['prefix' => 'preview', 'middleware' => ['CheckCanPreviewCourseCurriculum'], 'as' => 'preview.'], function () {
                Route::get('/{course_id}',         [LecturerCoursesController::class , 'previewCourse'])->name('index');
            });

            Route::group(['prefix' => 'preview-curriculum', 'middleware' => ['CheckCanPreviewCourseCurriculum'], 'as' => 'preview_curriculum.'], function () {
                Route::get('/item/{course_id}/{curclm_item_id?}/{section_item_id?}',         [LecturerCoursesController::class , 'curriculumItem'])->name('item');
                Route::get('/open-item/{course_id}/{type}/{id}',                [LecturerCoursesController::class , 'openLearnPageByItemId'])->name('openByItem');
                Route::get('/navigation/{type}/{course_id}/{curclm_item_id?}/{section_item_id?}',   [LecturerCoursesController::class , 'Navigation'])->name('navigation');
            });

            // show modal
            Route::get('/get-lesson-modal', [CurriculumCreationController::class, 'getLessonModal'])->name('get_lesson_modal');
            Route::get('/get-exam-modal', [CurriculumCreationController::class, 'getExamModal'])->name('get_exam_modal');
            Route::get('/get-task-modal', [CurriculumCreationController::class, 'getTaskModal'])->name('get_task_modal');
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
                Route::post('/set', [CurriculumCreationController::class, 'addLiveLesson'])->name('set_live_lesson');
                Route::post('/update', [CurriculumCreationController::class, 'updateLiveLesson'])->name('update_live_lesson');
                Route::post('/delete', [CurriculumCreationController::class, 'deleteLiveLesson'])->name('delete_live_lesson');
                Route::post('outer/delete', [CurriculumCreationController::class, 'deleteOuterLiveLesson'])->name('delete_outer_live_lesson');
                Route::get('/create-meeting/{id}', [LecturerCoursesController::class, 'createMeeting'])->name('create.meeting');
                Route::get('/join-meeting/{id}', [LecturerCoursesController::class, 'joinMeeting'])->name('join.meeting');
                Route::get('/show-record/{id}', [LecturerCoursesController::class, 'showRecording'])->name('show.recording');
                Route::group(['prefix' => 'requests', 'as' => 'requests.'], function () {
                    Route::get('/request', [CourseSessionsController::class, 'request'])->name('request');
                    Route::post('/cancel', [CourseSessionsController::class, 'storeCancelRequest'])->name('cancel');
                    Route::post('/postpone', [CourseSessionsController::class, 'storePostponeRequest'])->name('postpone');
                    Route::post('/respond', [CourseSessionsController::class, 'respondToRequest'])->name('respond');
                });
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
                Route::post('/correct', [LecturerCoursesController::class, 'correctTask'])->name('correct_assignment');
            });
        });
    });
});
