<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'show_home',
            'show_inbox',
            'show_sliders',
            'show_statistics',
            'show_faqs',
            'show_settings',
            'show_pages',
            'show_admins',
            'show_roles',
            'show_categories',
            'show_users',
            'show_login_activity',
            'show_languages',
            'show_posts',
            'show_posts_comments',
            "show_post_category",
            'show_home_page_sections',
            'show_work_steps',
            'show_students_opinions',
            'show_our_services',
            'show_our_partners',
            'show_our_messages',
            'show_our_teams',
            'show_courses',
            'show_course_levels',
            'show_course_languages',
            'show_course_comments',
            'show_course_categories',
            "show_countries",
            "show_age_categories",
            "show_join_as_teacher_requests",
            "show_joining_certificates",
            "show_private_lessons",
            "show_private_lesson_ratings",
            "show_course_students",
            "show_course_ratings",
            "show_joining_sections",
            "show_joining_course",
            "show_withdrawal_requests",
            "show_transactions",
            "show_notifications",
            "show_add_course_requests",
            "show_banks",
            'show_coupons',
            'show_marketers_joining_requests',
            'show_marketers_templates',
            'show_grade_levels'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'admin']);
        }

        if (!Admin::where('email', 'info@admin.com')->first()) {

            $admin_role = new Role();
            $admin_role->name = "admins";
            $admin_role->guard_name = "admin";
            $admin_role->save();
            $admin_role->givePermissionTo($permissions);

            $admin = new Admin();
            $admin->name = 'Admin';
            $admin->email = 'info@admin.com';
            $admin->password = Hash::make('123456');
            $admin->save();

            $admin->assignRole($admin_role);
        } else {
            $admin_role = Role::where('name', 'admins')->first();
            $admin_role->givePermissionTo($permissions);
        }
    }
}
