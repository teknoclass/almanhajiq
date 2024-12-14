<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $college = Category::updateOrCreate([
            'key' => 'grade_levels',
            'value' => 4
        ]);

        CategoryTranslation::create([
            'name' => 'جامعى',
            'category_id' => $college->id,
            'locale' => 'ar'
        ]);

        CategoryTranslation::create([
            'name' => 'universal',
            'category_id' => $college->id,
            'locale' => 'en'
        ]);
    }
}
