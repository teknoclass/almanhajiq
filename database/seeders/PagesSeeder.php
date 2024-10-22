<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pages;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $pages = [
            [
                'sulg' => 'terms_and_conditions',
                'title' => 'الشروط والاحكام',
            ],
            [
                'sulg' => 'privacy_policy',
                'title' => 'سياسة الخصوصية',
            ],
            [
            'sulg' => 'about',
            'title' => 'من نحن',
        ]
        ];

        foreach ($pages as $page) {
            $is_found = Pages::where('sulg', $page['sulg'])->first();
            if (!$is_found) {
                $new_page = new Pages();
                $new_page->sulg = $page['sulg'];
                $new_page->can_delete = 0;
                $new_page->{'title' . ':' . 'ar'} = $page['title'];
                $new_page->{'text' . ':' . 'ar'} = $page['title'];
                $new_page->save();
            }
        }
    }
}
