<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [

            [
                'key' => 'blog_categories',
                'title' => 'تصنيفات المدونة',
            ],
            [
                'key' => 'course_levels',
                'title' => 'مستويات الدورة',
            ],
            [
                'key' => 'course_languages',
                'title' => 'لغات الدورة',
            ],
            [
                'key' => 'course_categories',
                'title' => 'تصنيفات الدورة',
            ],
            [
                'key' => 'countries',
                'title' => 'الدول',
            ],
            [
                'key' => 'age_categories',
                'title' => 'الفئات العمرية',
            ],
            [
                'key' => 'joining_certificates',
                'title' => 'الشهادات ',
            ],
            [
                'key' => 'joining_course',
                'title' => 'المواد ',
            ],
            [
                'key' => 'joining_sections',
                'title' => 'تخصصات المدرب ',
            ],
            [
                'key' => 'banks',
                'title' => 'البنوك',
            ],
            [
                'key' => 'social_media_items',
                'title' => 'مواقع السوشيال ميديا',
            ],
            [
                'key' => 'course_sub_categories',
                'title' => 'التصنيفات الفرعية للدورة',
            ],

        ];
        foreach ($categories as $category) {

            $is_found = Category::where('key', $category['key'])->first();
            if (!$is_found) {
                Category::create([
                    'key' => $category['key'],
                    'title' =>  $category['title'],
                ]);
            }
        }
    }
}
