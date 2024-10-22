<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sliders;

class SilderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $sections = [

            [
                'name' => 'header',
                'title_heading'=>'هيدر الرئيسية',

            ],
            [
                'name' => 'student_opinions',
                'title_heading'=>' هيدر أراء الطلاب ',
            ],

        ];


        foreach ($sections as $section) {
            $is_found = Sliders::where('name', $section['name'])->first();
            if (!$is_found) {
                $new_silder = new Sliders();
                $new_silder->title_heading = $section['title_heading'];
                $new_silder->name = $section['name'];
                $new_silder->can_delete=0;
                $new_silder->image='image.png';
                $new_silder->save();
            }
        }



    }
}
