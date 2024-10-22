<?php

namespace Database\Seeders;

use App\Models\HomePageSettings;
use Illuminate\Database\Seeder;

class HomePageSettingsSeeder extends Seeder
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
                'section_key' => 'statistics',
                'title'=>'قسم الاحصائيات    ',

            ],
            [
                'section_key' => 'our_service',
                'title'=>'قسم من خدماتنا    ',

            ],
            [
                'section_key' => 'latest_courses',
                'title'=>'أحـدث الدورات    ',

            ],
            [
                'section_key' => 'our_teachers',
                'title'=>'من مدربيــنـا    ',

            ],
            [
                'section_key' => 'how_its_work',
                'title'=>'قسم كيف يعمل ',

            ],
            [
                'section_key' => 'students_opinions',
                'title'=>'قسم اراء الطلاب    ',

            ],
            [
                'section_key' => 'our_partner',
                'title'=>'قسم شركائنا    ',

            ],
            [
                'section_key' => 'our_messages',
                'title'=>'رسالتنا     ',

            ],
            [
                'section_key' => 'our_teams',
                'title'=>'فريقنا     ',

            ],
        ];

        $order_num=1;
        foreach ($sections as $section) {
            $is_found = HomePageSettings::where('section_key', $section['section_key'])->first();
            if (!$is_found) {
                $new_section = new HomePageSettings();
                $new_section->title = $section['title'];
                $new_section->section_key = $section['section_key'];
                $new_section->order_num=$order_num;
                $new_section->save();
                $order_num++;
            }
        }
    }
}
