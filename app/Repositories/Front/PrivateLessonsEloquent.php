<?php

namespace App\Repositories\Front;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\View;
use App\Models\Ratings;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PrivateLessonsEloquent
{

    public function index($request)
    {
        $data = $this->getData($request);

        $data['materials']  = Category::getCategoriesByParent('course_categories')->get();

        $data['languages']  = Category::getCategoriesByParent('course_languages')->get();

        $data['countries']  = Category::getCategoriesByParent('countries')->get();

        $data['maxMinValue'] = DB::table('users')->selectRaw('
                (SELECT MIN(COALESCE(hour_price, 0)) FROM users) as min_price,
                (SELECT MAX(COALESCE(hour_price, 0)) FROM users) as max_price
            ')->first();

        // $data['maxMinValue'] = CategoryPrice::selectRaw('
        //         (SELECT LEAST( COALESCE(online_price, 0), COALESCE(offline_price, 0), COALESCE(online_group_price, 0), COALESCE(offline_group_price, 0))) as min_price,
        //         (SELECT GREATEST( COALESCE(online_price, 0), COALESCE(offline_price, 0), COALESCE(online_group_price, 0), COALESCE(offline_group_price, 0) )) as max_price
        //     ')->first();

        // dd($data['lecturers'][0]->country->name);
        return $data;
    }

    public function getData($request, $count_items=9)
    {

        $data['lecturers'] = User::where('role', 'lecturer')
            ->whereHas('teacherPrivateLessons', function ($q) {
                $q->activeLessons();
            })->with('materials', 'languages', 'motherLang')
            ->orderBy('id', 'asc');


        $name = $request->get('name');
        if ($name != '') {
            $data['lecturers'] = $data['lecturers']->filterByName($name);
        }

        try {
            $material_ids = $request->get('material_ids');
            if ($material_ids) {
                $data['lecturers'] = $data['lecturers']->filterByMaterials(json_decode($material_ids));
            }
        } catch (\Exception $e) {
        }

        try {
            $language_ids = $request->get('language_ids');
            if ($language_ids) {
                $data['lecturers'] = $data['lecturers']->filterByLanguages(json_decode($language_ids));
            }
        } catch (\Exception $e) {
        }

        // try {
        //     $mother_language_ids = $request->get('mother_language_ids');
        //     if ($mother_language_ids) {
        //         $data['lecturers'] = $data['lecturers']->filterByMotherLanguage(json_decode($mother_language_ids));
        //     }
        // } catch (\Exception $e) {
        // }

        try {
            $genders = $request->get('genders');
            if ($genders) {
                $data['lecturers'] = $data['lecturers']->filterByGender(json_decode($genders));
            }
        } catch (\Exception $e) {
        }

        try {
            $countries = $request->get('countries');
            if ($countries) {
                $data['lecturers'] = $data['lecturers']->filterByCountry(json_decode($countries));
            }
        } catch (\Exception $e) {
        }

        try {
            $lecturer_types = $request->get('lecturer_types');
            if ($lecturer_types) {
                $data['lecturers'] = $data['lecturers']->filterByLecturerType(json_decode($lecturer_types));
            }
        } catch (\Exception $e) {
        }

        try {
            $price_from = $request->get('price_from');
            $price_to = $request->get('price_to');
            if ($price_from != '' || $price_to != '') {
                $data['lecturers'] = $data['lecturers']->filterByLessonPrice($price_from, $price_to);
            }
        } catch (\Exception $e) {
        }

        $data['lecturers'] = $data['lecturers']->paginate($count_items);

        return $data;
    }

    public function getLectureRating($id)
    {
        $lectureRate = Ratings::select("ratings")->where('sourse_id', $id)->where('sourse_type', 'user')->sum('rate');

        return $lectureRate;
    }
}
