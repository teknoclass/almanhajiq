<?php


namespace App\Services;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\SubGradeCollection;
use App\Http\Resources\GradeLevelCollection;
use App\Models\Category;
use App\Models\Faqs;
use Illuminate\Support\Facades\App;

class SettingService extends MainService
{

    public function getAllSettings()
    {



        $social_media   = Category::getCategoriesByParent('social_media_items')->get();
        $countries   = Category::getCategoriesByParent('countries')->get();
        $gradeLevels   = Category::where('key', 'grade_levels')->get();
        $materials = Category::getCategoriesByParent('course_categories')->get();
        $certificates    = Category::getCategoriesByParent('joining_certificates')->get();
        $specializations = Category::getCategoriesByParent('joining_sections')->get();

        $locale  = App::getLocale();

        $data = [
            'logo' => imageUrl(getSeting('logo')),
            'title' => getSeting("title_$locale"),
            'describe' => getSeting("describe_$locale"),
            'address' => getSeting("address_$locale"),
            'mobile' => getSeting("mobile"),
            'social_media' => !$social_media->isEmpty()?collect(new  CategoryCollection($social_media)):null,
            'countries' => !$countries->isEmpty()?collect(new  CategoryCollection($countries)):null,
            'certificates' => !$certificates->isEmpty()?collect(new  CategoryCollection($certificates)):null,
            'specializations' => !$specializations->isEmpty()?collect(new  CategoryCollection($specializations)):null,
            'grade_levels' => !$gradeLevels->isEmpty()?collect(new  GradeLevelCollection($gradeLevels)):null,
            'materials' => !$materials->isEmpty()?collect(new  CategoryCollection($materials)):null,
        ];

        return $this->createResponse(
            __('message.success'),
            true,
            $data
        );

    }

    public function getAllFaqs(){
        $faqs = Faqs::select('id')->where('type', Faqs::GENERAL)
                            ->with('translations:faqs_id,title,text,locale')->orderByDesc('created_at')->paginate(10);
        if (!$faqs) {
            return $this->createResponse(
                __('message.not_found'),
                false,
                null
            );
        }
        return $this->createResponse(
            __('message.success'),
            true,
            $faqs
        );

    }
}
