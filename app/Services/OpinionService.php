<?php

namespace App\Services;

use App\Models\StudentsOpinions;

class OpinionService extends MainService
{



    function lastOpinions(){

        $opinions = StudentsOpinions::take(10)->get();

        return $opinions;

    }

    function allOpinions(){
        $opinions = StudentsOpinions::paginate(10);
        return $opinions;
    }



}
