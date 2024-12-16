<?php

use App\Models\CourseAssignments;
use App\Models\CourseLessons;
use App\Models\CourseQuizzes;
use App\Models\CourseSections;
use App\Models\CourseSession;

return [
    'gender' => [
        'male' => 'male',
        'female' => 'female'
    ],
    'meetingType' => [
        'online' => 'online',
        'offline' => 'offline',
        'both' => 'both'
    ],
    'exp' => [
        'online' => 'online',
        'offline' => 'offline'
    ],
    'have_labtop' => [
        'yes' => 'yes',
        'no' => 'no'
    ],
    'free' => [
        'yes' => 'yes',
        'no' => 'no'
    ],
    'lessons_follow_up' => [
        '1' => 'yes',
        '0' => 'no'
    ],
    'item_types'=> [
        CourseLessons::class  => 'lesson',
        CourseAssignments::class => 'assignment',
        CourseQuizzes::class  => 'quiz',
        CourseSections::class => 'section'

    ],    'item_model_types'=> [
        'App\Models\CourseLessons'  => 'lesson',
        'App\Models\CourseAssignments' => 'assignment',
        'App\Models\CourseQuizzes'  => 'quiz',
        'App\Models\CourseSections' => 'section'

    ],
    'users_type' => [
        [
            'title' => 'الطلاب',
            'name' => 'طالب',
            'key' => 'student',
            'is_default' => true,
        ],
        [
            'title' => 'المدربين',
            'name' => 'محاضر',
            'key' => 'lecturer',
            'is_default' => false,
        ],
        [
            'title' => 'المسوقين',
            'name' => 'مسوق',
            'key' => 'marketer',
            'is_default' => false,
        ],
        [
            'title' => 'أولياء الامور',
            'name' => 'ولى أمر',
            'key' => 'parent',
            'is_default' => false,
        ],
    ],

    'points_withdrawal_request_status' => [
        'acceptable' => 'acceptable',
        'unacceptable' => 'unacceptable',
    ],


    'types_questions_competitions' => [
        [
            'value' => 'addition',
            'title' => 'جمع',
        ],
        [
            'value' => 'multiplication',
            'title' => 'ضرب',
        ],
        [
            'value' => 'division',
            'title' => 'قسمة',
        ],
        [
            'value' => 'subtraction',
            'title' => 'طرح',
        ],

    ],

    'course_types' => [
        [
            'key' => 'recorded',
            'is_default' => true,
        ],
        [
            'key' => 'live',
            'is_default' => false,
        ],

    ],
    'course_status' => [
        [
            'key' => 'being_processed',
            'is_default' => true,
        ],
        [
            'key' => 'ready',
            'is_default' => false,
        ],
        [
            'key' => 'unaccepted',
            'is_default' => false,
        ],
        [
            'key' => 'accepted',
            'is_default' => false,
        ],

    ],
    'meeting_type' => [
        [
            'key' => 'offline',
            'is_default' => false,
        ],
        [
            'key' => 'online',
            'is_default' => false,
        ],
        [
            'key' => 'both',
            'is_default' => true,
        ],
    ],
    'price_types' => [
        [
            'key' => 'free',
        ],
        [
            'key' => 'paid',
        ],
    ],
    'gender_type' => [
        [
            'key' => 'male',
        ],
        [
            'key' => 'female',
        ],
    ],

    'withdrawal_methods' => [
        [
            'key' => 'cash',
            'is_default' => true,
        ],
        [
            'key' => 'bank_transfer',
            'is_default' => false,
        ],
    ],

    'withdrawal_requests_status' => [
        [
            'key' => 'pending',
            'is_default' => true,
            'is_show' => true,
            'change_allowed_when' => []
        ],
        [
            'key' => 'underway',
            'is_default' => false,
            'is_show' => true,
            'change_allowed_when' => ['pending']
        ],
        [
            'key' => 'canceled',
            'is_default' => false,
            'is_show' => false,
            'change_allowed_when' => ['pending', 'underway']
        ],
        [
            'key' => 'unacceptable',
            'is_default' => false,
            'is_show' => true,
            'change_allowed_when' => ['pending', 'underway']
        ],
        [
            'key' => 'completed',
            'is_default' => false,
            'is_show' => true,
            'change_allowed_when' => ['pending', 'underway']
        ],
    ],


    'request_adjournment_session_status' => [
        [
            'key' => 'acceptable',

        ],
        [
            'key' => 'unacceptable',

        ],

    ],

    'days' => [
        1 => [
            'key' => 'saturday',
            'value' => '1',
        ],
        2 => [
            'key' => 'sunday',
            'value' => '2',
        ],
        3 => [
            'key' => 'monday',
            'value' => '3',
        ],
        4 => [
            'key' => 'tuesday',
            'value' => '4',
        ],
        5 => [
            'key' => 'wednesday',
            'value' => '5',
        ],
        6 => [
            'key' => 'thursday',
            'value' => '6',
        ],
        7 => [
            'key' => 'friday',
            'value' => '7',
        ],

    ],
    'private_lessons_status' => [
        'pending' => 'pending',
        'acceptable' => 'acceptable',
        'unacceptable' => 'unacceptable',
        'canceled' => 'canceled'
    ],
    'course_group_request_status' => [
        'acceptable' => 'acceptable',
        'unacceptable' => 'unacceptable',
        'underreview' => 'underreview',
    ],

    'marketers_joining_requests_status' => [
        'acceptable' => 'acceptable',
        'unacceptable' => 'unacceptable',
    ],

    'fixed_texts_templates_certificates' => [
        [
            'type' => 'course_name_location',
            'left' => '50',
            'top' => '40',
            'title' => 'اسم الدورة',
        ],
        [
            'type' => 'lecturer_name_location',
            'left' => '50',
            'top' => '90',
            'title' => 'اسم المحاضر',
        ],
        [
            'type' => 'student_name_location',
            'left' => '50',
            'top' => '140',
            'title' => 'اسم الطالب',
        ],
        [
            'type' => 'certificate_date',
            'left' => '50',
            'top' => '240',
            'title' => 'تاريخ الشهادة',
        ],
    ],

    'free_trial_options' => [
        [
            'title' => 'yes',
            'value' => 1,
            'is_selected' => true,
        ],
        [
            'title' => 'no',
            'value' => 0,
            'is_selected' => false,
        ],
    ],


    'place_pages' => [
        'footer', 'header'
    ],

    'fixed_texts_templates_marketers' => [
        [
            'type' => 'coupon_code',
            'left' => '50',
            'top' => '40',
            'title' => 'كود الكوبون',
        ],

    ],

];
