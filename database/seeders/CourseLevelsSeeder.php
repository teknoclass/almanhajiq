<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Database\Seeder;

class CourseLevelsSeeder extends Seeder
{ public function run()
{

    $levels = [
        [
            'name' => ['ar' => 'الابتدائي', 'en' => 'Primary'],
            'value' => '1',
            'children' => [
                ['name' => ['ar' => 'الاول الابتدائي', 'en' => 'First Primary'], 'value' => '1'],
                ['name' => ['ar' => 'الثاني الابتدائي', 'en' => 'Second Primary'], 'value' => '1'],
                ['name' => ['ar' => 'الثالث الابتدائي', 'en' => 'Third Primary'], 'value' => '3'],
            ]
        ],
        [
            'name' => ['ar' => 'المتوسطة', 'en' => 'Intermediate'],
            'value' => '2',
            'children' => [
                ['name' => ['ar' => 'الاول المتوسط', 'en' => 'First Intermediate'], 'value' => '1'],
                ['name' => ['ar' => 'الثاني المتوسط', 'en' => 'Second Intermediate'], 'value' => '2'],
                ['name' => ['ar' => 'الثالث المتوسط', 'en' => 'Third Intermediate'], 'value' => '3'],
            ]
        ],
        [
            'name' => ['ar' => 'الاعدادي', 'en' => 'Secondary'],
            'value' => '3',
            'children' => [
                ['name' => ['ar' => 'الاول الاعدادي', 'en' => 'First Secondary'], 'value' => '1'],
                ['name' => ['ar' => 'الثاني الاعدادي', 'en' => 'Second Secondary'], 'value' => '2'],
                ['name' => ['ar' => 'الثالث الاعدادي', 'en' => 'Third Secondary'], 'value' => '3'],
            ]
        ],
        [
            'name' => ['ar' => 'الجامعة', 'en' => 'College'],
            'value' => '4',

        ],
    ];

    foreach ($levels as $level) {
        $parentCategory = Category::create(['parent' => null, 'value' => $level['value'],'key'=>'grade_levels']);

        // Save translations for the parent category
        foreach ($level['name'] as $locale => $name) {
            CategoryTranslation::create([
                'category_id' => $parentCategory->id,
                'locale' => $locale,
                'name' => $name,
            ]);
        }

        foreach ($level['children'] as $child) {
            $childCategory = $parentCategory->children()->create(['parent' => 'grade_levels', 'value' => $child['value'],'parent_id'=>$parentCategory->id]);

            // Save translations for the child category
            foreach ($child['name'] as $locale => $name) {
                CategoryTranslation::create([
                    'category_id' => $childCategory->id,
                    'locale' => $locale,
                    'name' => $name,

                ]);
            }
        }
    }
}}
