<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class LevelsControllers extends Controller
{

    // public function getLevels($id)
    // {
    //     $value = Category::find($id)->first()->value ?? '';
        
    //     $data = Category::where('key', 'grade_levels');

    //     return response()->json($data);
    // }

    public function getSubLevels($id)
    {
        $data =  Category::where('parent', 'grade_levels')->where('value',$id)->get();

        return response()->json($data);
    }
}
