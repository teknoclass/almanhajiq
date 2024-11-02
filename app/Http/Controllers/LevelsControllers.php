<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class LevelsControllers extends Controller
{
    public function getSubLevels($id)
    {
        $data =  Category::where('parent', 'grade_levels')->where('parent_id',$id)->get();

        return response()->json($data);
    }

    public function getMaterials($id)
    {
        $data =  Category::where('parent', 'joining_course')->where('grade_sub_level_id',$id)->get();

        return response()->json($data);
    }
}
