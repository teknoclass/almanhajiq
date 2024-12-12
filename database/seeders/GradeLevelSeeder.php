<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $level = Category::updateOrCreate([
            'key' => 'grade_levels',
            'value' => 1
        ]);

        $level = Category::updateOrCreate([
            'key' => 'grade_levels',
            'value' => 2
        ]);

        $level = Category::updateOrCreate([
            'key' => 'grade_levels',
            'value' => 2
        ]);

        $level = Category::updateOrCreate([
            'key' => 'grade_levels',
            'value' => 2
        ]);
    }
}
