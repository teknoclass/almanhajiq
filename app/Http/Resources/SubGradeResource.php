<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class SubGradeResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $locale = App::getLocale();
        $translation = collect($this->translations)->firstWhere('locale', $locale ?? 'ar');
        $materials = Category::getCategoriesByParent('course_categories')->get();

        $this->materials = $materials;
        return [
            'id'=>$this->id,
            'name'=> $translation ? $translation->name : $this->name,
           'materials' => collect(new CategoryCollection($this->materials))
        ];
    }
}
