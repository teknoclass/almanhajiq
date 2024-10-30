@php
    $tabs = [
        [
            'name' => __('home'),
            'type' => '',
            'href' => route('panel.home'),
            'id' => 'general_settings',
            'type' => '/admin',
            'permissions' => 'show_home',
            'icon' => '/assets/panel/media/icons/duotone/Home/Home.svg',
            'sub_menu' => [],
            'site' => 'admin',
        ],
        [
            'name' => __('contact_us_message'),
            'type' => '',
            'href' => route('panel.inbox.all.index'),
            'id' => 'general_settings',
            'permissions' => 'show_inbox',
            'type' => '/admin/inbox/all',
            'icon' => '/assets/panel/media/icons/duotone/Communication/Active-call.svg',
            'sub_menu' => [],
            'site' => 'inbox',
        ],
        [
            'name' => __('course_section'),
            'type' => 'headeing_menu',
            'href' => 'javascript:',
            'id' => '',
            'all_permissions' => [
                'show_courses',
                'show_course_levels',
                'show_course_languages',
                'show_course_categories',
            ],
            'icon' => '/assets/panel/media/icons/duotone/Home/Home.svg',
            'sub_menu' => [],
        ],
        [
            'name' => __('add_course_requests'),
            'type' => '',
            'href' => route('panel.addCourseRequests.all.index'),
            'permissions' => 'show_add_course_requests',
            'icon' => '/assets/panel/media/icons/duotone/Tools/Pantone.svg',
            'sub_menu' => [],
        ],
        [
            'name' => __('courses'),
            'type' => '',
            'href' => 'javascript:;',
            'id' => 'pages',
            'permissions' => 'show_courses',
            'all_permissions' => ['show_courses'],
            'icon' => '/assets/panel/media/icons/duotone/Communication/Archive.svg',
            'sub_menu' => [
                [
                    'name' => __('all'),
                    'type' => '',
                    'href' => route('panel.courses.all.index'),
                    'permissions' => 'show_courses',
                    'all_permissions' => ['show_courses'],
                    'sub_menu' => [],
                ],
                [
                    'name' => __('add_course'),
                    'type' => '',
                    'href' => route('panel.courses.create.index'),
                    'permissions' => 'show_courses',
                    'sub_menu' => [],
                ],
                [
                    'name' => __('course_comments'),
                    'type' => '',
                    'href' => route('panel.courseComments.all.index'),
                    'permissions' => 'show_course_comments',
                    'sub_menu' => [],
                ],
                [
                    'name' => __('course_ratings'),
                    'type' => '',
                    'href' => route('panel.courseRatings.all.index'),
                    'permissions' => 'show_course_ratings',
                    'sub_menu' => [],
                ],
                            [
                    'name' => __('private_lessons_requests'),
                    'type' => 'private_lessons_requests',
                    'href' => route('panel.CourseSessionRequests.index'),
                    'permissions' => 'show_private_lessons',
                    'sub_menu' => [],
                ]
            ],
        ],
        [
            'name' => __('students'),
            'type' => '',
            'href' => 'javascript:;',
            'permissions' => 'show_course_students',
            'all_permissions' => ['show_course_students'],
            'icon' => '/assets/panel/media/icons/duotone/Interface/Grid.svg',
            'sub_menu' => [
                [
                    'name' => __('all'),
                    'type' => '',
                    'href' => route('panel.courseStudents.all.index'),
                    'permissions' => 'show_course_students',
                    'all_permissions' => ['show_course_students'],
                    'sub_menu' => [],
                ],
                [
                    'name' => __('add_student'),
                    'type' => '',
                    'href' => route('panel.courseStudents.create.index'),
                    'permissions' => 'show_course_students',
                    'sub_menu' => [],
                ],
            ],
        ],

        [
            'name' => __('packages'),
            'type' => '',
            'href' => 'javascript:;',
            'id' => 'pages',
            'permissions' => 'show_packages',
            'all_permissions' => ['show_packages'],
            'icon' => '/assets/panel/media/icons/duotone/Files/File-done.svg',
            'sub_menu' => [
                [
                    'name' => __('all'),
                    'type' => '',
                    'href' => route('panel.packages.all.index'),
                    'permissions' => 'show_packages',
                    'all_permissions' => ['show_packages'],
                    'sub_menu' => [],
                ],
                [
                    'name' => __('add_package'),
                    'type' => '',
                    'href' => route('panel.packages.create.index'),
                    'permissions' => 'show_packages',
                    'sub_menu' => [],
                ],
            ],
        ],
        [
            'name' => __('certificate_templates'),
            'type' => '',
            'href' => 'javascript:;',
            'permissions' => 'show_certificate_templates',
            'all_permissions' => ['show_certificate_templates'],
            'icon' => '/assets/panel/media/icons/duotone/\Design/Interselect.svg',
            'sub_menu' => [
                [
                    'name' => __('all'),
                    'type' => '',
                    'href' => route('panel.certificateTemplates.all.index'),
                    'permissions' => 'show_certificate_templates',
                    'all_permissions' => ['show_course_students'],
                    'sub_menu' => [],
                ],
                [
                    'name' => __('add_certificate_template'),
                    'type' => '',
                    'href' => route('panel.certificateTemplates.create.index'),
                    'permissions' => 'show_certificate_templates',
                    'sub_menu' => [],
                ],
            ],
        ],
        [
            'name' => __('course_category'),
            'type' => '',
            'href' => 'javascript:;',
            'id' => 'pages',
            'permissions' => 'show_course_categories',
            'all_permissions' => ['show_course_categories'],
            'icon' => '/assets/panel/media/icons/duotone/Communication/Thumbtack.svg',
            'sub_menu' => [
                [
                    'name' => __('all'),
                    'type' => '',
                    'href' => route('panel.categories.all.index', ['parent' => 'course_categories']),
                    'permissions' => 'show_course_categories',
                    'all_permissions' => ['show_course_categories'],
                    'sub_menu' => [],
                ],
                [
                    'name' => __('add'),
                    'type' => '',
                    'href' => route('panel.categories.create.index', ['parent' => 'course_categories']),
                    'permissions' => 'show_pages',
                    'sub_menu' => [],
                ],
            ],
        ],
        [
            'name' => __('course_languages'),
            'type' => '',
            'href' => 'javascript:;',
            'id' => 'pages',
            'permissions' => 'show_course_languages',
            'all_permissions' => ['show_course_languages'],
            'icon' => '/assets/panel/media/icons/duotone/Devices/Server.svg',
            'sub_menu' => [
                [
                    'name' => __('all'),
                    'type' => '',
                    'href' => route('panel.categories.all.index', ['parent' => 'course_languages']),
                    'permissions' => 'show_course_languages',
                    'all_permissions' => ['show_course_languages'],
                    'sub_menu' => [],
                ],
                [
                    'name' => __('add'),
                    'type' => '',
                    'href' => route('panel.categories.create.index', ['parent' => 'course_languages']),
                    'permissions' => 'show_course_languages',
                    'sub_menu' => [],
                ],
            ],
        ],
        [
            'name' =>__('grade_levels'),
            'type' => '',
            'href' => 'javascript:;',
            'id' => 'pages',
            'permissions' => 'show_grade_levels',
            'all_permissions' => ['show_grade_levels'],
            'icon' => '/assets/panel/media/icons/duotone/Devices/Server.svg',
            'sub_menu' => [
                [
                    'name' => __('all'),
                    'type' => '',
                    'href' => route('panel.categories.all.index', ['parent' => 'grade_levels']),
                    'permissions' => 'show_grade_levels',
                    'all_permissions' => ['show_grade_levels'],
                    'sub_menu' => [],
                ],
                [
                    'name' => __('add'),
                    'type' => '',
                    'href' => route('panel.categories.create.index', ['parent' => 'grade_levels']),
                    'permissions' => 'show_grade_levels',
                    'sub_menu' => [],
                ],
            ],
        ],
        [
            'name' => __('course_levels'),
            'type' => '',
            'href' => 'javascript:;',
            'id' => 'pages',
            'permissions' => 'show_course_levels',
            'all_permissions' => ['show_course_levels'],
            'icon' => '/assets/panel/media/icons/duotone/Files/Pictures2.svg',
            'sub_menu' => [
                [
                    'name' => __('all'),
                    'type' => '',
                    'href' => route('panel.categories.all.index', ['parent' => 'course_levels']),
                    'permissions' => 'show_course_levels',
                    'all_permissions' => ['show_course_languages'],
                    'sub_menu' => [],
                ],
                [
                    'name' => __('add'),
                    'type' => '',
                    'href' => route('panel.categories.create.index', ['parent' => 'course_levels']),
                    'permissions' => 'show_course_levels',
                    'sub_menu' => [],
                ],
            ],
        ],
        [
            'name' => __('age_categories'),
            'type' => '',
            'href' => 'javascript:;',
            'id' => 'pages',
            'permissions' => 'show_age_categories',
            'all_permissions' => ['show_age_categories'],
            'icon' => '/assets/panel/media/icons/duotone/Communication/Urgent-mail.svg',
            'sub_menu' => [
                [
                    'name' => __('all'),
                    'type' => '',
                    'href' => route('panel.categories.all.index', ['parent' => 'age_categories']),
                    'permissions' => 'show_age_categories',
                    'all_permissions' => ['show_course_languages'],
                    'sub_menu' => [],
                ],
                [
                    'name' => __('add'),
                    'type' => '',
                    'href' => route('panel.categories.create.index', ['parent' => 'age_categories']),
                    'permissions' => 'show_age_categories',
                    'sub_menu' => [],
                ],
            ],
        ],

        [
            'name' => __('web_pages'),
            'type' => 'headeing_menu',
            'href' => 'javascript:',
            'id' => '',
            'all_permissions' => ['show_faqs', 'show_pages', 'show_posts', 'show_posts_comments', 'show_post_category'],
            'icon' => '/assets/panel/media/icons/duotone/Home/Home.svg',
            'sub_menu' => [],
        ],
        [
            'name' => __('home_edit'),
            'type' => '',
            'href' => 'javascript:;',
            'id' => 'pages',
            'permissions' => 'show_pages',
            'all_permissions' => [
                'show_sliders',
                'show_our_partners',
                'show_work_steps',
                'show_our_services',
                'show_statistics',
                'show_students_opinions',
                'show_our_messages',
                'show_our_teams',
            ],
            'icon' => '/assets/panel/media/icons/duotone/Devices/Homepod.svg',
            'sub_menu' => [
                [
                    'name' => __('home_page_sections'),
                    'type' => '',
                    'href' => route('panel.homePageSections.all.index'),
                    'permissions' => 'show_home_page_sections',
                    'sub_menu' => [],
                ],
                [
                    'name' => __('header'),
                    'type' => '',
                    'href' => route('panel.sliders.all.index'),
                    'permissions' => 'show_sliders',
                    'sub_menu' => [],
                ],
                [
                    'name' => __('statistics'),
                    'type' => '',
                    'href' => route('panel.statistics.all.index'),
                    'permissions' => 'show_statistics',
                    'sub_menu' => [],
                ],
                [
                    'name' => __('our_services'),
                    'type' => '',
                    'href' => route('panel.ourServices.all.index'),
                    'permissions' => 'show_our_services',
                    'sub_menu' => [],
                ],
                [
                    'name' => __('work_steps'),
                    'type' => '',
                    'href' => route('panel.workSteps.all.index'),
                    'permissions' => 'show_work_steps',
                    'sub_menu' => [],
                ],
                [
                    'name' => __('students_opinions'),
                    'type' => '',
                    'href' => route('panel.studentsOpinions.all.index'),
                    'permissions' => 'show_students_opinions',
                    'sub_menu' => [],
                ],
                [
                    'name' => __('our_partners'),
                    'type' => '',
                    'href' => route('panel.ourPartners.all.index'),
                    'permissions' => 'show_our_partners',
                    'sub_menu' => [],
                ],
                [
                    'name' => __('our_messages'),
                    'type' => '',
                    'href' => route('panel.ourMessages.all.index'),
                    'permissions' => 'show_our_messages',
                    'sub_menu' => [],
                ],
                [
                    'name' => __('our_teams'),
                    'type' => '',
                    'href' => route('panel.ourTeams.all.index'),
                    'permissions' => 'show_our_teams',
                    'sub_menu' => [],
                ],
                // [
                //     'name' => __('header_student_opinion'),
                //     'type' => '',
                //     'href' => route('panel.sliders.edit.index', ['id' => getStudentOpinionId()]),
                //     'permissions' => 'show_sliders',
                //     'sub_menu' => [],
                // ],
            ],
        ],
        [
            'name' => __('pages'),
            'type' => '',
            'href' => 'javascript:;',
            'id' => 'pages',
            'permissions' => 'show_pages',
            'all_permissions' => ['show_pages'],
            'icon' => '/assets/panel/media/icons/duotone/Interface/Briefcase.svg',
            'sub_menu' => [
                [
                    'name' => __('all'),
                    'type' => '',
                    'href' => route('panel.pages.all.index'),
                    'permissions' => 'show_pages',
                    'all_permissions' => ['show_pages'],
                    'sub_menu' => [],
                ],
                [
                    'name' => __('add_page'),
                    'type' => '',
                    'href' => route('panel.pages.create.index'),
                    'permissions' => 'show_pages',
                    'sub_menu' => [],
                ],
            ],
        ],
        [
            'name' => __('faqs'),
            'type' => '',
            'href' => 'javascript:;',
            'id' => 'pages',
            'permissions' => 'show_faqs',
            'all_permissions' => ['show_faqs'],
            'icon' => '/assets/panel/media/icons/duotone/Home/Air-ballon.svg',
            'sub_menu' => [
                [
                    'name' => __('all'),
                    'type' => '',
                    'href' => route('panel.faqs.all.index'),
                    'permissions' => 'show_faqs',
                    'all_permissions' => ['show_faqs'],
                    'sub_menu' => [],
                ],
                [
                    'name' => __('add_faq'),
                    'type' => '',
                    'href' => route('panel.faqs.create.index'),
                    'permissions' => 'show_faqs',
                    'sub_menu' => [],
                ],
            ],
        ],
        [
            'name' => __('post'),
            'type' => '',
            'href' => 'javascript:;',
            'id' => 'pages',
            'permissions' => 'show_posts',
            'all_permissions' => ['show_posts', 'show_posts_comments', 'show_post_category'],
            'icon' => '/assets/panel/media/icons/duotone/Files/Folder-solid.svg',
            'sub_menu' => [
                [
                    'name' => __('all'),
                    'type' => '',
                    'href' => route('panel.posts.all.index'),
                    'permissions' => 'show_posts',
                    'all_permissions' => ['show_pages'],
                    'sub_menu' => [],
                ],
                [
                    'name' => __('add_post'),
                    'type' => '',
                    'href' => route('panel.posts.create.index'),
                    'permissions' => 'show_posts',
                    'sub_menu' => [],
                ],
                [
                    'name' => __('post_comments'),
                    'type' => '',
                    'href' => route('panel.postsComments.all.index'),
                    'permissions' => 'show_posts_comments',
                    'sub_menu' => [],
                ],
                [
                    'name' => __('post_category'),
                    'type' => '',
                    'href' => route('panel.categories.all.index', ['parent' => 'blog_categories']),
                    'permissions' => 'show_post_category',
                    'sub_menu' => [],
                ],
            ],
        ],
        [
            'name' => __('join_as_teacher_requests'),
            'type' => 'headeing_menu',
            'href' => 'javascript:',
            'id' => '',
            'all_permissions' => ['show_join_as_teacher_requests', 'show_joining_certificates', 'show_countries'],
            'icon' => '/assets/panel/media/icons/duotone/Home/Home.svg',
            'sub_menu' => [],
        ],
        [
            'name' => __('join_as_teacher_requests'),
            'type' => '',
            'href' => route('panel.joinAsTeacherRequests.all.index'),
            'permissions' => 'show_join_as_teacher_requests',
            'icon' => '/assets/panel/media/icons/duotone/Tools/Pantone.svg',
            'sub_menu' => [],
        ],
        [
            'name' => __('certificates_join_as_teacher'),
            'type' => '',
            'href' => 'javascript:;',
            'id' => 'pages',
            'permissions' => 'show_joining_certificates',
            'all_permissions' => ['show_joining_certificates'],
            'icon' => '/assets/panel/media/icons/duotone/Tools/Roller.svg',
            'sub_menu' => [
                [
                    'name' => __('all'),
                    'type' => '',
                    'href' => route('panel.categories.all.index', ['parent' => 'joining_certificates']),
                    'permissions' => 'show_joining_certificates',
                    'all_permissions' => ['show_joining_certificates'],
                    'sub_menu' => [],
                ],
                [
                    'name' => __('add'),
                    'type' => '',
                    'href' => route('panel.categories.create.index', ['parent' => 'joining_certificates']),
                    'permissions' => 'show_joining_certificates',
                    'sub_menu' => [],
                ],
            ],
        ],
        [
            'name' => __('sections'),
            'type' => '',
            'href' => 'javascript:;',
            'id' => 'pages',
            'permissions' => 'show_joining_sections',
            'all_permissions' => ['show_joining_sections'],
            'icon' => '/assets/panel/media/icons/duotone/Tools/Roller.svg',
            'sub_menu' => [
                [
                    'name' => __('all'),
                    'type' => '',
                    'href' => route('panel.categories.all.index', ['parent' => 'joining_sections']),
                    'permissions' => 'show_joining_sections',
                    'all_permissions' => ['show_joining_sections'],
                    'sub_menu' => [],
                ],
                [
                    'name' => __('add'),
                    'type' => '',
                    'href' => route('panel.categories.create.index', ['parent' => 'joining_sections']),
                    'permissions' => 'show_joining_sections',
                    'sub_menu' => [],
                ],
            ],
        ],
        [
            'name' => __('materials'),
            'type' => '',
            'href' => 'javascript:;',
            'id' => 'pages',
            'permissions' => 'show_joining_course',
            'all_permissions' => ['show_joining_course'],
            'icon' => '/assets/panel/media/icons/duotone/Tools/Roller.svg',
            'sub_menu' => [
                [
                    'name' => __('all'),
                    'type' => '',
                    'href' => route('panel.categories.all.index', ['parent' => 'joining_course']),
                    'permissions' => 'show_joining_course',
                    'all_permissions' => ['show_joining_course'],
                    'sub_menu' => [],
                ],
                [
                    'name' => __('add'),
                    'type' => '',
                    'href' => route('panel.categories.create.index', ['parent' => 'joining_course']),
                    'permissions' => 'show_joining_course',
                    'sub_menu' => [],
                ],
            ],
        ],
        [
            'name' => __('join_as_marketer_requests'),
            'type' => 'headeing_menu',
            'href' => 'javascript:',
            'id' => '',
            'all_permissions' => ['show_marketers_joining_requests', 'show_marketers_templates'],
            'icon' => '/assets/panel/media/icons/duotone/Home/Home.svg',
            'sub_menu' => [],
        ],
        [
            'name' => __('join_as_marketer_requests'),
            'type' => '',
            'href' => route('panel.marketersJoiningRequests.all.index'),
            'permissions' => 'show_marketers_joining_requests',
            'icon' => '/assets/panel/media/icons/duotone/Tools/Pantone.svg',
            'sub_menu' => [],
        ],
        [
            'name' => 'مواقع السوشيال ميديا',
            'type' => '',
            'href' => 'javascript:;',
            'id' => 'pages',
            'permissions' => 'show_categories',
            'all_permissions' => ['show_categories'],
            'icon' => '/assets/panel/media/icons/duotone/Tools/Roller.svg',
            'sub_menu' => [
                [
                    'name' => __('all'),
                    'type' => '',
                    'href' => route('panel.categories.all.index', ['parent' => 'social_media_items']),
                    'permissions' => 'show_categories',
                    'all_permissions' => ['show_categories'],
                    'sub_menu' => [],
                ],
                [
                    'name' => __('add'),
                    'type' => '',
                    'href' => route('panel.categories.create.index', ['parent' => 'social_media_items']),
                    'permissions' => 'show_categories',
                    'sub_menu' => [],
                ],
            ],
        ],
        [
            'name' => __('users'),
            'type' => 'headeing_menu',
            'href' => 'javascript:',
            'id' => '',
            'all_permissions' => ['show_users', 'show_admins', 'show_roles', 'show_login_activity'],
            'icon' => '/assets/panel/media/icons/duotone/Home/Home.svg',
            'sub_menu' => [],
        ],
        [
            'name' => __('users'),
            'type' => '',
            'href' => 'javascript:;',
            'id' => 'users',
            'permissions' => 'show_users',
            'icon' => '/assets/panel/media/icons/duotone/General/User.svg',
            'all_permissions' => ['show_users'],
            'sub_menu' => [
                [
                    'name' => __('all'),
                    'type' => '',
                    'href' => route('panel.users.all.index'),
                    'permissions' => 'show_users',
                    'sub_menu' => [],
                ],

                [
                    'name' => __('add_user'),
                    'type' => '',
                    'href' => route('panel.users.create.index'),
                    // 'href' => 'javascript:;',
                    'permissions' => 'show_users',
                    'sub_menu' => [],
                ],
            ],
        ],
        [
            'name' => __('admins'),
            'type' => '',
            'href' => 'javascript:;',
            'id' => 'admins',
            'permissions' => 'show_admins',
            'icon' => '/assets/panel/media/icons/duotone/Interface/User.svg',
            'all_permissions' => ['show_admins', 'show_roles'],
            'sub_menu' => [
                [
                    'name' => __('all'),
                    'type' => '',
                    'href' => route('panel.admins.all.index'),
                    'permissions' => 'show_admins',
                    'sub_menu' => [],
                ],
                [
                    'name' => __('add_admin'),
                    'type' => '',
                    'href' => route('panel.admins.create.index'),
                    'permissions' => 'show_admins',
                    'sub_menu' => [],
                ],
            ],
        ],
        [
            'name' => __('roles'),
            'type' => '',
            'href' => 'javascript:;',
            'id' => 'admins',
            'permissions' => 'show_roles',
            'icon' => '/assets/panel/media/icons/duotone/Files/User-folder.svg',
            'all_permissions' => ['show_roles'],
            'sub_menu' => [
                [
                    'name' => __('all'),
                    'type' => '',
                    'href' => route('panel.roles.all.index'),
                    'permissions' => 'show_roles',
                    'sub_menu' => [],
                ],
                [
                    'name' => __('add_roles'),
                    'type' => '',
                    'href' => route('panel.roles.create.index'),
                    'permissions' => 'show_roles',
                    'sub_menu' => [],
                ],
            ],
        ],
        [
            'name' => __('user_login_activiy'),
            'type' => '',
            'href' => route('panel.loginActivity.all.index'),
            'id' => 'login_activity',
            'permissions' => 'show_login_activity',
            'icon' => '/assets/panel/media/icons/duotone/Communication/Mail.svg',
            'sub_menu' => [],
        ],
        [
            'name' => __('finance'),
            'type' => 'headeing_menu',
            'href' => 'javascript:',
            'id' => '',
            'all_permissions' => ['show_coupons', 'show_transactions', 'show_withdrawal_requests'],
            'icon' => '/assets/panel/media/icons/duotone/Home/Home.svg',
            'sub_menu' => [],
        ],
        [
            'name' => __('transactions'),
            'type' => '',
            'href' => route('panel.transactios.all.index'),
            'id' => 'transactions',
            'permissions' => 'show_transactions',
            'icon' => '/assets/panel/media/icons/duotone/Shopping/Wallet3.svg',
            'sub_menu' => [],
        ],
        [
            'name' => __('withdrawal_requests'),
            'type' => '',
            'href' => route('panel.withdrawalRequests.all.index'),
            'id' => 'withdrawal_requests',
            'permissions' => 'show_withdrawal_requests',
            'icon' => '/assets/panel/media/icons/duotone/Shopping/Wallet.svg',
            'sub_menu' => [],
        ],
        [
            'name' => 'الكوبونات',
            'type' => '',
            'href' => route('panel.coupons.all.index'),
            'id' => 'coupons',
            'permissions' => 'show_coupons',
            'icon' => '/assets/panel/media/icons/duotone/General/Fire.svg',
            'sub_menu' => [],
        ],
      //  [
        //    'name' => __('banks'),
          //  'type' => '',
            //'href' => 'javascript:;',
           // 'id' => 'pages',
           // 'permissions' => 'show_banks',
           // 'all_permissions' => ['show_banks'],
           // 'icon' => '/assets/panel/media/icons/duotone/Home/Building.svg',
           // 'sub_menu' => [
             //   [
               //     'name' => __('all'),
                 //   'type' => '',
                  //  'href' => route('panel.categories.all.index', ['parent' => 'banks']),
                   // 'permissions' => 'show_banks',
                   // 'all_permissions' => ['show_banks'],
                  //  'sub_menu' => [],
               // ],
               // [
                 //   'name' => __('add'),
                  //  'type' => '',
                  //  'href' => route('panel.categories.create.index', ['parent' => 'banks']),
                  //  'permissions' => 'show_banks',
                  //  'sub_menu' => [],
               // ],
           // ],
        //],
        [
            'name' => __('system_setting'),
            'type' => 'headeing_menu',
            'href' => 'javascript:',
            'id' => '',
            'all_permissions' => ['show_settings', 'show_languages'],
            'icon' => '/assets/panel/media/icons/duotone/Home/Home.svg',
            'sub_menu' => [],
        ],
        [
            'name' => __('setting'),
            'type' => '',
            'href' => route('panel.settings.index'),
            'permissions' => 'show_settings',
            'icon' => '/assets/panel/media/icons/duotone/Shopping/Settings.svg',
            'sub_menu' => [],
        ],
        [
            'name' => __('languages'),
            'type' => '',
            'href' => route('panel.languages.all.index'),
            'icon' => '/assets/panel/media/icons/duotone/General/Bookmark.svg',
            'permissions' => 'show_languages',
            'sub_menu' => [],
        ],
        [
            'name' => __('countries'),
            'type' => '',
            'href' => 'javascript:;',
            'id' => 'pages',
            'permissions' => 'show_countries',
            'all_permissions' => ['show_countries'],
            'icon' => '/assets/panel/media/icons/duotone/Home/Globe.svg',
            'sub_menu' => [
                [
                    'name' => __('all'),
                    'type' => '',
                    'href' => route('panel.categories.all.index', ['parent' => 'countries']),
                    'permissions' => 'show_countries',
                    'all_permissions' => ['show_countries'],
                    'sub_menu' => [],
                ],
                [
                    'name' => __('add'),
                    'type' => '',
                    'href' => route('panel.categories.create.index', ['parent' => 'countries']),
                    'permissions' => 'show_countries',
                    'sub_menu' => [],
                ],
            ],
        ],
    ];
@endphp


    <!--begin::Aside-->
<div id="kt_aside" class="aside aside-hoverable mt-20 pt-10" data-kt-drawer="true" data-kt-drawer-name="aside"
     data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
     data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="{{ app()->getlocale() == "ar" ? "start" : "end" }}
    "
     data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <!--begin::Logo-->
        <a href="{{ route('panel.home') }}">
            <img alt="Logo" src="{{ imageUrl(getSeting('logo')) }}" class="h-40px logo">
        </a>
        <!--end::Logo-->
        <!--begin::Aside toggler-->
        <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle"
             data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
             data-kt-toggle-name="aside-minimize">
            <!--begin::Svg Icon | path: icons/duotone/Navigation/Angle-double-left.svg-->
            <span class="svg-icon svg-icon-1 rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                     height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                        <path
                            d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z"
                            fill="#000000" fill-rule="nonzero"
                            transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)">
                        </path>
                        <path
                            d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z"
                            fill="#000000" fill-rule="nonzero" opacity="0.5"
                            transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)">
                        </path>
                    </g>
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Aside toggler-->
    </div>
    <!--begin::Aside menu-->
    <div class="aside-menu flex-column-fluid">
        <!--begin::Aside Menu-->
        <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper"
             data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
             data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu"
             data-kt-scroll-offset="0">
            <!--begin::Menu-->
            <div
                class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#kt_aside_menu" data-kt-menu="true">
                @php
                    $menus = $tabs;
                    $currentUrl = request()->url();
                    $currentPath = parse_url($currentUrl, PHP_URL_PATH);
                @endphp
                @foreach ($menus as $menu)
                    @php
                        $contain_word = Str::contains(strtolower($currentPath), strtolower($menu['name']));
                    @endphp
                    @if ($menu['type'] != 'headeing_menu')
                        @if (checkShowMenu($menu))
                            <div class="menu-item {{ count(@$menu['sub_menu']) > 0 ? 'menu-accordion' : '' }} "
                                {{ count(@$menu['sub_menu']) > 0 ? 'data-kt-menu-trigger=click' : '' }}>
                                @if (count(@$menu['sub_menu']) == 0)
                                    <a href="{{ @$menu['href'] }}" class="menu-link {{ @$menu['site'] }}">
                                        <span class="menu-icon">

                                            <img class="" src="{{ @$menu['icon'] }}"/>
                                        </span>
                                        <span class="menu-title">{{ @$menu['name'] }} </span>
                                    </a>
                                @elseif(count(@$menu['sub_menu']) > 0)
                                    @if (checkAllPermissionsAdmin($menu['all_permissions']))
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <img class="" src="{{ @$menu['icon'] }}"/>
                                            </span>
                                            <!--end::Svg Icon-->

                                            <span class="menu-title">{{ @$menu['name'] }} </span>
                                            <span class="menu-arrow"></span>
                                        </span>

                                        <div class="menu-sub menu-sub-accordion menu-active-bg">

                                            @php
                                                $sub_menus = @$menu['sub_menu'];
                                            @endphp
                                            @foreach ($sub_menus as $sub_menu)
                                                @can($sub_menu['permissions'])
                                                    <div class="menu-item {{ @$sub_menu['site'] }}">
                                                        <a class="menu-link" href="{{ $sub_menu['href'] }}">
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">{{ $sub_menu['name'] }} </span>
                                                        </a>
                                                    </div>
                                                @endcan
                                            @endforeach
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @endif
                    @else
                        @if (checkAllPermissionsAdmin($menu['all_permissions']))
                            <li class="headeing_menu mb-5 mt-5">{{ $menu['name'] }}</li>
                        @endif
                    @endif
                @endforeach
                <li class="headeing_menu mb-5 mt-5">{{ __('admin_setting') }}</li>
                <div class="menu-item ">
                    <a href="{{ route('panel.profile.index') }}" class="menu-link gap-3 }}">
                        <span class="menu-icon">
                            <i class="fas fa-cog"></i>
                        </span>
                        <span class="menu-title">{{ __('profile') }} </span>
                    </a>


                </div>

                <div class="menu-item ">
                    <a href="javascript:void(0)"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                       class="menu-link gap-3 }}">
                        <span class="menu-icon">
                            <i class="fas fa-sign-out-alt"></i>
                        </span>
                        <span class="menu-title">{{ __('user_menus.logout') }} </span>
                    </a>
                    <form id="logout-form" action="{{ route('panel.admin.logout') }}" method="POST"
                          style="display: none;">
                        @csrf
                    </form>

                </div>


            </div>
        </div>
    </div>
    <!--end::Aside menu-->
</div>
<!--end::Aside-->

