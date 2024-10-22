<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Languages;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $languages = [
            [
                'title' => 'العربية',
                'lang'=>'ar',
                'is_default'=>1,
                'is_rtl'=>1,
                'can_delete'=>0
            ],
        ];

        foreach ($languages as $language) {
            $is_found = Languages::where('lang', $language['lang'])->first();
            if (!$is_found) {
                $new_language = new Languages();
                $new_language->title = $language['title'];
                $new_language->is_default =  $language['is_default'];
                $new_language->is_rtl =  $language['is_rtl'];
                $new_language->lang =  $language['lang'];
                $new_language->can_delete =  $language['can_delete'];
                $new_language->save();
            }
        }
    }
}
