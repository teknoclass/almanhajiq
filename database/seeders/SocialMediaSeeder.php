<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SocialMedia;
use Illuminate\Support\Facades\Hash;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $social_media = [
            [
                'key' => 'facebook',
                'name' => 'فيسبوك',
                'icon' => 'fa-facebook',
                'class' => 'fa'
            ],
            [
                'key' => 'twitter',
                'name' => 'تويتر',
                'icon' => 'fa-twitter',
                'class' => 'ta'
            ],
            [
                'key' => 'instagram',
                'name' => 'انستغرام',
                'icon' => 'fa-instagram',
                'class' => 'in'
            ],
            [
                'key' => 'youtube',
                'name' => 'يويتوب',
                'icon' => 'fa-youtube',
                'class' => 'yo'
            ],
            [
                'key' => 'snapchat',
                'name' => 'سناب شات',
                'icon' => 'fa-snapchat',
                'class' => 'sn'
            ]
        ];

        foreach ($social_media as $sm) {

            $social = SocialMedia::where('key', $sm['key'])->first();
            if (!$social) {
                SocialMedia::create([
                    'key' => $sm['key'],
                    'name' =>  $sm['name'],
                    'icon' =>  $sm['icon'],
                    'class' =>  $sm['class'],
                ]);
            }
        }
    }
}

