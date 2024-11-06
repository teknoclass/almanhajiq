<?php

namespace App\Repositories\Front;

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\View;
use App\Models\Ratings;
use App\Models\Courses;
use App\Models\LecturerExpertise;
use App\Models\LecturerSetting;
use App\Models\UserCourse;
use Illuminate\Database\Eloquent\Builder;

class LecturersEloquent
{
    private $agesRange;
    public function index($request)
    {
        $data = $this->getData($request);

        // materials
        $parent = Category::select('id', 'value', 'parent', 'key')->where('key', "joining_course")->first();
        $data['materials'] = Category::query()->select('id', 'value', 'parent', 'key')->where('parent', $parent->key)
        ->orderByDesc('created_at')->with(['translations:category_id,name,locale', 'parent'])->get();

        $data['languages']  = Category::getCategoriesByParent('course_languages')->get();

        $data['countries']  = Category::getCategoriesByParent('countries')->get();

        return $data;
    }

    public function getData($request, $count_itmes=8)
    {

        $data['lecturers'] = User::where('role', 'lecturer')
             ->where('is_validation', 1)
            ->orderBy('id', 'desc')
            ->with(['LecturerSetting', 'motherLang', 'ratings']);

        $data['lecturers_has_lessons'] = User::where('role', 'lecturer')
            ->whereHas('teacherPrivateLessons', function ($q) {
                $q->activeLessons();
            })
            ->get()->pluck('id')->toArray();

        $data['lecturers_has_lessons2'] = User::where('role', 'lecturer')
            ->has('LecturerTimeTableAvailable')
            ->get()->pluck('id')->toArray();


        $name = $request->get('name');
        if ($name!='') {
            $data['lecturers'] = $data['lecturers']->filterByTitle($name);
        }

        $gender = $request->get('gender');
        if ($gender!='') {
            $data['lecturers'] = $data['lecturers']->filterByGender($gender);
        }

        $lecturer_type = $request->get('lecturer_type');
        if ($lecturer_type!='') {
            if ($lecturer_type == 'yes' || $lecturer_type == 'no') {

                $lecturer_type == 'yes' ? $lecturer_type = "1" : $lecturer_type = "0";

                $data['lecturers'] = $data['lecturers']->FilterByLecturerType($lecturer_type);
            }
        }

        try {
            $countries = $request->get('country_ids');
            if ($countries) {
                $data['lecturers'] = $data['lecturers']->filterByCountry(json_decode($countries));
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

        try {
            $material_ids = $request->get('material_ids');
            if ($material_ids) {
                $data['lecturers'] = $data['lecturers']->filterByMaterials(json_decode($material_ids));
            }
        } catch (\Exception $e) {
        }

        $data['lecturers'] = $data['lecturers']->paginate(9);

        return $data;
    }

    public function getLectureRating($id)
    {
        $lectureRate = Ratings::select("ratings")->where('sourse_id', $id)->where('sourse_type', 'user')->sum('rate');

        return $lectureRate;
    }
}
